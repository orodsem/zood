/**
 * country-select class
 */
class CountrySelect {

    constructor() {

        this.selector = '';

        this.options = [];

        this.value = '';

        this.getUrl = '';

    } // constructor()

    init() {

        'use strict';

        var _this = this;

        $(document).ready(() => {
            _this.setView();
            _this.getCountries();
        });
    }

    setView() {

        let _this = this;

        if (!this.selector)
            return;

        $(this.selector).html(`
            <select type="text"
                name="country"
                class="form-control rounded-0"
                data-name="country"
                aria-describedby="country"
                placeholder=""
                maxlength="255"
                autocomplete="off"
                required
            ></select>
        `);

        $('[data-name="country"]').on('change', () => {
            _this.value = $(this).value();
        });

        setTimeout(function() {
            $(_this.selector).find('select').select2({
                width: 'resolve',
                delay: 1000,
                placeholder: 'Search a Country',
                minimumInputLength: 1,
                ajax: {
                    cache: false,
                    url: _this.getUrl,
                    data: function(params) {
                        var query = {
                            search: params.term,
                            token: _this.token,
                        }
                        return query;
                    },
                    processResults: function(res) {
                        return {
                            results: res.results,
                        };
                    },
                },
            });
        }, 500);
    }

    getCountries(cb) {

        if (typeof cb === 'function')
            cb();


    }

}
