/**
 * HealthProviderSearch class
 */
class HealthProviderSearch {

    constructor() {
        this.isLoading = false;

    } // constructor()

    init() {

        var _this = this;

        $(document).ready(() => {
            _this.ready();
        });
    }

    ready() {

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
    }

} // class Login
