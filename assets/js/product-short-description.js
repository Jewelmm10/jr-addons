(function($){
    'use strict';

    $(document).ready(function(){

        // ============================================
        // Read More / Read Less Toggle
        // ============================================
        $(document).on('click', '.jr-read-more-btn', function(){
            var $btn      = $(this);
            var $wrap     = $btn.closest('.jr-short-desc-wrap');
            var $content  = $wrap.find('.jr-short-desc-content');
            var $textSpan = $btn.find('.jr-rm-text');
            
            var moreText = $btn.data('more');
            var lessText = $btn.data('less');
            
            var shortHtml = $content.attr('data-short');
            var fullHtml  = $content.attr('data-full');
            
            var isExpanded = $btn.hasClass('is-expanded');
            
            // Get current height for smooth animation
            var currentHeight = $content.outerHeight();
            $content.css('max-height', currentHeight + 'px');
            
            // Switch content
            setTimeout(function(){
                if (isExpanded) {
                    // Collapse
                    $content.html(shortHtml);
                    $textSpan.text(moreText);
                    $btn.removeClass('is-expanded');
                } else {
                    // Expand
                    $content.html(fullHtml);
                    $textSpan.text(lessText);
                    $btn.addClass('is-expanded');
                }
                
                // Animate to new height
                $content.css('max-height', 'none');
                var newHeight = $content.outerHeight();
                $content.css('max-height', currentHeight + 'px');
                
                // Force reflow
                $content[0].offsetHeight;
                
                $content.css('max-height', newHeight + 'px');
                
                // Remove max-height after animation
                setTimeout(function(){
                    $content.css('max-height', '');
                }, 400);
            }, 10);
        });

    });

})(jQuery);