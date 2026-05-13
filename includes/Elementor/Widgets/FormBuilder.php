<?php
namespace JR_Addons\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

class FormBuilder extends Widget_Base {

    public function get_name() {
        return 'jr_form_builder';
    }

    public function get_title() {
        return esc_html__('Form Builder', 'jr-addons');
    }

    public function get_icon() {
        return 'jr-get-icon';
    }

    public function get_categories() {
        return ['jr-addons'];
    }

    public function get_keywords() {
        return ['form', 'contact', 'builder', 'jr', 'submit', 'email', 'file upload'];
    }

    public function get_style_depends() {
        return ['jr-form-builder'];
    }

    public function get_script_depends() {
        return ['jr-form-builder'];
    }

    protected function register_controls() {

        /* ============================================================
         * CONTENT TAB
         * ============================================================ */

        // ──────── SECTION: Form Fields (Repeater) ────────
        $this->start_controls_section('jr_form_fields_section', [
            'label' => esc_html__('Form Fields', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new Repeater();

        $repeater->add_control('field_type', [
            'label'   => esc_html__('Field Type', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'text',
            'options' => [
                'text'           => esc_html__('Text', 'jr-addons'),
                'email'          => esc_html__('Email', 'jr-addons'),
                'tel'            => esc_html__('Phone', 'jr-addons'),
                'number'         => esc_html__('Number', 'jr-addons'),
                'url'            => esc_html__('URL', 'jr-addons'),
                'textarea'       => esc_html__('Textarea', 'jr-addons'),
                'select'         => esc_html__('Select Dropdown', 'jr-addons'),
                'radio'          => esc_html__('Radio', 'jr-addons'),
                'checkbox'       => esc_html__('Checkbox (Single)', 'jr-addons'),
                'multi-checkbox' => esc_html__('Checkbox (Multi)', 'jr-addons'),
                'date'           => esc_html__('Date', 'jr-addons'),
                'time'           => esc_html__('Time', 'jr-addons'),
                'file'           => esc_html__('File Upload', 'jr-addons'),
                'html'           => esc_html__('HTML', 'jr-addons'),
                'hidden'         => esc_html__('Hidden', 'jr-addons'),
            ],
        ]);

        $repeater->add_control('field_label', [
            'label'   => esc_html__('Label', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => 'Field Label',
            'condition' => ['field_type!' => ['html', 'hidden']],
        ]);

        $repeater->add_control('field_id', [
            'label'       => esc_html__('Field ID / Name', 'jr-addons'),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'field_id',
            'description' => esc_html__('Unique ID (no spaces). Used for emails: {field_id}', 'jr-addons'),
        ]);

        $repeater->add_control('field_placeholder', [
            'label'     => esc_html__('Placeholder', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => '',
            'condition' => [
                'field_type' => ['text', 'email', 'tel', 'number', 'url', 'textarea'],
            ],
        ]);

        $repeater->add_control('field_default_value', [
            'label'     => esc_html__('Default Value', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => '',
            'condition' => [
                'field_type!' => ['html', 'select', 'radio', 'checkbox', 'multi-checkbox', 'file'],
            ],
        ]);

        $repeater->add_control('field_required', [
            'label'        => esc_html__('Required', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'jr-addons'),
            'label_off'    => esc_html__('No', 'jr-addons'),
            'return_value' => 'yes',
            'default'      => '',
            'condition'    => ['field_type!' => ['html', 'hidden']],
        ]);

        $repeater->add_control('field_width', [
            'label'   => esc_html__('Field Width', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => '100',
            'options' => [
                '100' => '100% (Full Width)',
                '75'  => '75%',
                '66'  => '66% (2/3)',
                '50'  => '50% (Half)',
                '33'  => '33% (1/3)',
                '25'  => '25% (1/4)',
            ],
        ]);

        $repeater->add_control('field_help_text', [
            'label'     => esc_html__('Help Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXTAREA,
            'rows'      => 2,
            'default'   => '',
            'condition' => ['field_type!' => ['html', 'hidden']],
        ]);

        // Textarea rows
        $repeater->add_control('field_rows', [
            'label'     => esc_html__('Rows', 'jr-addons'),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 4,
            'min'       => 2,
            'max'       => 20,
            'condition' => ['field_type' => 'textarea'],
        ]);

        // Options for select/radio/multi-checkbox
        $repeater->add_control('field_options', [
            'label'       => esc_html__('Options', 'jr-addons'),
            'type'        => Controls_Manager::TEXTAREA,
            'rows'        => 5,
            'default'     => "Option 1\nOption 2\nOption 3",
            'description' => esc_html__('One option per line. Format: value|label or just label', 'jr-addons'),
            'condition'   => [
                'field_type' => ['select', 'radio', 'multi-checkbox'],
            ],
        ]);

        // Single checkbox text
        $repeater->add_control('field_checkbox_text', [
            'label'     => esc_html__('Checkbox Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXTAREA,
            'rows'      => 2,
            'default'   => 'I agree to the terms and conditions',
            'condition' => ['field_type' => 'checkbox'],
        ]);

        // Number min/max/step
        $repeater->add_control('field_min', [
            'label'     => esc_html__('Min Value', 'jr-addons'),
            'type'      => Controls_Manager::NUMBER,
            'condition' => ['field_type' => 'number'],
        ]);

        $repeater->add_control('field_max', [
            'label'     => esc_html__('Max Value', 'jr-addons'),
            'type'      => Controls_Manager::NUMBER,
            'condition' => ['field_type' => 'number'],
        ]);

        $repeater->add_control('field_step', [
            'label'     => esc_html__('Step', 'jr-addons'),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 1,
            'condition' => ['field_type' => 'number'],
        ]);

        // File upload settings
        $repeater->add_control('field_multiple_files', [
            'label'        => esc_html__('Allow Multiple Files', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'jr-addons'),
            'label_off'    => esc_html__('No', 'jr-addons'),
            'return_value' => 'yes',
            'default'      => '',
            'condition'    => ['field_type' => 'file'],
        ]);

        $repeater->add_control('field_allowed_types', [
            'label'       => esc_html__('Allowed File Types', 'jr-addons'),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'jpg,jpeg,png,pdf,doc,docx',
            'description' => esc_html__('Comma separated extensions (no dots)', 'jr-addons'),
            'condition'   => ['field_type' => 'file'],
        ]);

        $repeater->add_control('field_max_file_size', [
            'label'       => esc_html__('Max File Size (MB)', 'jr-addons'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 5,
            'min'         => 1,
            'max'         => 64,
            'condition'   => ['field_type' => 'file'],
        ]);

        $repeater->add_control('field_upload_text', [
            'label'     => esc_html__('Upload Box Text', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'Browse Files',
            'condition' => ['field_type' => 'file'],
        ]);

        $repeater->add_control('field_upload_subtext', [
            'label'     => esc_html__('Upload Subtext', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'Drag and drop files here',
            'condition' => ['field_type' => 'file'],
        ]);

        // HTML field
        $repeater->add_control('field_html', [
            'label'     => esc_html__('HTML Content', 'jr-addons'),
            'type'      => Controls_Manager::TEXTAREA,
            'rows'      => 5,
            'default'   => '<h3>Section Title</h3>',
            'condition' => ['field_type' => 'html'],
        ]);

        // Custom CSS class
        $repeater->add_control('field_css_class', [
            'label'     => esc_html__('Custom CSS Class', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => '',
            'separator' => 'before',
        ]);

        $this->add_control('form_fields', [
            'label'       => esc_html__('Fields', 'jr-addons'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ field_label || field_type }}} ({{{ field_width }}}%)',
            'default'     => [
                [
                    'field_type'        => 'text',
                    'field_label'       => 'First Name',
                    'field_id'          => 'first_name',
                    'field_placeholder' => 'John',
                    'field_required'    => 'yes',
                    'field_width'       => '50',
                ],
                [
                    'field_type'        => 'text',
                    'field_label'       => 'Last Name',
                    'field_id'          => 'last_name',
                    'field_placeholder' => 'Doe',
                    'field_required'    => 'yes',
                    'field_width'       => '50',
                ],
                [
                    'field_type'        => 'email',
                    'field_label'       => 'Email Address',
                    'field_id'          => 'email',
                    'field_placeholder' => 'you@example.com',
                    'field_required'    => 'yes',
                    'field_width'       => '100',
                ],
                [
                    'field_type'        => 'tel',
                    'field_label'       => 'Phone Number',
                    'field_id'          => 'phone',
                    'field_placeholder' => '+1 (555) 000-0000',
                    'field_required'    => '',
                    'field_width'       => '100',
                ],
                [
                    'field_type'        => 'textarea',
                    'field_label'       => 'Your Message',
                    'field_id'          => 'message',
                    'field_placeholder' => 'How can we help you?',
                    'field_required'    => 'yes',
                    'field_width'       => '100',
                    'field_rows'        => 5,
                ],
            ],
        ]);

        $this->end_controls_section();

        // ──────── SECTION: Form Settings ────────
        $this->start_controls_section('jr_form_settings_section', [
            'label' => esc_html__('Form Settings', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('form_title', [
            'label'   => esc_html__('Form Title', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => 'Get In Touch',
        ]);

        $this->add_control('form_subtitle', [
            'label'   => esc_html__('Form Subtitle', 'jr-addons'),
            'type'    => Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => "We'd love to hear from you. Send us a message and we'll respond as soon as possible.",
        ]);

        $this->add_control('show_title', [
            'label'        => esc_html__('Show Title/Subtitle', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'jr-addons'),
            'label_off'    => esc_html__('No', 'jr-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('button_text', [
            'label'   => esc_html__('Submit Button Text', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => 'SEND MESSAGE',
        ]);

        $this->add_control('button_loading_text', [
            'label'   => esc_html__('Loading Text', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => 'SENDING...',
        ]);

        $this->add_control('button_icon', [
            'label'   => esc_html__('Button Icon', 'jr-addons'),
            'type'    => Controls_Manager::ICONS,
            'default' => [
                'value'   => 'fas fa-paper-plane',
                'library' => 'fa-solid',
            ],
        ]);

        $this->add_control('button_icon_position', [
            'label'   => esc_html__('Icon Position', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
                'left'  => esc_html__('Before Text', 'jr-addons'),
                'right' => esc_html__('After Text', 'jr-addons'),
            ],
        ]);

        $this->add_control('button_full_width', [
            'label'        => esc_html__('Full Width Button', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ]);

        $this->add_control('show_labels', [
            'label'        => esc_html__('Show Labels', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('show_required_mark', [
            'label'        => esc_html__('Show * for Required', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->end_controls_section();

        // ──────── SECTION: Email Settings ────────
        $this->start_controls_section('jr_form_email_section', [
            'label' => esc_html__('Email Settings', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('to_email', [
            'label'       => esc_html__('Send To Email', 'jr-addons'),
            'type'        => Controls_Manager::TEXT,
            'default'     => get_option('admin_email'),
            'description' => esc_html__('Multiple emails comma separated', 'jr-addons'),
        ]);

        $this->add_control('from_name', [
            'label'   => esc_html__('From Name', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => get_bloginfo('name'),
        ]);

        $this->add_control('from_email', [
            'label'   => esc_html__('From Email', 'jr-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => get_option('admin_email'),
        ]);

        $this->add_control('reply_to', [
            'label'       => esc_html__('Reply To', 'jr-addons'),
            'type'        => Controls_Manager::TEXT,
            'default'     => '{email}',
            'description' => esc_html__('Use {field_id} to use form value', 'jr-addons'),
        ]);

        $this->add_control('email_subject', [
            'label'       => esc_html__('Email Subject', 'jr-addons'),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'New Form Submission from {first_name}',
            'description' => esc_html__('Use {field_id} for dynamic values', 'jr-addons'),
        ]);

        $this->add_control('email_body', [
            'label'       => esc_html__('Email Body', 'jr-addons'),
            'type'        => Controls_Manager::WYSIWYG,
            'default'     => '<p>You have a new form submission:</p>{all_fields}',
            'description' => esc_html__('Use {field_id} or {all_fields} shortcode', 'jr-addons'),
        ]);

        $this->add_control('auto_reply_heading', [
            'label'     => esc_html__('Auto-Reply to User', 'jr-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('auto_reply', [
            'label'        => esc_html__('Enable Auto-Reply', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ]);

        $this->add_control('auto_reply_to_field', [
            'label'       => esc_html__('User Email Field ID', 'jr-addons'),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'email',
            'description' => esc_html__('Which field contains user email', 'jr-addons'),
            'condition'   => ['auto_reply' => 'yes'],
        ]);

        $this->add_control('auto_reply_subject', [
            'label'     => esc_html__('Auto-Reply Subject', 'jr-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => 'Thank you for contacting us',
            'condition' => ['auto_reply' => 'yes'],
        ]);

        $this->add_control('auto_reply_body', [
            'label'     => esc_html__('Auto-Reply Body', 'jr-addons'),
            'type'      => Controls_Manager::WYSIWYG,
            'default'   => '<p>Hi {first_name},</p><p>Thank you for reaching out. We have received your message and will respond shortly.</p><p>Best regards,<br>{site_name}</p>',
            'condition' => ['auto_reply' => 'yes'],
        ]);

        $this->end_controls_section();

        // ──────── SECTION: Messages & Redirect ────────
        $this->start_controls_section('jr_form_messages_section', [
            'label' => esc_html__('Messages & Redirect', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('success_message', [
            'label'   => esc_html__('Success Message', 'jr-addons'),
            'type'    => Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => 'Thank you! Your message has been sent successfully. We will get back to you soon.',
        ]);
        $this->add_control('hide_form_after_submit', [
            'label'        => esc_html__('Hide Form After Success', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'jr-addons'),
            'label_off'    => esc_html__('No', 'jr-addons'),
            'return_value' => 'yes',
            'default'      => '',
            'description'  => esc_html__('If ON: form & header will hide. If OFF: form resets and stays visible.', 'jr-addons'),
        ]);

        $this->add_control('reset_form_after_submit', [
            'label'        => esc_html__('Reset Form Fields', 'jr-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'jr-addons'),
            'label_off'    => esc_html__('No', 'jr-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => ['hide_form_after_submit!' => 'yes'],
        ]);
        $this->add_control('error_message', [
            'label'   => esc_html__('Generic Error Message', 'jr-addons'),
            'type'    => Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => 'Something went wrong. Please try again.',
        ]);

        $this->add_control('redirect_url', [
            'label'       => esc_html__('Redirect URL after Submit', 'jr-addons'),
            'type'        => Controls_Manager::URL,
            'default'     => ['url' => ''],
            'description' => esc_html__('Leave empty for no redirect', 'jr-addons'),
            'show_external' => false,
        ]);

        $this->add_control('redirect_time', [
            'label'       => esc_html__('Redirect Delay (seconds)', 'jr-addons'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 2,
            'min'         => 0,
            'max'         => 30,
            'condition'   => ['redirect_url[url]!' => ''],
        ]);

        $this->end_controls_section();

        /* ============================================================
         * STYLE TAB
         * ============================================================ */

        // ──────── STYLE: Form Container ────────
        $this->start_controls_section('jr_form_style_container', [
            'label' => esc_html__('Form Container', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'form_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-form-wrapper',
        ]);

        $this->add_responsive_control('form_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'default'    => [
                'top' => '40', 'right' => '40', 'bottom' => '40', 'left' => '40',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors'  => [
                '{{WRAPPER}} .jr-form-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('form_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors'  => [
                '{{WRAPPER}} .jr-form-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'form_border',
            'selector' => '{{WRAPPER}} .jr-form-wrapper',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'form_shadow',
            'selector' => '{{WRAPPER}} .jr-form-wrapper',
        ]);

        $this->add_responsive_control('field_spacing', [
            'label'      => esc_html__('Spacing Between Fields', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 60]],
            'default'    => ['size' => 20, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-form-row' => 'gap: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .jr-form-fields' => 'row-gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ──────── STYLE: Title & Subtitle ────────
        $this->start_controls_section('jr_form_style_title', [
            'label'     => esc_html__('Title & Subtitle', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_title' => 'yes'],
        ]);

        $this->add_responsive_control('title_align', [
            'label'   => esc_html__('Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => ['title' => 'Left', 'icon' => 'eicon-text-align-left'],
                'center' => ['title' => 'Center', 'icon' => 'eicon-text-align-center'],
                'right'  => ['title' => 'Right', 'icon' => 'eicon-text-align-right'],
            ],
            'default'   => 'left',
            'selectors' => ['{{WRAPPER}} .jr-form-header' => 'text-align: {{VALUE}};'],
        ]);

        $this->add_control('title_color', [
            'label'     => esc_html__('Title Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#1a1a1a',
            'selectors' => ['{{WRAPPER}} .jr-form-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'title_typo',
            'selector' => '{{WRAPPER}} .jr-form-title',
        ]);

        $this->add_responsive_control('title_spacing', [
            'label'      => esc_html__('Title Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 50]],
            'default'    => ['size' => 10, 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .jr-form-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_control('subtitle_color', [
            'label'     => esc_html__('Subtitle Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#666666',
            'selectors' => ['{{WRAPPER}} .jr-form-subtitle' => 'color: {{VALUE}};'],
            'separator' => 'before',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'subtitle_typo',
            'selector' => '{{WRAPPER}} .jr-form-subtitle',
        ]);

        $this->add_responsive_control('header_spacing', [
            'label'      => esc_html__('Header Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 80]],
            'default'    => ['size' => 30, 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .jr-form-header' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        // ──────── STYLE: Labels ────────
        $this->start_controls_section('jr_form_style_labels', [
            'label'     => esc_html__('Labels', 'jr-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_labels' => 'yes'],
        ]);

        $this->add_control('label_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#1a1a1a',
            'selectors' => ['{{WRAPPER}} .jr-form-label' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('required_mark_color', [
            'label'     => esc_html__('Required (*) Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#FF8C00',
            'selectors' => ['{{WRAPPER}} .jr-required' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'label_typo',
            'selector' => '{{WRAPPER}} .jr-form-label',
        ]);

        $this->add_responsive_control('label_spacing', [
            'label'      => esc_html__('Bottom Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 30]],
            'default'    => ['size' => 8, 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .jr-form-label' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        // ──────── STYLE: Input Fields ────────
        $this->start_controls_section('jr_form_style_inputs', [
            'label' => esc_html__('Input Fields', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'input_typo',
            'selector' => '{{WRAPPER}} .jr-form-input, {{WRAPPER}} .jr-form-textarea, {{WRAPPER}} .jr-form-select',
        ]);

        $this->add_responsive_control('input_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => [
                'top' => '12', 'right' => '16', 'bottom' => '12', 'left' => '16',
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-form-input, {{WRAPPER}} .jr-form-textarea, {{WRAPPER}} .jr-form-select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('input_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-form-input, {{WRAPPER}} .jr-form-textarea, {{WRAPPER}} .jr-form-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // Input states
        $this->start_controls_tabs('input_states');

        // Normal
        $this->start_controls_tab('input_normal', ['label' => esc_html__('Normal', 'jr-addons')]);

        $this->add_control('input_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#1a1a1a',
            'selectors' => [
                '{{WRAPPER}} .jr-form-input, {{WRAPPER}} .jr-form-textarea, {{WRAPPER}} .jr-form-select' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('input_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .jr-form-input, {{WRAPPER}} .jr-form-textarea, {{WRAPPER}} .jr-form-select' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('input_border_color', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#e0e0e0',
            'selectors' => [
                '{{WRAPPER}} .jr-form-input, {{WRAPPER}} .jr-form-textarea, {{WRAPPER}} .jr-form-select' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('input_border_width', [
            'label'      => esc_html__('Border Width', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 10]],
            'default'    => ['size' => 1, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .jr-form-input, {{WRAPPER}} .jr-form-textarea, {{WRAPPER}} .jr-form-select' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
            ],
        ]);

        $this->add_control('placeholder_color', [
            'label'     => esc_html__('Placeholder Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#999999',
            'selectors' => [
                '{{WRAPPER}} .jr-form-input::placeholder, {{WRAPPER}} .jr-form-textarea::placeholder' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        // Focus
        $this->start_controls_tab('input_focus', ['label' => esc_html__('Focus', 'jr-addons')]);

        $this->add_control('input_focus_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-form-input:focus, {{WRAPPER}} .jr-form-textarea:focus, {{WRAPPER}} .jr-form-select:focus' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('input_focus_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .jr-form-input:focus, {{WRAPPER}} .jr-form-textarea:focus, {{WRAPPER}} .jr-form-select:focus' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('input_focus_border_color', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#FF8C00',
            'selectors' => [
                '{{WRAPPER}} .jr-form-input:focus, {{WRAPPER}} .jr-form-textarea:focus, {{WRAPPER}} .jr-form-select:focus' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('input_focus_shadow', [
            'label'     => esc_html__('Focus Glow Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(255, 140, 0, 0.15)',
            'selectors' => [
                '{{WRAPPER}} .jr-form-input:focus, {{WRAPPER}} .jr-form-textarea:focus, {{WRAPPER}} .jr-form-select:focus' => 'box-shadow: 0 0 0 4px {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ──────── STYLE: Help Text ────────
        $this->start_controls_section('jr_form_style_help', [
            'label' => esc_html__('Help Text', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('help_text_color', [
            'label'     => esc_html__('Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#888888',
            'selectors' => ['{{WRAPPER}} .jr-form-help' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'help_text_typo',
            'selector' => '{{WRAPPER}} .jr-form-help',
        ]);

        $this->end_controls_section();

        // ──────── STYLE: File Upload Box ────────
        $this->start_controls_section('jr_form_style_file', [
            'label' => esc_html__('File Upload Box', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('file_box_bg', [
            'label'     => esc_html__('Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f9fafb',
            'selectors' => ['{{WRAPPER}} .jr-form-file-box' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('file_box_border_color', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#cbd5e1',
            'selectors' => ['{{WRAPPER}} .jr-form-file-box' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('file_box_active_border_color', [
            'label'     => esc_html__('Drag Active Border', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#FF8C00',
            'selectors' => ['{{WRAPPER}} .jr-form-file-box.jr-drag-active' => 'border-color: {{VALUE}}; background-color: rgba(255,140,0,0.05);'],
        ]);

        $this->add_control('file_icon_color', [
            'label'     => esc_html__('Icon Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#94a3b8',
            'selectors' => ['{{WRAPPER}} .jr-form-file-icon svg' => 'stroke: {{VALUE}};'],
        ]);

        $this->add_control('file_text_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#475569',
            'selectors' => ['{{WRAPPER}} .jr-form-file-text' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('file_subtext_color', [
            'label'     => esc_html__('Subtext Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#94a3b8',
            'selectors' => ['{{WRAPPER}} .jr-form-file-subtext' => 'color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('file_box_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => [
                'top' => '40', 'right' => '20', 'bottom' => '40', 'left' => '20',
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-form-file-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ──────── STYLE: Submit Button ────────
        $this->start_controls_section('jr_form_style_button', [
            'label' => esc_html__('Submit Button', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('button_align', [
            'label'   => esc_html__('Alignment', 'jr-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title' => 'Left', 'icon' => 'eicon-text-align-left'],
                'center'     => ['title' => 'Center', 'icon' => 'eicon-text-align-center'],
                'flex-end'   => ['title' => 'Right', 'icon' => 'eicon-text-align-right'],
                'stretch'    => ['title' => 'Justify', 'icon' => 'eicon-text-align-justify'],
            ],
            'default'   => 'flex-start',
            'selectors' => ['{{WRAPPER}} .jr-form-submit-wrap' => 'justify-content: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'button_typo',
            'selector' => '{{WRAPPER}} .jr-form-submit',
        ]);

        $this->add_responsive_control('button_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => [
                'top' => '16', 'right' => '40', 'bottom' => '16', 'left' => '40',
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-form-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('button_radius', [
            'label'      => esc_html__('Border Radius', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default'    => [
                'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8',
                'unit' => 'px', 'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-form-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('button_top_spacing', [
            'label'      => esc_html__('Top Spacing', 'jr-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 80]],
            'default'    => ['size' => 20, 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .jr-form-submit-wrap' => 'margin-top: {{SIZE}}{{UNIT}};'],
        ]);

        $this->start_controls_tabs('button_states');

        $this->start_controls_tab('button_normal', ['label' => esc_html__('Normal', 'jr-addons')]);

        $this->add_control('button_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-form-submit' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'button_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-form-submit',
            'fields_options' => [
                'background' => ['default' => 'classic'],
                'color'      => ['default' => '#FF8C00'],
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'button_border',
            'selector' => '{{WRAPPER}} .jr-form-submit',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'button_shadow',
            'selector' => '{{WRAPPER}} .jr-form-submit',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('button_hover', ['label' => esc_html__('Hover', 'jr-addons')]);

        $this->add_control('button_hover_color', [
            'label'     => esc_html__('Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .jr-form-submit:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'button_hover_bg',
            'types'    => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .jr-form-submit:hover',
            'fields_options' => [
                'background' => ['default' => 'classic'],
                'color'      => ['default' => '#e67e00'],
            ],
        ]);

        $this->add_control('button_hover_border_color', [
            'label'     => esc_html__('Border Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .jr-form-submit:hover' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('button_hover_transform', [
            'label'   => esc_html__('Hover Effect', 'jr-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'lift',
            'options' => [
                'none'  => 'None',
                'lift'  => 'Lift Up',
                'scale' => 'Scale',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ──────── STYLE: Messages ────────
        $this->start_controls_section('jr_form_style_messages', [
            'label' => esc_html__('Success/Error Messages', 'jr-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('success_bg', [
            'label'     => esc_html__('Success Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#d1f4d6',
            'selectors' => ['{{WRAPPER}} .jr-form-message.jr-success' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('success_color', [
            'label'     => esc_html__('Success Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#15803d',
            'selectors' => ['{{WRAPPER}} .jr-form-message.jr-success' => 'color: {{VALUE}}; border-color: {{VALUE}};'],
        ]);

        $this->add_control('error_bg', [
            'label'     => esc_html__('Error Background', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fee2e2',
            'selectors' => ['{{WRAPPER}} .jr-form-message.jr-error' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('error_color', [
            'label'     => esc_html__('Error Text Color', 'jr-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#dc2626',
            'selectors' => ['{{WRAPPER}} .jr-form-message.jr-error' => 'color: {{VALUE}}; border-color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'message_typo',
            'selector' => '{{WRAPPER}} .jr-form-message',
        ]);

        $this->add_responsive_control('message_padding', [
            'label'      => esc_html__('Padding', 'jr-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'default'    => [
                'top' => '16', 'right' => '20', 'bottom' => '16', 'left' => '20',
                'unit' => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .jr-form-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

        /**
     * Render the form
     */
    protected function render() {
        $s = $this->get_settings_for_display();

        $form_id     = 'jr-form-' . $this->get_id();
        $fields      = $s['form_fields'] ?? [];
        $show_title  = $s['show_title'] === 'yes';
        $show_labels = $s['show_labels'] === 'yes';
        $show_req    = $s['show_required_mark'] === 'yes';
        $btn_full    = $s['button_full_width'] === 'yes';
        $btn_hover   = $s['button_hover_transform'] ?? 'lift';

        if (empty($fields)) {
            echo '<div class="jr-form-empty">' . esc_html__('No fields added. Add fields in widget settings.', 'jr-addons') . '</div>';
            return;
        }

        // Build fields config for AJAX
        $fields_config = [];
        foreach ($fields as $field) {
            $fields_config[] = [
                'id'             => $field['field_id'],
                'type'           => $field['field_type'],
                'label'          => $field['field_label'] ?? '',
                'required'       => $field['field_required'] ?? '',
                'allowed_types'  => $field['field_allowed_types'] ?? '',
                'max_file_size'  => $field['field_max_file_size'] ?? 5,
            ];
        }

        // Form settings for AJAX
        $form_settings = [
            'to_email'            => $s['to_email'],
            'from_name'           => $s['from_name'],
            'from_email'          => $s['from_email'],
            'reply_to'            => $s['reply_to'],
            'email_subject'       => $s['email_subject'],
            'email_body'          => $s['email_body'],
            'auto_reply'          => $s['auto_reply'],
            'auto_reply_to_field' => $s['auto_reply_to_field'] ?? '',
            'auto_reply_subject'  => $s['auto_reply_subject'] ?? '',
            'auto_reply_body'     => $s['auto_reply_body'] ?? '',
            'success_message'     => $s['success_message'],
            'redirect_url'        => $s['redirect_url']['url'] ?? '',
            'redirect_time'       => $s['redirect_time'] ?? 0,
        ];

        // Group fields into rows based on width
        $rows = $this->group_fields_into_rows($fields);

        ?>
        <div class="jr-form-wrapper" id="<?php echo esc_attr($form_id); ?>-wrapper" data-hide-after-submit="<?php echo esc_attr($s['hide_form_after_submit'] ?? ''); ?>"
     data-reset-after-submit="<?php echo esc_attr($s['reset_form_after_submit'] ?? 'yes'); ?>">

            <?php if ($show_title) : ?>
                <div class="jr-form-header">
                    <?php if (!empty($s['form_title'])) : ?>
                        <h2 class="jr-form-title"><?php echo esc_html($s['form_title']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($s['form_subtitle'])) : ?>
                        <p class="jr-form-subtitle"><?php echo esc_html($s['form_subtitle']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <form
                class="jr-form"
                id="<?php echo esc_attr($form_id); ?>"
                method="post"
                enctype="multipart/form-data"
                novalidate
                data-form-id="<?php echo esc_attr($form_id); ?>"
                data-error-message="<?php echo esc_attr($s['error_message']); ?>"
                data-fields-config='<?php echo esc_attr(wp_json_encode($fields_config)); ?>'
                data-form-settings='<?php echo esc_attr(wp_json_encode($form_settings)); ?>'
            >
                <!-- Messages container -->
                <div class="jr-form-messages"></div>

                <!-- Fields -->
                <div class="jr-form-fields">
                    <?php foreach ($rows as $row_fields) : ?>
                        <div class="jr-form-row">
                            <?php foreach ($row_fields as $field) : ?>
                                <?php $this->render_field($field, $show_labels, $show_req); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Honeypot (anti-spam) -->
                <div class="jr-form-hp" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;">
                    <label>Leave this empty</label>
                    <input type="text" name="jr_form_hp" tabindex="-1" autocomplete="off">
                </div>

                <!-- Submit Button -->
                <div class="jr-form-submit-wrap">
                    <button type="submit" class="jr-form-submit jr-hover-<?php echo esc_attr($btn_hover); ?> <?php echo $btn_full ? 'jr-btn-full' : ''; ?>">
                        <?php
                        $icon_pos  = $s['button_icon_position'] ?? 'left';
                        $has_icon  = !empty($s['button_icon']['value']);
                        ?>

                        <?php if ($has_icon && $icon_pos === 'left') : ?>
                            <span class="jr-form-btn-icon jr-icon-left">
                                <?php \Elementor\Icons_Manager::render_icon($s['button_icon'], ['aria-hidden' => 'true']); ?>
                            </span>
                        <?php endif; ?>

                        <span class="jr-form-btn-text"
                              data-default="<?php echo esc_attr($s['button_text']); ?>"
                              data-loading="<?php echo esc_attr($s['button_loading_text']); ?>">
                            <?php echo esc_html($s['button_text']); ?>
                        </span>

                        <span class="jr-form-btn-spinner" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                            </svg>
                        </span>

                        <?php if ($has_icon && $icon_pos === 'right') : ?>
                            <span class="jr-form-btn-icon jr-icon-right">
                                <?php \Elementor\Icons_Manager::render_icon($s['button_icon'], ['aria-hidden' => 'true']); ?>
                            </span>
                        <?php endif; ?>
                    </button>
                </div>
            </form>

        </div>
        <?php
    }

    /**
     * Group fields into rows based on width
     */
    private function group_fields_into_rows($fields) {
        $rows         = [];
        $current_row  = [];
        $current_width = 0;

        foreach ($fields as $field) {
            $width = intval($field['field_width'] ?? 100);

            // Full width or HTML/hidden — own row
            if ($width >= 100 || in_array($field['field_type'], ['html', 'hidden', 'textarea', 'file'])) {
                if (!empty($current_row)) {
                    $rows[]        = $current_row;
                    $current_row   = [];
                    $current_width = 0;
                }
                $rows[] = [$field];
                continue;
            }

            // Add to current row
            if ($current_width + $width > 100) {
                $rows[]        = $current_row;
                $current_row   = [];
                $current_width = 0;
            }

            $current_row[]  = $field;
            $current_width += $width;

            // Row full
            if ($current_width >= 100) {
                $rows[]        = $current_row;
                $current_row   = [];
                $current_width = 0;
            }
        }

        if (!empty($current_row)) {
            $rows[] = $current_row;
        }

        return $rows;
    }

    /**
     * Render single field
     */
    private function render_field($field, $show_labels, $show_req) {
        $type        = $field['field_type'] ?? 'text';
        $id          = $field['field_id'] ?? '';
        $label       = $field['field_label'] ?? '';
        $placeholder = $field['field_placeholder'] ?? '';
        $default     = $field['field_default_value'] ?? '';
        $required    = ($field['field_required'] ?? '') === 'yes';
        $help        = $field['field_help_text'] ?? '';
        $width       = intval($field['field_width'] ?? 100);
        $css_class   = $field['field_css_class'] ?? '';

        // Field wrapper class
        $wrap_class = 'jr-form-field jr-field-type-' . $type . ' jr-field-w-' . $width;
        if ($required) $wrap_class .= ' jr-field-required';
        if (!empty($css_class)) $wrap_class .= ' ' . esc_attr($css_class);

        // Hidden field — no wrapper
        if ($type === 'hidden') {
            echo '<input type="hidden" name="form_data[' . esc_attr($id) . ']" value="' . esc_attr($default) . '">';
            return;
        }

        // HTML field
        if ($type === 'html') {
            echo '<div class="' . esc_attr($wrap_class) . '">';
            echo '<div class="jr-form-html-content">' . wp_kses_post($field['field_html'] ?? '') . '</div>';
            echo '</div>';
            return;
        }

        ?>
        <div class="<?php echo esc_attr($wrap_class); ?>">
            <?php if ($show_labels && !empty($label) && $type !== 'checkbox') : ?>
                <label for="<?php echo esc_attr($id); ?>" class="jr-form-label">
                    <?php echo esc_html($label); ?>
                    <?php if ($required && $show_req) : ?>
                        <span class="jr-required" aria-hidden="true">*</span>
                    <?php endif; ?>
                </label>
            <?php endif; ?>

            <div class="jr-form-input-wrap">
                <?php $this->render_field_input($field); ?>
            </div>

            <?php if (!empty($help)) : ?>
                <small class="jr-form-help"><?php echo esc_html($help); ?></small>
            <?php endif; ?>

            <div class="jr-form-field-error" data-field="<?php echo esc_attr($id); ?>"></div>
        </div>
        <?php
    }

    /**
     * Render the actual input element
     */
    private function render_field_input($field) {
        $type        = $field['field_type'];
        $id          = $field['field_id'];
        $label       = $field['field_label'] ?? '';
        $placeholder = $field['field_placeholder'] ?? '';
        $default     = $field['field_default_value'] ?? '';
        $required    = ($field['field_required'] ?? '') === 'yes';
        $name        = 'form_data[' . $id . ']';
        $req_attr    = $required ? 'required' : '';

        switch ($type) {

            case 'text':
            case 'email':
            case 'tel':
            case 'url':
                ?>
                <input
                    type="<?php echo esc_attr($type); ?>"
                    id="<?php echo esc_attr($id); ?>"
                    name="<?php echo esc_attr($name); ?>"
                    class="jr-form-input"
                    placeholder="<?php echo esc_attr($placeholder); ?>"
                    value="<?php echo esc_attr($default); ?>"
                    <?php echo $req_attr; ?>
                >
                <?php
                break;

            case 'number':
                $min = isset($field['field_min']) ? $field['field_min'] : '';
                $max = isset($field['field_max']) ? $field['field_max'] : '';
                $step = isset($field['field_step']) ? $field['field_step'] : 1;
                ?>
                <input
                    type="number"
                    id="<?php echo esc_attr($id); ?>"
                    name="<?php echo esc_attr($name); ?>"
                    class="jr-form-input"
                    placeholder="<?php echo esc_attr($placeholder); ?>"
                    value="<?php echo esc_attr($default); ?>"
                    <?php echo $min !== '' ? 'min="' . esc_attr($min) . '"' : ''; ?>
                    <?php echo $max !== '' ? 'max="' . esc_attr($max) . '"' : ''; ?>
                    step="<?php echo esc_attr($step); ?>"
                    <?php echo $req_attr; ?>
                >
                <?php
                break;

            case 'textarea':
                $rows = intval($field['field_rows'] ?? 4);
                ?>
                <textarea
                    id="<?php echo esc_attr($id); ?>"
                    name="<?php echo esc_attr($name); ?>"
                    class="jr-form-textarea"
                    placeholder="<?php echo esc_attr($placeholder); ?>"
                    rows="<?php echo esc_attr($rows); ?>"
                    <?php echo $req_attr; ?>
                ><?php echo esc_textarea($default); ?></textarea>
                <?php
                break;

            case 'select':
                $options = $this->parse_options($field['field_options'] ?? '');
                ?>
                <div class="jr-form-select-wrap">
                    <select
                        id="<?php echo esc_attr($id); ?>"
                        name="<?php echo esc_attr($name); ?>"
                        class="jr-form-select"
                        <?php echo $req_attr; ?>
                    >
                        <?php if (!empty($placeholder)) : ?>
                            <option value=""><?php echo esc_html($placeholder); ?></option>
                        <?php endif; ?>
                        <?php foreach ($options as $opt) : ?>
                            <option value="<?php echo esc_attr($opt['value']); ?>"><?php echo esc_html($opt['label']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="jr-form-select-arrow" aria-hidden="true">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </span>
                </div>
                <?php
                break;

            case 'radio':
                $options = $this->parse_options($field['field_options'] ?? '');
                ?>
                <div class="jr-form-radio-group">
                    <?php foreach ($options as $i => $opt) : ?>
                        <label class="jr-form-radio-item">
                            <input
                                type="radio"
                                name="<?php echo esc_attr($name); ?>"
                                value="<?php echo esc_attr($opt['value']); ?>"
                                <?php echo $req_attr; ?>
                            >
                            <span class="jr-radio-mark"></span>
                            <span class="jr-radio-label"><?php echo esc_html($opt['label']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
                <?php
                break;

            case 'checkbox':
                $checkbox_text = $field['field_checkbox_text'] ?? $label;
                ?>
                <label class="jr-form-checkbox-item jr-form-checkbox-single">
                    <input
                        type="checkbox"
                        id="<?php echo esc_attr($id); ?>"
                        name="<?php echo esc_attr($name); ?>"
                        value="1"
                        <?php echo $req_attr; ?>
                    >
                    <span class="jr-checkbox-mark"></span>
                    <span class="jr-checkbox-label">
                        <?php echo wp_kses_post($checkbox_text); ?>
                        <?php if ($required) : ?>
                            <span class="jr-required" aria-hidden="true">*</span>
                        <?php endif; ?>
                    </span>
                </label>
                <?php
                break;

            case 'multi-checkbox':
                $options = $this->parse_options($field['field_options'] ?? '');
                ?>
                <div class="jr-form-checkbox-group">
                    <?php foreach ($options as $opt) : ?>
                        <label class="jr-form-checkbox-item">
                            <input
                                type="checkbox"
                                name="<?php echo esc_attr($name); ?>[]"
                                value="<?php echo esc_attr($opt['value']); ?>"
                            >
                            <span class="jr-checkbox-mark"></span>
                            <span class="jr-checkbox-label"><?php echo esc_html($opt['label']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
                <?php
                break;

            case 'date':
                ?>
                <input
                    type="date"
                    id="<?php echo esc_attr($id); ?>"
                    name="<?php echo esc_attr($name); ?>"
                    class="jr-form-input"
                    value="<?php echo esc_attr($default); ?>"
                    <?php echo $req_attr; ?>
                >
                <?php
                break;

            case 'time':
                ?>
                <input
                    type="time"
                    id="<?php echo esc_attr($id); ?>"
                    name="<?php echo esc_attr($name); ?>"
                    class="jr-form-input"
                    value="<?php echo esc_attr($default); ?>"
                    <?php echo $req_attr; ?>
                >
                <?php
                break;

            case 'file':
                $multiple    = ($field['field_multiple_files'] ?? '') === 'yes';
                $allowed     = $field['field_allowed_types'] ?? 'jpg,jpeg,png,pdf,doc,docx';
                $max_size    = intval($field['field_max_file_size'] ?? 5);
                $upload_text = $field['field_upload_text'] ?? 'Browse Files';
                $sub_text    = $field['field_upload_subtext'] ?? 'Drag and drop files here';
                $accept      = '.' . str_replace(',', ',.', preg_replace('/\s+/', '', $allowed));
                $name_attr   = $multiple ? $id . '[]' : $id;
                ?>
                <div class="jr-form-file-box"
                     data-field-id="<?php echo esc_attr($id); ?>"
                     data-multiple="<?php echo $multiple ? '1' : '0'; ?>"
                     data-max-size="<?php echo esc_attr($max_size); ?>"
                     data-allowed="<?php echo esc_attr($allowed); ?>">

                    <input
                        type="file"
                        id="<?php echo esc_attr($id); ?>"
                        name="<?php echo esc_attr($name_attr); ?>"
                        class="jr-form-file-input"
                        accept="<?php echo esc_attr($accept); ?>"
                        <?php echo $multiple ? 'multiple' : ''; ?>
                        <?php echo $req_attr; ?>
                    >

                    <div class="jr-form-file-content">
                        <div class="jr-form-file-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                        </div>
                        <div class="jr-form-file-text"><?php echo esc_html($upload_text); ?></div>
                        <div class="jr-form-file-subtext"><?php echo esc_html($sub_text); ?></div>
                        <div class="jr-form-file-info">
                            <small>Max <?php echo esc_html($max_size); ?>MB · <?php echo esc_html(strtoupper($allowed)); ?></small>
                        </div>
                    </div>

                    <div class="jr-form-file-list"></div>
                </div>
                <?php
                break;
        }
    }

    /**
     * Parse options text into array
     * Supports: "value|label" or just "label"
     */
    private function parse_options($options_text) {
        $lines  = array_filter(array_map('trim', explode("\n", $options_text)));
        $result = [];

        foreach ($lines as $line) {
            if (strpos($line, '|') !== false) {
                list($value, $label) = explode('|', $line, 2);
                $result[] = [
                    'value' => trim($value),
                    'label' => trim($label),
                ];
            } else {
                $result[] = [
                    'value' => $line,
                    'label' => $line,
                ];
            }
        }

        return $result;
    }
}