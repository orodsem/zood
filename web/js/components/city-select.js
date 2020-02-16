/**
 * city-select class
 */
class CitySelect {

    constructor() {

        this.selector = '';
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
                id="city"
                name="city"
                class="form-control rounded-0"
                aria-describedby="city"
                placeholder=""
                maxlength="255"
                autocomplete="off"
                required
            ></select>
        `);

        setTimeout(function() {

            $('#city').on('change', function() {
                _this.value = $(this).val();
            });

            $('#city').select2({
                width: 'resolve',
                delay: 2000,
                placeholder: 'Search a City',
                minimumInputLength: 1,
                ajax: {
                    cache: false,
                    url: _this.getUrl,
                    data: function(params) {
                        var query = {
                            search: params.term,
                            country: $('#country').val(),
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
