/**
 * HealthProviderSearch class
 */
class HealthProviderSearch {

    constructor() {
        this.isLoading = false;

        this.looking_for_list = [];

        this.country_list = [];

        this.health_conditions_list = [];

    } // constructor()

    init() {

        var _this = this;

        $(document).ready(() => {
            _this.ready();
        });

        $('#calendar_availability').daterangepicker({
            opens: 'center',
            timePicker: true,
            locale: {
                format: 'YYYY-MM-DD hh:mm'
            }
        }).on('show.daterangepicker', (ev, picker) => {
            //
        });

        $('#date_of_birth').daterangepicker({
            opens: 'center',
            timePicker: false,
            locale: {
                format: 'YYYY-MM-DD'
            }
        }).on('show.daterangepicker', (ev, picker) => {
            //
        });

    }

    ready() {

        let _this = this;

        'use strict';

        $('#date_of_birth').daterangepicker({
            "singleDatePicker": true,
            "startDate": "12/11/2019",
            "endDate": "12/17/2019",
            opens: 'center',
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        this.lookingForInit();

        this.countryInit();

        this.healthConditionsInit();

    }

    lookingForInit() {

        let html = '';

        if (this.looking_for_list.length < 1)
            return;

        for (const i in this.looking_for_list) {
            html += `
                <div class="form-check col-md-5 col-sm-6 col-xs-12 mt-2">
                    <input class="form-check-input" name="looking_for[]" type="checkbox" id="looking_for_${this.looking_for_list[i]}" value="${this.looking_for_list[i]}" required>
                    <label class="form-check-label" for="looking_for_${this.looking_for_list[i]}">${this.looking_for_list[i]}</label>
                </div>
            `;
        }

        $('#looking_for_list_container').html(html);
    }

    countryInit() {

        let html = '';

        if (this.country_list.length < 1)
            return;

        for (const i in this.country_list) {

            html += `
                <div class="form-check form-check-inline mt-2">
                    <input class="form-check-input" name="country[]" type="checkbox" id="country_${this.country_list[i]}" value="${this.country_list[i]}" required>
                    <label class="form-check-label" for="country_${this.country_list[i]}">${this.country_list[i]}</label>
                </div>
            `;
        }

        $('#country_list_container').html(html);
    }

    healthConditionsInit() {

        let html = '';

        if (this.health_conditions_list.length < 1)
            return;

        for (const i in this.health_conditions_list) {

            html += `
                <div class="col-md-5 col-sm-6 col-xs-12 pl-5 mt-2">
                    <input class="form-check-input" name="health_condition[]" type="checkbox" id="health_condition_${this.health_conditions_list[i]}" value="${this.health_conditions_list[i]}" required>
                    <label class="form-check-label" for="health_condition_${this.health_conditions_list[i]}">${this.health_conditions_list[i]}</label>
                </div>
            `;
        }

        $('#health_conditions_list_container').html(html);
    }

} // class Login
