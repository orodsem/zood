


/**
 * HealthProvider class
 */
class HealthProvider {

    constructor() {
        this.isLoading = false;

        this.url = {
            countrySearch: '',
            citySearch: '',
        };

    } // constructor()

    init() {

        var _this = this;

        $(document).ready(() => {
            _this.ready();
        });
    }

    ready() {

        var _this = this;

        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);


        this.initSelect2();

        $('#btn-verify-email').on('click', () => {
            this.verifyEmail();
        });

        $('#clinic_files').change(function() {
            _this.previewClinicFiles($(this).prop('files'));
        });

    }

    validateClinicFiles(clinic_files) {

        // clinic_files = $(clinic_files);
        const validImageTypes = ['image/jpeg', 'image/png'];

        if (!clinic_files || !clinic_files[0])
            return false;

        for (const i in clinic_files) {

            let fileType = clinic_files[i]['type'];

            if (!fileType) continue;

            if (!validImageTypes.includes(fileType))
                return false;
        }

        return true;
    }

    previewClinicFiles(clinic_files) {

        let valid = this.validateClinicFiles(clinic_files);

        $('#clinic_files_preview_container').html(null);

        let html = '';

        if (valid) {
            for (const i in clinic_files) {
                try {
                    let url = window.URL.createObjectURL(clinic_files[i]);
                    html += `<img src="${url}" class="img-thumbnail m-1" height="100" width="100">`;
                } catch (e) {}
            }
            console.log(html);
            $('#clinic_files_preview_container').html(html);
        }
    }

    initSelect2() {
        $('#country').select2({
            width: 'resolve',
            delay: 500,
            placeholder: 'Search a Country',
            minimumInputLength: 1,
            ajax: {
                cache: false,
                url: this.url.countrySearch,
                data: function(params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                },
                processResults: function(res) {
                    let result = $.parseJSON(res);
                    return {
                        results: result.results,
                    };
                },
            },
        });

        $('#city').select2({
            width: 'resolve',
            delay: 500,
            placeholder: 'Search a City',
            minimumInputLength: 1,
            ajax: {
                cache: false,
                url: this.url.citySearch,
                data: function(params) {
                    var query = {
                        search: params.term,
                        country: $('#country').val()
                    }
                    return query;
                },
                processResults: function(res) {
                    let result = $.parseJSON(res);
                    return {
                        results: result.results,
                    };
                },
            },
        });
    }

    verifyEmail() {

        var _this = this;

        this.showVerifyEmailLoading();

        $.ajax({
            url: this.validateEmailUrl,
            type: "post",
            dataType: "json",
            data: {
                email: $('#email').val(),
            },
            success: function(res) {
                _this.hideVerifyEmailLoading();

                if (!res.result || res.result == '400') {
                    swal({
                        title: "Something went wrong!",
                        text: "We apologize for the inconvinience. Please report this by sending us an email to contact@zood.com",
                        icon: "error",
                    });
                    return;
                }

                if (!res.data.valid) {
                    $('.email-wrapper').find('.invalid-feedback').addClass('d-block');
                    $('.email-wrapper').find('.valid-feedback').removeClass('d-block');
                } else {
                    $('.email-wrapper').find('.invalid-feedback').removeClass('d-block');
                    $('.email-wrapper').find('.valid-feedback').addClass('d-block');
                }
            },
            error: function(xhr, status, errorThrown) {
                _this.hideVerifyEmailLoading();
                swal({
                    title: "Something went wrong!",
                    text: "We apologize for the inconvinience. Please report this by sending us an email to contact@zood.com",
                    icon: "error",
                });
            }
        });
    }

    showVerifyEmailLoading() {
        $('#btn-verify-email').attr('disabled', true);
        $('#btn-verify-email').find('.fas')
            .removeClass('fa-check')
            .addClass('fa-circle-notch')
            .addClass('fa-spin');
    }

    hideVerifyEmailLoading() {
        $('#btn-verify-email').attr('disabled', false);
        $('#btn-verify-email').find('.fas')
            .addClass('fa-check')
            .removeClass('fa-circle-notch')
            .removeClass('fa-spin');
    }

} // class Login
