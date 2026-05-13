/**
 * JR Product Long Description Widget
 * Read More / Read Less Toggle with smooth animation
 */
(function () {
    'use strict';

    /**
     * Initialize single widget instance
     */
    function initLongDescription(wrapper) {
        if (!wrapper || wrapper.classList.contains('jr-long-desc-initialized')) {
            return;
        }

        wrapper.classList.add('jr-long-desc-initialized');

        // Parse settings
        var settingsRaw = wrapper.getAttribute('data-settings');
        if (!settingsRaw) return;

        var settings;
        try {
            settings = JSON.parse(settingsRaw);
        } catch (e) {
            return;
        }

        if (!settings.enableToggle) return;

        var body        = wrapper.querySelector('.jr-long-desc-body');
        var content     = wrapper.querySelector('.jr-long-desc-content');
        var toggleBtn   = wrapper.querySelector('.jr-long-desc-toggle');
        var gradient    = wrapper.querySelector('.jr-long-desc-gradient');
        var toggleText  = toggleBtn ? toggleBtn.querySelector('.jr-toggle-text') : null;
        var iconMore    = toggleBtn ? toggleBtn.querySelector('.jr-toggle-icon-more') : null;
        var iconLess    = toggleBtn ? toggleBtn.querySelector('.jr-toggle-icon-less') : null;

        if (!body || !content || !toggleBtn) return;

        var wordLimit      = settings.wordLimit || 50;
        var animSpeed      = settings.animationSpeed || 400;
        var readMoreText   = settings.readMoreText || 'Read More';
        var readLessText   = settings.readLessText || 'Read Less';

        // Store full HTML content
        var fullHTML = content.innerHTML;

        // Create truncated version
        var truncatedHTML = truncateHTML(fullHTML, wordLimit);

        // Check if truncation actually happened
        var fullStripped = stripHTML(fullHTML).trim();
        var truncStripped = stripHTML(truncatedHTML).trim();

        if (fullStripped.length <= truncStripped.length + 10) {
            // Content is short enough, no need for toggle
            body.classList.remove('is-collapsed');
            toggleBtn.parentElement.style.display = 'none';
            if (gradient) gradient.style.display = 'none';
            return;
        }

        // Set initial collapsed state
        var isExpanded = false;
        content.innerHTML = truncatedHTML;

        // Measure collapsed height
        var collapsedHeight = body.scrollHeight;
        body.style.maxHeight = collapsedHeight + 'px';
        body.classList.add('is-collapsed');

        // Transition
        body.style.transition = 'max-height ' + animSpeed + 'ms ease';

        // Toggle click handler
        toggleBtn.addEventListener('click', function () {
            if (isExpanded) {
                // Collapse
                collapse();
            } else {
                // Expand
                expand();
            }
        });

        function expand() {
            isExpanded = true;

            // Set full content
            content.innerHTML = fullHTML;

            // Get full height
            body.style.maxHeight = 'none';
            var fullHeight = body.scrollHeight;

            // Reset and animate
            body.style.maxHeight = collapsedHeight + 'px';

            // Force reflow
            body.offsetHeight;

            body.style.maxHeight = fullHeight + 'px';
            body.classList.remove('is-collapsed');
            body.classList.add('is-expanded');

            // Update button
            if (toggleText) toggleText.textContent = readLessText;
            if (iconMore) iconMore.style.display = 'none';
            if (iconLess) iconLess.style.display = 'inline-flex';
            toggleBtn.setAttribute('aria-expanded', 'true');

            // After animation, remove max-height
            setTimeout(function () {
                body.style.maxHeight = 'none';
            }, animSpeed + 50);
        }

        function collapse() {
            isExpanded = false;

            // Get current height
            var currentHeight = body.scrollHeight;
            body.style.maxHeight = currentHeight + 'px';

            // Force reflow
            body.offsetHeight;

            // Set truncated content (after setting maxHeight so animation works)
            content.innerHTML = truncatedHTML;

            // Recalculate collapsed height
            body.style.maxHeight = 'none';
            collapsedHeight = body.scrollHeight;
            body.style.maxHeight = currentHeight + 'px';

            // Force reflow
            body.offsetHeight;

            body.style.maxHeight = collapsedHeight + 'px';
            body.classList.add('is-collapsed');
            body.classList.remove('is-expanded');

            // Update button
            if (toggleText) toggleText.textContent = readMoreText;
            if (iconMore) iconMore.style.display = 'inline-flex';
            if (iconLess) iconLess.style.display = 'none';
            toggleBtn.setAttribute('aria-expanded', 'false');

            // Scroll to widget if it's out of view
            setTimeout(function () {
                var rect = wrapper.getBoundingClientRect();
                if (rect.top < 0) {
                    wrapper.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, animSpeed + 50);
        }
    }

    /**
     * Truncate HTML content by word count, preserving tags
     */
    function truncateHTML(html, wordLimit) {
        var div = document.createElement('div');
        div.innerHTML = html;

        var wordCount = 0;
        var result = '';
        var done = false;

        function walkNodes(node) {
            if (done) return '';

            if (node.nodeType === Node.TEXT_NODE) {
                var words = node.textContent.split(/\s+/).filter(function(w) { return w.length > 0; });

                if (wordCount + words.length <= wordLimit) {
                    wordCount += words.length;
                    return node.textContent;
                } else {
                    var remaining = wordLimit - wordCount;
                    var truncatedWords = words.slice(0, remaining).join(' ');
                    wordCount = wordLimit;
                    done = true;
                    return truncatedWords + '...';
                }
            }

            if (node.nodeType === Node.ELEMENT_NODE) {
                var tagName = node.tagName.toLowerCase();
                var openTag = '<' + tagName;

                // Copy attributes
                for (var i = 0; i < node.attributes.length; i++) {
                    var attr = node.attributes[i];
                    openTag += ' ' + attr.name + '="' + attr.value + '"';
                }
                openTag += '>';

                var closeTag = '</' + tagName + '>';
                var innerContent = '';

                for (var j = 0; j < node.childNodes.length; j++) {
                    if (done && innerContent) break;
                    innerContent += walkNodes(node.childNodes[j]);
                }

                // Self-closing tags
                var selfClosing = ['br', 'hr', 'img', 'input'];
                if (selfClosing.indexOf(tagName) !== -1) {
                    return openTag;
                }

                return openTag + innerContent + closeTag;
            }

            return '';
        }

        for (var i = 0; i < div.childNodes.length; i++) {
            if (done) break;
            result += walkNodes(div.childNodes[i]);
        }

        return result;
    }

    /**
     * Strip HTML tags
     */
    function stripHTML(html) {
        var div = document.createElement('div');
        div.innerHTML = html;
        return div.textContent || div.innerText || '';
    }

    /**
     * Initialize all widgets
     */
    function initAll() {
        var wrappers = document.querySelectorAll('.jr-long-desc-wrapper:not(.jr-long-desc-initialized)');
        wrappers.forEach(function (wrapper) {
            initLongDescription(wrapper);
        });
    }

    // DOM Ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

    // Elementor Frontend Hook
    if (typeof jQuery !== 'undefined') {
        jQuery(window).on('elementor/frontend/init', function () {
            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/jr_product_long_description.default',
                    function ($element) {
                        var wrapper = $element[0].querySelector('.jr-long-desc-wrapper');
                        if (wrapper) {
                            wrapper.classList.remove('jr-long-desc-initialized');
                            initLongDescription(wrapper);
                        }
                    }
                );
            }
        });
    }

})();