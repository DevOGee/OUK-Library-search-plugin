/**
 * Library Search Block - JavaScript behavior.
 *
 * @module     block_librarysearch/search
 * @copyright  2025 Open University of Kenya
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/notification'], function($, Notification) {
    "use strict";

    return {
        /**
         * Initialize the search functionality.
         *
         * @param {string} selector The CSS selector for the block container.
         */
        init: function(selector) {
            var container = $(selector);
            var form = container.find('.library-search-form');
            var input = container.find('.js-search-input');
            var isNewTab = container.data('newtab') == 1;

            form.on('submit', function(e) {
                var query = input.val().trim();

                if (query === '') {
                    e.preventDefault();
                    Notification.alert(
                        'Empty Search',
                        'Please enter a search term to find library resources.',
                        'OK'
                    );
                    return false;
                }

                // If not new tab, we might want to do some tracking or UI changes
                if (!isNewTab) {
                    container.find('.js-search-button')
                        .prop('disabled', true)
                        .html('<i class="fa fa-spinner fa-spin"></i> Searching...');
                }
            });

            // Handle keyboard shortcuts (Enter already works by default in forms)
            input.on('keypress', function(e) {
                if (e.which === 13 && input.val().trim() === '') {
                    e.preventDefault();
                }
            });

            // Log for debugging in developer mode
            console.log('Library Search block initialized');
        }
    };
});
