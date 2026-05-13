/**
 * JR Form Builder
 * AJAX submit + Drag & Drop file upload + Validation
 */
(function ($) {
    'use strict';

    // ── Form Submit (Event Delegation) ──
    $(document).on('submit', '.jr-form', function (e) {
        e.preventDefault();
        jrFormSubmit($(this));
    });

    // ── File Input Change ──
    $(document).on('change', '.jr-form-file-input', function () {
        var $input = $(this);
        var $box   = $input.closest('.jr-form-file-box');
        jrHandleFiles($box, this.files);
    });

    // ── Drag & Drop ──
    $(document).on('dragover dragenter', '.jr-form-file-box', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('jr-drag-active');
    });

    $(document).on('dragleave dragend', '.jr-form-file-box', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('jr-drag-active');
    });

    $(document).on('drop', '.jr-form-file-box', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $box = $(this);
        $box.removeClass('jr-drag-active');

        var files = e.originalEvent.dataTransfer.files;
        if (files && files.length) {
            jrHandleFiles($box, files);
        }
    });

    // ── Remove File ──
    $(document).on('click', '.jr-form-file-item-remove', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $item = $(this).closest('.jr-form-file-item');
        var $box  = $item.closest('.jr-form-file-box');
        var index = $item.data('index');

        $item.remove();
        jrUpdateFileInput($box, index);
    });

    // Prevent click propagation when interacting with file list
    $(document).on('click', '.jr-form-file-list', function (e) {
        e.stopPropagation();
    });

    /**
     * Handle file selection (from input or drop)
     */
    function jrHandleFiles($box, fileList) {
        var multiple    = $box.data('multiple') == 1;
        var maxSize     = parseInt($box.data('max-size')) || 5; // MB
        var allowedStr  = ($box.data('allowed') || '').toString().toLowerCase();
        var allowed     = allowedStr.split(',').map(function (s) { return s.trim(); });
        var $input      = $box.find('.jr-form-file-input');
        var $list       = $box.find('.jr-form-file-list');
        var $field      = $box.closest('.jr-form-field');

        clearFieldError($field);

        var files = Array.from(fileList);

        // Single file mode — replace
        if (!multiple) {
            files = files.slice(0, 1);
            $list.empty();
        }

        // Validate each file
        var validFiles = [];
        var errors = [];

        files.forEach(function (file) {
            // Size check
            if (file.size > maxSize * 1024 * 1024) {
                errors.push(file.name + ' is too large (max ' + maxSize + 'MB)');
                return;
            }

            // Extension check
            var ext = file.name.split('.').pop().toLowerCase();
            if (allowed.indexOf(ext) === -1) {
                errors.push(file.name + ' - file type not allowed');
                return;
            }

            validFiles.push(file);
        });

        if (errors.length > 0) {
            showFieldError($field, errors.join('. '));
            if (validFiles.length === 0) return;
        }

        // Update file input via DataTransfer
        var dt = new DataTransfer();

        // Keep existing files if multiple
        if (multiple && $input[0].files) {
            Array.from($input[0].files).forEach(function (f) {
                dt.items.add(f);
            });
        }

        validFiles.forEach(function (f) {
            dt.items.add(f);
        });

        $input[0].files = dt.files;

        // Render file list
        renderFileList($box);
    }

    /**
     * Render selected files list
     */
    function renderFileList($box) {
        var $input = $box.find('.jr-form-file-input');
        var $list  = $box.find('.jr-form-file-list');
        var files  = $input[0].files;

        $list.empty();

        if (!files || files.length === 0) return;

        Array.from(files).forEach(function (file, idx) {
            var $item = $('<div class="jr-form-file-item" data-index="' + idx + '"></div>');

            $item.append(
                '<span class="jr-form-file-item-icon">' +
                    '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>' +
                '</span>'
            );

            $item.append('<span class="jr-form-file-item-name">' + escapeHtml(file.name) + '</span>');
            $item.append('<span class="jr-form-file-item-size">' + formatFileSize(file.size) + '</span>');
            $item.append(
                '<button type="button" class="jr-form-file-item-remove" aria-label="Remove">' +
                    '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
                '</button>'
            );

            $list.append($item);
        });
    }

    /**
     * Update file input after removing a file
     */
    function jrUpdateFileInput($box, removeIndex) {
        var $input = $box.find('.jr-form-file-input');
        var files  = Array.from($input[0].files);
        files.splice(removeIndex, 1);

        var dt = new DataTransfer();
        files.forEach(function (f) {
            dt.items.add(f);
        });
        $input[0].files = dt.files;

        renderFileList($box);
    }

    /**
     * Format file size
     */
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1024 / 1024).toFixed(2) + ' MB';
    }

    /**
     * Escape HTML
     */
    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    /**
     * Show field error
     */
    function showFieldError($field, message) {
        $field.addClass('jr-has-error');
        $field.find('.jr-form-field-error').first().text(message).addClass('jr-show');
    }

    /**
     * Clear field error
     */
    function clearFieldError($field) {
        $field.removeClass('jr-has-error');
        $field.find('.jr-form-field-error').first().text('').removeClass('jr-show');
    }

    /**
     * Clear all errors
     */
    function clearAllErrors($form) {
        $form.find('.jr-form-field').removeClass('jr-has-error');
        $form.find('.jr-form-field-error').text('').removeClass('jr-show');
    }

    /**
     * Show form message (success/error)
     */
    function showFormMessage($form, type, message) {
        var $messages = $form.find('.jr-form-messages');
        var icon = type === 'success'
            ? '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>'
            : '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';

        var html = '<div class="jr-form-message jr-' + type + '">' +
                       '<span class="jr-form-message-icon">' + icon + '</span>' +
                       '<span class="jr-form-message-text">' + message + '</span>' +
                   '</div>';

        $messages.html(html);

        // Scroll to message
        $('html, body').animate({
            scrollTop: $messages.offset().top - 100
        }, 300);
    }

    /**
     * Submit form via AJAX
     */
    function jrFormSubmit($form) {
        // Check jrAddons
        if (typeof jrAddons === 'undefined' || !jrAddons.nonces || !jrAddons.nonces.form) {
            console.error('JR Form: jrAddons.nonces.form missing!');
            showFormMessage($form, 'error', 'Configuration error. Please contact support.');
            return;
        }

        // Prevent double submit
        if ($form.data('jr-submitting')) return;
        $form.data('jr-submitting', true);

        clearAllErrors($form);
        $form.find('.jr-form-messages').empty();

        var $btn      = $form.find('.jr-form-submit');
        var $btnText  = $btn.find('.jr-form-btn-text');
        var defText   = $btnText.data('default');
        var loadText  = $btnText.data('loading');
        var errorMsg  = $form.data('error-message') || 'Something went wrong.';

        $btn.addClass('jr-is-loading').prop('disabled', true);
        $btnText.text(loadText);

        // Build FormData
        var formData = new FormData($form[0]);
        formData.append('action', 'jr_form_submit');
        formData.append('nonce', jrAddons.nonces.form);
        formData.append('form_id', $form.attr('id'));
        formData.append('fields_config', JSON.stringify($form.data('fields-config')));
        formData.append('form_settings', JSON.stringify($form.data('form-settings')));

        $.ajax({
            url: jrAddons.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (res) {
                console.log('JR Form Response:', res);

                if (res && res.success) {
                    // ── SUCCESS HANDLING ──
                    var $wrapper        = $form.closest('.jr-form-wrapper');
                    var hideAfter       = $wrapper.data('hide-after-submit') === 'yes';
                    var resetAfter      = $wrapper.data('reset-after-submit') !== 'no'; // default: yes
                    var hasRedirect     = !!res.data.redirect_url;

                    // Show success message
                    showFormMessage($form, 'success', res.data.message || 'Thank you!');

                    // Reset form fields (if enabled or hiding/redirecting)
                    if (resetAfter || hideAfter || hasRedirect) {
                        $form[0].reset();
                        $form.find('.jr-form-file-list').empty();
                        clearAllErrors($form);
                    }

                    // Hide form (and header) - only if option is ON or redirect is set
                    if (hideAfter || hasRedirect) {
                        // Move success message OUTSIDE the form so it stays visible
                        var $messages = $form.find('.jr-form-messages');
                        var $msgClone = $messages.children().clone();

                        // Insert before form, then hide form
                        if ($msgClone.length) {
                            // Wrap in container
                            var $msgContainer = $('<div class="jr-form-success-container"></div>');
                            $msgContainer.append($msgClone);
                            $form.before($msgContainer);
                            $messages.empty();
                        }

                        // Hide form
                        $form.addClass('jr-submitted');

                        // Hide header too (for cleaner look)
                        $wrapper.find('.jr-form-header').addClass('jr-submitted');
                    }

                    // Redirect if URL provided
                    if (hasRedirect) {
                        var delay = (parseInt(res.data.redirect_time) || 2) * 1000;
                        setTimeout(function () {
                            window.location.href = res.data.redirect_url;
                        }, delay);
                    }

                } else {
                    // ── ERROR HANDLING ──
                    // Form stays visible — DO NOT hide
                    var msg = (res && res.data && res.data.message) ? res.data.message : errorMsg;
                    showFormMessage($form, 'error', msg);

                    // Show field errors
                    if (res && res.data && res.data.errors) {
                        $.each(res.data.errors, function (fieldId, errMsg) {
                            var $field = $form.find('[name="form_data[' + fieldId + ']"]')
                                            .closest('.jr-form-field');
                            if (!$field.length) {
                                $field = $form.find('[data-field-id="' + fieldId + '"]')
                                            .closest('.jr-form-field');
                            }
                            if (!$field.length) {
                                $field = $form.find('[name="form_data[' + fieldId + '][]"]')
                                            .closest('.jr-form-field');
                            }
                            if ($field.length) {
                                showFieldError($field, errMsg);
                            }
                        });
                    }
                }

                resetButton();
            },
            error: function (xhr, status, error) {
                console.error('JR Form AJAX Error:', status, error, xhr.responseText);
                showFormMessage($form, 'error', errorMsg);
                resetButton();
            }
        });

        function resetButton() {
            $btn.removeClass('jr-is-loading').prop('disabled', false);
            $btnText.text(defText);
            $form.data('jr-submitting', false);
        }
    }

    // ── Init Log ──
    $(document).ready(function () {
        var count = $('.jr-form').length;
        if (count > 0) {
            console.log('JR Form Builder: ' + count + ' form(s) ready');
            if (typeof jrAddons === 'undefined' || !jrAddons.nonces || !jrAddons.nonces.form) {
                console.error('⚠️ JR Form: jrAddons.nonces.form missing! Add it in main plugin file.');
            }
        }
    });

})(jQuery);