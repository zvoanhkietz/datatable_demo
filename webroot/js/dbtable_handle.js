var Dt = Dt || {};
Dt.Handle = (function ($) {
    /**
     * Options to draw table
     * 
     * @type array options
     */
    var _options;

    /**
     * 
     * @type DataTable
     */
    var _table;

    /**
     * Create link with parameter
     * 
     * @param {Object} params
     * @returns {String}
     */
    function buildLink(params) {
        return _options.url + "?" + $.param(params);
    }

    /**
     * Build search params for sending
     * 
     * @param {type} columns
     * @returns {unresolved}
     */
    function buildSearchParams(columns) {
        var search_data = {};
        columns.forEach(function (col) {
            if (col.search.value !== "") {
                search_data[col.data] = col.search.value;
            }
        });
        return search_data;
    }

    /**
     * Build query link with parameters
     * 
     * @param {Array} data
     * @returns {Object}
     */
    function buildLinkParams(data) {
        var query = {};
        // create page query
        if (data.page > 1) {
            query.page = data.page;
        }

        // create limit query
        if (data.limit !== data.defaultLimit) {
            query.limit = data.limit;
        }

        // sort
        query.sort = data.sort;
        query.direction = data.direction;

        // search
        if (data.search) {
            query.search = data.search;
        }
        return query;
    }

    /**
     * Get targets number by column name
     * 
     * @param {String} column_name
     * @returns {Number|i}
     */
    function getTargets(column_name) {
        var targets = 0;
        _options.config.columns.every(function (v, i) {
            if (v.data === column_name) {
                targets = i;
                return false;
            }
            return true;
        });
        return targets;
    }

    /**
     * Draw table with data
     * 
     * @param {type} data
     * @returns {undefined}
     */
    function initDataTable(_data) {
        // order
        var order = [];
        _options.config.columns.every(function (v, i) {
            if (v.data === _data.sort) {
                order.push([i, _data.direction]);
                return false;
            }
            return true;
        });

        // render columns
        var columnDefs = [
            {
                targets: getTargets('checkbox'),
                data: 'checkbox',
                render: function (data, type, row, meta) {
                    return "<input type='checkbox' class='cb-item' value='" + row.id + "' />";
                }
            },
            {
                targets: getTargets('role'),
                data: 'role',
                render: function (data, type, row, meta) {
                    return (row.role) ? row.role.name : "";
                }
            },
            {
                targets: getTargets('action'),
                data: 'action',
                render: function (data, type, row, meta) {
                    return "<button class='btn btn-sm btn-primary'><i class='fa fa-edit'></i></button>\n\
                            <button class='btn btn-sm btn-danger'><i class='fa fa-remove'></i></button>";
                }
            }
        ];

        // create table option
        var options = $.extend({}, _options.config, {
            processing: true,
            serverSide: true,
            destroy: true,
            order: order,
            dom: '<"wrapper row"r<"row" <"col-md-12"f>><"top row"<"col-md-4"l><"col-md-8"p>>t<"bottom row"<"col-md-4"i><"col-md-8"p>>>',
            columnDefs: columnDefs,
            language: {
                processing: '<div class="overlay"></div><div class="loading-content"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><p>Processing...</p><div>'
            },
            ajax: function (data, callback, settings) {
                callback(_data);
            },
            drawCallback: function (settings) {
                if (settings.json) {
                    var query = buildLinkParams(settings.json);
                    var link = buildLink(query);
                    history.pushState(settings.json, null, link);
                } else {
                    history.replaceState(_data, null, null);
                }
            }
        });

        // init table
        _table = $(_options.object).DataTable(options);

        // draw limit & select current pahe
        _table.page.len(_data.limit);
        _table.page(_data.page - 1);
        _table.draw('page');
    }

    /**
     * 
     * @param {type} options
     * @param {type} data
     * @returns {undefined}
     */
    function changeDtToAjaxHandle() {
        _table.ajax.url({
            url: _options.url,
            type: 'GET',
            data: function (params) {
                var config = _options.config;
                var search_data = buildSearchParams(params.columns);
                var query = {
                    page: _table.page() + 1,
                    limit: params.length,
                    sort: config.columns[params.order[0].column].data,
                    direction: params.order[0].dir,
                    search: search_data
                };
                return query;
            }
        });
    }

    /**
     * Pop state enver
     * 
     * @returns {undefined}
     */
    function processHistoryPopstate() {
        window.onpopstate = function (e) {
            // init datatable with data
            initDataTable(e.state);

            // change datatable to ajax handle
            changeDtToAjaxHandle();
        };
    }

    // public method & property
    return {
        init: function (options, data) {
            _options = options;

            // init datatable with data
            initDataTable(data);

            // change datatable to ajax handle
            changeDtToAjaxHandle();

            // history popstate
            processHistoryPopstate();
        }
    };
})(jQuery);