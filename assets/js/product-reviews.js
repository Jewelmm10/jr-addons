(function($){
    'use strict';

    $(document).ready(function(){

        // ============================================
        // Interactive Star Rating
        // ============================================
        $(document).on('mouseenter', '.jr-rating-input .jr-star', function(){
            var val = $(this).data('value');
            var $parent = $(this).parent();
            $parent.find('.jr-star').each(function(){
                $(this).toggleClass('is-hover', $(this).data('value') <= val);
            });
        });

        $(document).on('mouseleave', '.jr-rating-input', function(){
            $(this).find('.jr-star').removeClass('is-hover');
        });

        $(document).on('click', '.jr-rating-input .jr-star', function(){
            var val = $(this).data('value');
            var $parent = $(this).parent();
            $parent.find('input[name="rating"]').val(val);
            $parent.find('.jr-star').each(function(){
                $(this).toggleClass('is-active', $(this).data('value') <= val);
            });
        });

        // ============================================
        // Review Form Submit
        // ============================================
        $(document).on('submit', '.jr-review-form', function(e){
            e.preventDefault();

            var $form = $(this);
            var $btn  = $form.find('.jr-submit-btn');
            var $msg  = $form.find('.jr-form-message');
            var $btnText = $btn.find('.jr-btn-text');
            var originalText = $btnText.text();

            var rating = $form.find('input[name="rating"], select[name="rating"]').val();
            if (!rating) {
                $msg.removeClass('is-success').addClass('is-error').text('Please select a rating.');
                return;
            }

            var data = {
                action:         'jr_submit_review',
                nonce:          $form.find('[name="jr_review_nonce"]').val(),
                product_id:     $form.find('[name="product_id"]').val(),
                review_content: $form.find('[name="review_content"]').val(),
                rating:         rating,
                recommend:      $form.find('[name="recommend"]:checked').val() || 'yes',
                reviewer_name:  $form.find('[name="reviewer_name"]').val() || '',
                reviewer_email: $form.find('[name="reviewer_email"]').val() || ''
            };

            $btn.prop('disabled', true).addClass('is-loading');
            $btnText.text('Submitting...');
            $msg.removeClass('is-success is-error').empty();

            $.ajax({
                url: jrAddons.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    if (response.success) {
                        $msg.addClass('is-success').text(response.data.message);
                        $form[0].reset();
                        $form.find('.jr-rating-input .jr-star').removeClass('is-active');
                        $form.find('input[name="rating"]').val('');

                        if (response.data.approved) {
                            setTimeout(function(){ window.location.reload(); }, 1500);
                        }
                    } else {
                        $msg.addClass('is-error').text(response.data.message || 'Error occurred.');
                    }
                },
                error: function(xhr){
                    console.error('Review Error:', xhr.status, xhr.responseText);
                    $msg.addClass('is-error').text('Network error. Please try again.');
                },
                complete: function(){
                    $btn.prop('disabled', false).removeClass('is-loading');
                    $btnText.text(originalText);
                }
            });
        });

        // ============================================
        // Reply Toggle
        // ============================================
        $(document).on('click', '.jr-reply-toggle', function(e){
            e.preventDefault();
            
            var $this = $(this);
            var commentId = $this.data('comment-id');
            var $form = $('.jr-reply-form-wrap[data-parent-id="' + commentId + '"]');
            
            console.log('Reply toggle clicked, comment ID:', commentId);
            console.log('Form found:', $form.length);
            
            // Close other open forms
            $('.jr-reply-form-wrap').not($form).slideUp(200);
            $('.jr-reply-toggle').not($this).removeClass('is-active');
            
            $this.toggleClass('is-active');
            
            $form.slideToggle(250, function(){
                if ($form.is(':visible')) {
                    $form.find('textarea').focus();
                }
            });
        });

        // ============================================
        // Reply Cancel
        // ============================================
        $(document).on('click', '.jr-reply-cancel', function(e){
            e.preventDefault();
            var $form = $(this).closest('.jr-reply-form-wrap');
            $form.slideUp(200);
            $form.find('textarea').val('');
            $form.find('.jr-reply-message').empty().removeClass('is-success is-error');
            
            // Remove active state from toggle
            var parentId = $form.data('parent-id');
            $('.jr-reply-toggle[data-comment-id="' + parentId + '"]').removeClass('is-active');
        });

        // ============================================
        // Reply Submit
        // ============================================
        $(document).on('submit', '.jr-reply-form', function(e){
            e.preventDefault();
            
            var $form = $(this);
            var $btn  = $form.find('.jr-reply-submit');
            var $msg  = $form.find('.jr-reply-message');
            var originalText = $btn.text();
            
            var data = {
                action:        'jr_submit_reply',
                nonce:         $form.find('[name="jr_reply_nonce"]').val(),
                product_id:    $form.find('[name="product_id"]').val(),
                parent_id:     $form.find('[name="parent_id"]').val(),
                reply_content: $form.find('[name="reply_content"]').val()
            };
            
            console.log('Reply submit data:', data);
            
            if (!data.reply_content.trim()) {
                $msg.removeClass('is-success').addClass('is-error').text('Please write a reply.');
                return;
            }
            
            $btn.prop('disabled', true).text('Posting...');
            $msg.removeClass('is-success is-error').empty();
            
            $.ajax({
                url: jrAddons.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    console.log('Reply Response:', response);
                    
                    if (response.success) {
                        $msg.addClass('is-success').text(response.data.message);
                        $form[0].reset();
                        
                        setTimeout(function(){ 
                            window.location.reload(); 
                        }, 1200);
                    } else {
                        $msg.addClass('is-error').text(response.data.message || 'Error occurred.');
                    }
                },
                error: function(xhr){
                    console.error('Reply Error:', xhr.status, xhr.responseText);
                    var errMsg = 'Network error. Try again.';
                    if (xhr.status === 400) errMsg = 'Bad Request. Check console.';
                    if (xhr.status === 403) errMsg = 'Permission denied.';
                    $msg.addClass('is-error').text(errMsg);
                },
                complete: function(){
                    $btn.prop('disabled', false).text(originalText);
                }
            });
        });

    });

})(jQuery);