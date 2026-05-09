define(['jquery', 'core/notification'], function($, Notification) {
    "use strict";

    var SESSION_KEY = 'block_librarysearch_last_query';
    var FILTERS_KEY = 'block_librarysearch_last_filters';
    var HISTORY_KEY = 'block_librarysearch_history';
    var TYPE_KEY = 'block_librarysearch_last_type';

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
            var clearBtn = container.find('.js-clear-search');
            var voiceBtn = container.find('.js-voice-search');
            var typeButtons = container.find('.js-search-type');
            var typeInput = container.find('.js-search-type-input');
            var recentContainer = container.find('.js-recent-searches-container');
            var recentPills = container.find('.js-recent-pills');
            var isNewTab = container.data('newtab') == 1;

            console.log('Library Search: Advanced initialization started');

            /**
             * Update all quick links with the current search query and filters.
             */
            var updateQuickLinks = function() {
                var query = input.val().trim();
                var searchType = typeInput.val();

                quickLinks.each(function() {
                    var baseUrl = $(this).attr('data-original-href') || $(this).attr('href');
                    if (!$(this).attr('data-original-href')) {
                        $(this).attr('data-original-href', baseUrl);
                    }

                    if (query === '') {
                        $(this).attr('href', baseUrl);
                        return;
                    }

                    try {
                        var url = new URL(baseUrl);
                        url.search = ''; // Clear existing params.

                        // Map search types to EBSCO field codes if applicable.
                        var qValue = query;
                        if (searchType === 'title') qValue = 'TI ' + query;
                        else if (searchType === 'author') qValue = 'AU ' + query;

                        url.searchParams.set('q', qValue);
                        url.searchParams.set('autocorrect', 'y');
                        url.searchParams.append('limiters', 'FT1:Y');

                        filterInputs.each(function() {
                            if ($(this).is(':checked')) {
                                url.searchParams.append('limiters', $(this).val());
                            }
                        });

                        $(this).attr('href', url.toString());
                    } catch (e) {
                        console.error('Library Search: Link update failed', e);
                    }
                });
            };

            /**
             * Voice Search implementation.
             */
            var startVoiceSearch = function() {
                if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                    Notification.alert('Not Supported', 'Voice search is not supported in your browser.', 'OK');
                    return;
                }

                var Recognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                var recognition = new Recognition();

                recognition.lang = 'en-US';
                recognition.interimResults = false;
                recognition.maxAlternatives = 1;

                voiceBtn.addClass('recording');
                
                recognition.onresult = function(event) {
                    var transcript = event.results[0][0].transcript;
                    input.val(transcript).trigger('input');
                    voiceBtn.removeClass('recording');
                    form.submit();
                };

                recognition.onerror = function() {
                    voiceBtn.removeClass('recording');
                };

                recognition.onend = function() {
                    voiceBtn.removeClass('recording');
                };

                recognition.start();
            };

            /**
             * History Management.
             */
            var updateHistoryUI = function() {
                var history = JSON.parse(localStorage.getItem(HISTORY_KEY) || '[]');
                if (history.length === 0) {
                    recentContainer.addClass('d-none');
                    return;
                }

                recentContainer.removeClass('d-none');
                recentPills.empty();

                history.forEach(function(term) {
                    var pill = $('<button type="button" class="recent-pill-item"></button>').text(term);
                    pill.on('click', function() {
                        input.val(term).trigger('input');
                        form.submit();
                    });
                    recentPills.append(pill);
                });
            };

            var addToHistory = function(term) {
                if (!term || term.trim() === '') return;
                term = term.trim();
                
                var history = JSON.parse(localStorage.getItem(HISTORY_KEY) || '[]');
                // Remove if exists and add to front.
                history = history.filter(function(h) { return h !== term; });
                history.unshift(term);
                // Keep last 5.
                history = history.slice(0, 5);
                
                localStorage.setItem(HISTORY_KEY, JSON.stringify(history));
                updateHistoryUI();
            };

            /**
             * Save current state.
             */
            var saveState = function() {
                sessionStorage.setItem(SESSION_KEY, input.val());
                localStorage.setItem(TYPE_KEY, typeInput.val());
                
                var activeFilters = [];
                filterInputs.each(function() {
                    if ($(this).is(':checked')) activeFilters.push($(this).attr('id'));
                });
                sessionStorage.setItem(FILTERS_KEY, JSON.stringify(activeFilters));
            };

            /**
             * Load previous state.
             */
            var loadState = function() {
                var savedQuery = sessionStorage.getItem(SESSION_KEY);
                if (savedQuery) {
                    input.val(savedQuery);
                    clearBtn.removeClass('d-none');
                }

                var savedType = localStorage.getItem(TYPE_KEY) || 'keyword';
                typeButtons.removeClass('active');
                container.find('[data-type="' + savedType + '"]').addClass('active');
                typeInput.val(savedType);

                var savedFilters = sessionStorage.getItem(FILTERS_KEY);
                if (savedFilters) {
                    var activeFilters = JSON.parse(savedFilters);
                    filterInputs.each(function() {
                        $(this).prop('checked', activeFilters.indexOf($(this).attr('id')) !== -1);
                    });
                }
                
                updateQuickLinks();
                updateHistoryUI();
            };

            // Event Listeners.
            input.on('input', function() {
                var val = $(this).val();
                if (val.length > 0) clearBtn.removeClass('d-none');
                else clearBtn.addClass('d-none');
                
                updateQuickLinks();
                saveState();
            });

            clearBtn.on('click', function() {
                input.val('').trigger('input').focus();
            });

            voiceBtn.on('click', function() {
                startVoiceSearch();
            });

            typeButtons.on('click', function() {
                typeButtons.removeClass('active');
                $(this).addClass('active');
                typeInput.val($(this).data('type'));
                updateQuickLinks();
                saveState();
            });

            container.find('.js-clear-history').on('click', function() {
                localStorage.removeItem(HISTORY_KEY);
                updateHistoryUI();
            });

            filterInputs.on('change', function() {
                updateQuickLinks();
                saveState();
            });

            form.on('submit', function(e) {
                var query = input.val().trim();
                if (query === '') {
                    e.preventDefault();
                    return false;
                }

                addToHistory(query);
                saveState();

                if (!isNewTab) {
                    container.find('.js-search-button')
                        .prop('disabled', true)
                        .html('<i class="fa fa-spinner fa-spin"></i> Searching...');
                }
            });

            // Initial load.
            loadState();
        }
    };
});
