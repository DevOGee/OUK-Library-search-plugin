define(['jquery', 'core/notification'], function($, Notification) {
    "use strict";

    var STORAGE_KEY = 'block_librarysearch_last_query';
    var FILTERS_KEY = 'block_librarysearch_last_filters';

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
            var filterInputs = container.find('.js-filter-input');
            var quickLinks = container.find('.js-quick-link');
            var isNewTab = container.data('newtab') == 1;

            /**
             * Update all quick links with the current search query and filters.
             */
            var updateQuickLinks = function() {
                var query = input.val().trim();
                if (query === '') {
                    // Reset to original URLs if query is empty.
                    quickLinks.each(function() {
                        $(this).attr('href', $(this).data('original-href'));
                    });
                    return;
                }

                var params = {
                    'q': query,
                    'autocorrect': 'y'
                };

                // Add active filters.
                filterInputs.each(function() {
                    if ($(this).is(':checked')) {
                        // EBSCO handles multiple limiters by repeating the key or using specific values.
                        // For our purpose, we'll append them.
                        params[$(this).attr('name')] = $(this).val();
                    }
                });

                quickLinks.each(function() {
                    var baseUrl = $(this).data('original-href');
                    var url = new URL(baseUrl);
                    
                    // Clear existing q or limiters if any, then set new ones.
                    Object.keys(params).forEach(function(key) {
                        url.searchParams.set(key, params[key]);
                    });

                    $(this).attr('href', url.toString());
                });
            };

            /**
             * Save current state to session storage.
             */
            var saveState = function() {
                sessionStorage.setItem(STORAGE_KEY, input.val());
                
                var activeFilters = [];
                filterInputs.each(function() {
                    if ($(this).is(':checked')) {
                        activeFilters.push($(this).attr('id'));
                    }
                });
                sessionStorage.setItem(FILTERS_KEY, JSON.stringify(activeFilters));
            };

            /**
             * Load state from session storage.
             */
            var loadState = function() {
                var savedQuery = sessionStorage.getItem(STORAGE_KEY);
                if (savedQuery !== null) {
                    input.val(savedQuery);
                }

                var savedFilters = sessionStorage.getItem(FILTERS_KEY);
                if (savedFilters !== null) {
                    var activeFilters = JSON.parse(savedFilters);
                    filterInputs.each(function() {
                        if (activeFilters.indexOf($(this).attr('id')) !== -1) {
                            $(this).prop('checked', true);
                        }
                    });
                }
                updateQuickLinks();
            };

            // Event listeners.
            input.on('input', function() {
                updateQuickLinks();
                saveState();
            });

            filterInputs.on('change', function() {
                updateQuickLinks();
                saveState();
            });

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

                saveState();

                if (!isNewTab) {
                    container.find('.js-search-button')
                        .prop('disabled', true)
                        .html('<i class="fa fa-spinner fa-spin"></i> Searching...');
                }
            });

            // Initial load.
            loadState();

            console.log('Library Search block with persistence initialized');
        }
    };
});
