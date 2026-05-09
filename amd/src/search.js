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

            console.log('Library Search: Initializing with selector: ' + selector);

            /**
             * Update all quick links with the current search query and filters.
             */
            var updateQuickLinks = function() {
                var query = input.val().trim();
                console.log('Library Search: Updating links for query: ' + query);

                quickLinks.each(function() {
                    var baseUrl = $(this).data('original-href');
                    try {
                        var url = new URL(baseUrl);
                        
                        // Clear existing q and limiters to start fresh.
                        url.searchParams.delete('q');
                        url.searchParams.delete('limiters');

                        if (query !== '') {
                            url.searchParams.set('q', query);
                            url.searchParams.set('autocorrect', 'y');
                            
                            // EBSCO default limiter.
                            url.searchParams.append('limiters', 'FT1:Y');

                            // Add active filters.
                            filterInputs.each(function() {
                                if ($(this).is(':checked')) {
                                    url.searchParams.append('limiters', $(this).val());
                                }
                            });
                        }

                        $(this).attr('href', url.toString());
                    } catch (e) {
                        console.error('Library Search: Invalid URL ' + baseUrl);
                    }
                });
            };

            /**
             * Save current state to session storage.
             */
            var saveState = function() {
                var query = input.val();
                sessionStorage.setItem(STORAGE_KEY, query);
                
                var activeFilters = [];
                filterInputs.each(function() {
                    if ($(this).is(':checked')) {
                        activeFilters.push($(this).attr('id'));
                    }
                });
                sessionStorage.setItem(FILTERS_KEY, JSON.stringify(activeFilters));
                console.log('Library Search: State saved');
            };

            /**
             * Load state from session storage.
             */
            var loadState = function() {
                var savedQuery = sessionStorage.getItem(STORAGE_KEY);
                console.log('Library Search: Loading query: ' + savedQuery);
                if (savedQuery !== null) {
                    input.val(savedQuery);
                }

                var savedFilters = sessionStorage.getItem(FILTERS_KEY);
                if (savedFilters !== null) {
                    var activeFilters = JSON.parse(savedFilters);
                    console.log('Library Search: Loading filters: ', activeFilters);
                    filterInputs.each(function() {
                        if (activeFilters.indexOf($(this).attr('id')) !== -1) {
                            $(this).prop('checked', true);
                        } else {
                            $(this).prop('checked', false);
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

            console.log('Library Search: Ready');
        }
    };
});
