<?php
namespace JR_Addons\Ajax;

if (!defined('ABSPATH')) {
    exit;
}

class FormSubmitAjax {

    public static function init() {
        add_action('wp_ajax_jr_form_submit', [__CLASS__, 'handle_submit']);
        add_action('wp_ajax_nopriv_jr_form_submit', [__CLASS__, 'handle_submit']);
    }

    /**
     * Main form submit handler
     */
    public static function handle_submit() {
        // Verify nonce
        if (!check_ajax_referer('jr_form_nonce', 'nonce', false)) {
            wp_send_json_error(['message' => 'Security check failed. Please refresh the page.']);
        }

        // Honeypot check (anti-spam)
        if (!empty($_POST['jr_form_hp'])) {
            wp_send_json_error(['message' => 'Spam detected.']);
        }

        // Get form config
        $form_id        = isset($_POST['form_id']) ? sanitize_text_field($_POST['form_id']) : '';
        $form_settings  = isset($_POST['form_settings']) ? json_decode(stripslashes($_POST['form_settings']), true) : [];
        $fields_config  = isset($_POST['fields_config']) ? json_decode(stripslashes($_POST['fields_config']), true) : [];
        $form_data      = isset($_POST['form_data']) ? $_POST['form_data'] : [];

        if (empty($fields_config) || empty($form_settings)) {
            wp_send_json_error(['message' => 'Invalid form configuration.']);
        }

        // Validate & sanitize fields
        $validation = self::validate_fields($fields_config, $form_data);
        if (!empty($validation['errors'])) {
            wp_send_json_error([
                'message' => 'Please fix the errors below.',
                'errors'  => $validation['errors'],
            ]);
        }

        $clean_data = $validation['data'];

        // Handle file uploads
        $uploaded_files = self::handle_file_uploads($fields_config);
        if (!empty($uploaded_files['errors'])) {
            wp_send_json_error([
                'message' => 'File upload failed.',
                'errors'  => $uploaded_files['errors'],
            ]);
        }

        // Merge file data
        foreach ($uploaded_files['files'] as $field_id => $file_urls) {
            $clean_data[$field_id] = $file_urls;
        }

        // Send email
        $sent = self::send_email($form_settings, $fields_config, $clean_data, $uploaded_files['attachments']);

        if (!$sent) {
            wp_send_json_error(['message' => 'Failed to send email. Please try again later.']);
        }

        // Send auto-reply if enabled
        if (!empty($form_settings['auto_reply']) && $form_settings['auto_reply'] === 'yes') {
            self::send_auto_reply($form_settings, $fields_config, $clean_data);
        }

        // Success response
        wp_send_json_success([
            'message'       => $form_settings['success_message'] ?? 'Thank you! Your message has been sent.',
            'redirect_url'  => $form_settings['redirect_url'] ?? '',
            'redirect_time' => $form_settings['redirect_time'] ?? 0,
        ]);
    }

    /**
     * Validate all fields
     */
    private static function validate_fields($fields_config, $form_data) {
        $errors = [];
        $clean  = [];

        foreach ($fields_config as $field) {
            $id       = $field['id'] ?? '';
            $type     = $field['type'] ?? 'text';
            $label    = $field['label'] ?? $id;
            $required = ($field['required'] ?? '') === 'yes';

            if (empty($id)) continue;

            // Skip file fields (handled separately)
            if ($type === 'file') continue;

            $value = $form_data[$id] ?? '';

            // Required check
            if ($required) {
                if (is_array($value)) {
                    if (empty(array_filter($value))) {
                        $errors[$id] = $label . ' is required.';
                        continue;
                    }
                } elseif (trim($value) === '') {
                    $errors[$id] = $label . ' is required.';
                    continue;
                }
            }

            // Skip validation if empty and not required
            if (empty($value) && !$required) {
                $clean[$id] = '';
                continue;
            }

            // Type-specific validation
            switch ($type) {
                case 'email':
                    if (!is_email($value)) {
                        $errors[$id] = 'Please enter a valid email address.';
                    } else {
                        $clean[$id] = sanitize_email($value);
                    }
                    break;

                case 'url':
                    if (!filter_var($value, FILTER_VALIDATE_URL)) {
                        $errors[$id] = 'Please enter a valid URL.';
                    } else {
                        $clean[$id] = esc_url_raw($value);
                    }
                    break;

                case 'number':
                    if (!is_numeric($value)) {
                        $errors[$id] = 'Please enter a valid number.';
                    } else {
                        $clean[$id] = floatval($value);
                    }
                    break;

                case 'tel':
                    $clean[$id] = preg_replace('/[^0-9+\-\s()]/', '', $value);
                    break;

                case 'textarea':
                    $clean[$id] = sanitize_textarea_field($value);
                    break;

                case 'checkbox':
                case 'multi-checkbox':
                    if (is_array($value)) {
                        $clean[$id] = array_map('sanitize_text_field', $value);
                    } else {
                        $clean[$id] = sanitize_text_field($value);
                    }
                    break;

                case 'select':
                case 'radio':
                case 'date':
                case 'time':
                case 'hidden':
                default:
                    $clean[$id] = sanitize_text_field($value);
                    break;
            }
        }

        return [
            'data'   => $clean,
            'errors' => $errors,
        ];
    }

    /**
     * Handle file uploads
     */
    private static function handle_file_uploads($fields_config) {
        $files       = [];
        $attachments = [];
        $errors      = [];

        if (empty($_FILES)) {
            return ['files' => $files, 'attachments' => $attachments, 'errors' => $errors];
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';

        $upload_dir = wp_upload_dir();
        $jr_dir     = $upload_dir['basedir'] . '/jr-form-uploads';

        if (!file_exists($jr_dir)) {
            wp_mkdir_p($jr_dir);
            // Protect directory
            file_put_contents($jr_dir . '/.htaccess', "Options -Indexes\nDeny from all");
            file_put_contents($jr_dir . '/index.html', '');
        }

        foreach ($fields_config as $field) {
            if (($field['type'] ?? '') !== 'file') continue;

            $field_id    = $field['id'];
            $required    = ($field['required'] ?? '') === 'yes';
            $max_size    = isset($field['max_file_size']) ? intval($field['max_file_size']) * 1024 * 1024 : 5 * 1024 * 1024; // MB to bytes
            $allowed     = isset($field['allowed_types']) ? array_map('trim', explode(',', $field['allowed_types'])) : ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
            $allowed     = array_map('strtolower', $allowed);

            if (!isset($_FILES[$field_id])) {
                if ($required) {
                    $errors[$field_id] = ($field['label'] ?? 'File') . ' is required.';
                }
                continue;
            }

            $file = $_FILES[$field_id];

            // Multiple files support
            if (is_array($file['name'])) {
                $file_urls = [];
                $count     = count($file['name']);

                for ($i = 0; $i < $count; $i++) {
                    if (empty($file['name'][$i])) continue;

                    $single_file = [
                        'name'     => $file['name'][$i],
                        'type'     => $file['type'][$i],
                        'tmp_name' => $file['tmp_name'][$i],
                        'error'    => $file['error'][$i],
                        'size'     => $file['size'][$i],
                    ];

                    $result = self::process_single_file($single_file, $jr_dir, $upload_dir, $allowed, $max_size);

                    if (isset($result['error'])) {
                        $errors[$field_id] = $result['error'];
                        break;
                    }

                    $file_urls[]   = $result['url'];
                    $attachments[] = $result['path'];
                }

                $files[$field_id] = $file_urls;
            } else {
                if (empty($file['name'])) {
                    if ($required) {
                        $errors[$field_id] = ($field['label'] ?? 'File') . ' is required.';
                    }
                    continue;
                }

                $result = self::process_single_file($file, $jr_dir, $upload_dir, $allowed, $max_size);

                if (isset($result['error'])) {
                    $errors[$field_id] = $result['error'];
                    continue;
                }

                $files[$field_id] = [$result['url']];
                $attachments[]    = $result['path'];
            }
        }

        return [
            'files'       => $files,
            'attachments' => $attachments,
            'errors'      => $errors,
        ];
    }

    /**
     * Process a single uploaded file
     */
    private static function process_single_file($file, $jr_dir, $upload_dir, $allowed_types, $max_size) {
        // Check upload error
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'File upload error.'];
        }

        // Check file size
        if ($file['size'] > $max_size) {
            return ['error' => 'File size exceeds limit (' . round($max_size / 1024 / 1024, 1) . 'MB).'];
        }

        // Check file extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_types)) {
            return ['error' => 'File type not allowed. Allowed: ' . implode(', ', $allowed_types)];
        }

        // Sanitize filename
        $safe_name = wp_unique_filename($jr_dir, sanitize_file_name($file['name']));
        $dest_path = $jr_dir . '/' . $safe_name;

        // Move file
        if (!move_uploaded_file($file['tmp_name'], $dest_path)) {
            return ['error' => 'Failed to save uploaded file.'];
        }

        $file_url = $upload_dir['baseurl'] . '/jr-form-uploads/' . $safe_name;

        return [
            'url'  => $file_url,
            'path' => $dest_path,
        ];
    }

    /**
     * Send email to admin
     */
    private static function send_email($settings, $fields_config, $data, $attachments = []) {
        $to        = !empty($settings['to_email']) ? $settings['to_email'] : get_option('admin_email');
        $from_name = !empty($settings['from_name']) ? $settings['from_name'] : get_bloginfo('name');
        $from_email = !empty($settings['from_email']) ? $settings['from_email'] : get_option('admin_email');
        $subject   = !empty($settings['email_subject']) ? $settings['email_subject'] : 'New Form Submission';
        $reply_to  = $settings['reply_to'] ?? '';

        // Replace shortcodes in subject
        $subject = self::replace_shortcodes($subject, $fields_config, $data);

        // Build email body
        if (!empty($settings['email_body'])) {
            $body = self::replace_shortcodes($settings['email_body'], $fields_config, $data);
            // Replace {all_fields}
            if (strpos($body, '{all_fields}') !== false) {
                $body = str_replace('{all_fields}', self::build_fields_table($fields_config, $data), $body);
            }
        } else {
            $body = self::build_default_email_body($fields_config, $data);
        }

        // Replace reply_to shortcode
        $reply_to = self::replace_shortcodes($reply_to, $fields_config, $data);

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $from_name . ' <' . $from_email . '>',
        ];

        if (!empty($reply_to) && is_email($reply_to)) {
            $headers[] = 'Reply-To: ' . $reply_to;
        }

        $sent = wp_mail($to, $subject, $body, $headers, $attachments);

        return $sent;
    }

    /**
     * Send auto-reply to user
     */
    private static function send_auto_reply($settings, $fields_config, $data) {
        $user_email_field = $settings['auto_reply_to_field'] ?? '';
        if (empty($user_email_field) || empty($data[$user_email_field])) {
            return false;
        }

        $user_email = $data[$user_email_field];
        if (!is_email($user_email)) return false;

        $from_name  = !empty($settings['from_name']) ? $settings['from_name'] : get_bloginfo('name');
        $from_email = !empty($settings['from_email']) ? $settings['from_email'] : get_option('admin_email');
        $subject    = !empty($settings['auto_reply_subject']) ? $settings['auto_reply_subject'] : 'Thank you for contacting us';
        $body       = !empty($settings['auto_reply_body']) ? $settings['auto_reply_body'] : 'Hi {name},<br><br>Thank you for reaching out. We will get back to you shortly.<br><br>Best regards,<br>' . get_bloginfo('name');

        $subject = self::replace_shortcodes($subject, $fields_config, $data);
        $body    = self::replace_shortcodes($body, $fields_config, $data);

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $from_name . ' <' . $from_email . '>',
        ];

        return wp_mail($user_email, $subject, $body, $headers);
    }

    /**
     * Replace {field_id} shortcodes
     */
    private static function replace_shortcodes($text, $fields_config, $data) {
        if (empty($text)) return $text;

        foreach ($data as $key => $value) {
            $val = is_array($value) ? implode(', ', $value) : $value;
            $text = str_replace('{' . $key . '}', $val, $text);
        }

        // Also support common aliases
        $text = str_replace('{site_name}', get_bloginfo('name'), $text);
        $text = str_replace('{site_url}', home_url(), $text);
        $text = str_replace('{date}', date('F j, Y'), $text);
        $text = str_replace('{time}', date('g:i a'), $text);

        return $text;
    }

    /**
     * Build HTML table of all fields
     */
    private static function build_fields_table($fields_config, $data) {
        $html = '<table style="width:100%; border-collapse:collapse; font-family:Arial,sans-serif;">';

        foreach ($fields_config as $field) {
            $id    = $field['id'] ?? '';
            $label = $field['label'] ?? $id;
            $type  = $field['type'] ?? 'text';

            if (in_array($type, ['html', 'hidden'])) continue;
            if (!isset($data[$id])) continue;

            $value = $data[$id];
            if (is_array($value)) {
                if ($type === 'file') {
                    $value = implode('<br>', array_map(function($url) {
                        return '<a href="' . esc_url($url) . '" target="_blank">' . basename($url) . '</a>';
                    }, $value));
                } else {
                    $value = implode(', ', $value);
                }
            } else {
                $value = nl2br(esc_html($value));
            }

            $html .= '<tr>';
            $html .= '<td style="padding:10px; border:1px solid #ddd; background:#f9f9f9; font-weight:bold; width:30%;">' . esc_html($label) . '</td>';
            $html .= '<td style="padding:10px; border:1px solid #ddd;">' . $value . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';
        return $html;
    }

    /**
     * Build default email body
     */
    private static function build_default_email_body($fields_config, $data) {
        $body  = '<div style="font-family:Arial,sans-serif; max-width:600px; margin:0 auto;">';
        $body .= '<h2 style="color:#1a1a1a; border-bottom:3px solid #FF8C00; padding-bottom:10px;">New Form Submission</h2>';
        $body .= '<p style="color:#666;">You have received a new submission from your website.</p>';
        $body .= self::build_fields_table($fields_config, $data);
        $body .= '<p style="margin-top:20px; padding:15px; background:#f5f5f5; border-radius:6px; color:#666; font-size:13px;">';
        $body .= '<strong>Date:</strong> ' . date('F j, Y \a\t g:i a') . '<br>';
        $body .= '<strong>Site:</strong> ' . get_bloginfo('name') . ' (' . home_url() . ')';
        $body .= '</p>';
        $body .= '</div>';

        return $body;
    }
}