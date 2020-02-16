/**
 * country-select class
 */
class CountrySelect {

    constructor() {

        this.selector = '';

        this.options = [];

        this.token = '';

        this.value = '';

        this.getUrl = '';

    } // constructor()

    init() {

        'use strict';

        var _this = this;

        $(document).ready(() => {
            _this.setView();
        });
    }

    setView() {

        let _this = this;

        if (!this.selector)
            return;

        $(this.selector).html(`
            <select type="text"
                id="country"
                name="country"
                class="form-control rounded-0"
                aria-describedby="country"
                placeholder=""
                maxlength="255"
                autocomplete="off"
                required
            ></select>
        `);

        setTimeout(function() {

            $('#country').on('change', function() {
                _this.value = $(this).val();
            });

            $('#country').select2({
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
        }, 1000);
    }

}
