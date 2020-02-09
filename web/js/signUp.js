/**
 * signUp class
 */
class SignUp {

    constructor() {

        this.url = '';
        this.isLoading = false;

        this.countrySelect = new CountrySelect();
        this.citySelect = new CitySelect();

        this.form = {
            type : {
                value: '',
                valid: true
            },
            first_name : {
                value: '',
                valid: true
            },
            last_name : {
                value: '',
                valid: true
            },
            country : {
                value: '',
                valid: true
            },
            city : {
                value: '',
                valid: true
            },
            email : {
                value: '',
                valid: true
            },
            password : {
                value: '',
                valid: true
            },
            password_confirmation : {
                value: '',
                valid: true
            },
        }
    } // constructor()

    init() {

        let _this = this;

        this.countrySelect.init();
        this.citySelect.init();

        $('#btn-signUp-submit').on('click', function() {
            _this.trySignUp();
        });

        $('#signUpModal').find('.alert').find('button').on('click', function() {
            _this.hideModalError();
        })

        $('#signUpModal').on('hide.bs.modal', function(e) {
            _this.tryPreventModalClose(e);
        });

        $('#signUpForm').find('input[type="text"]').on('change blur', function() {
             _this.validateForm($(this).attr('name'));
             _this.showHideErrors(true);
        });

        $('#signUpForm').find('input[type="radio"]').on('change blur', function() {
             _this.validateForm($(this).attr('name'));
             _this.showHideErrors(true);
        });

        $('#signUpForm').find('input[type="email"]').on('change blur', function() {
             _this.validateForm($(this).attr('name'));
             _this.showHideErrors(true);
        });

        $('#signUpForm').find('input[type="password"]').on('change blur', function() {
             _this.validateForm($(this).attr('name'));
             _this.showHideErrors(true);
        });

        setTimeout(function() {
            $('#country').on("change", function(e) {
                setTimeout(function() {
                    _this.validateForm('country');
                    _this.showHideErrors(true);
                }, 500);
            });

            $('#city').on("select2:select", function(e) {
                setTimeout(function() {
                    _this.validateForm('city');
                    _this.showHideErrors(true);
                }, 500);
            });

        }, 1000);
    }

    trySignUp() {

        let _this = this;

        let formValid = this.validateForm();
        this.showHideErrors();

        if (!formValid)
            return;

        this.showLoading();

        let formData = new FormData();
        $.each(_this.form, function(i,v) {
            formData.append(i, v.value);
        });

        $.ajax({
            url: this.url,
            type: "POST",
            // dataType: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res)
            {
                _this.hideLoading();

                if (!res.messages) {
                    swal({
                        title: "Something went wrong!",
                        text: "We apologize for the inconvinience. Please report this by sending us an email to contact@zood.com",
                        icon: "error",
                    });
                }

                if (res.status == false) {
                    _this.showMessage(res.messages, 'error');
                    return;
                }

                _this.clearForm();

                _this.showMessage(res.messages, 'success');
            },
            error: function (xhr, status, errorThrown) {
                _this.hideLoading();
                swal({
                    title: "Something went wrong!",
                    text: "We apologize for the inconvinience. Please report this by sending us an email to contact@zood.com",
                    icon: "error",
                });
            }
        });

    }

    clearForm() {
        $('[name="first_name"]').val(null);
        $('[name="last_name"]').val(null);
        $('[name="country"]').val(null);
        $('[name="country"]').trigger('change');
        $('[name="city"]').val(null);
        $('[name="city"]').trigger('change');
        $('[name="email"]').val(null);
        $('[name="password_confirmation"]').val(null);
    }

    validateForm(form_name) {

        let valid = true;
        form_name = typeof form_name !== 'undefined' && form_name ? form_name : 'all';

        this.form.type.value = $('[name="type"]:checked').val();
        this.form.first_name.value = $('#signUp-first_name').val();
        this.form.last_name.value = $('#signUp-last_name').val();
        this.form.country.value = this.countrySelect.value;
        this.form.city.value = this.citySelect.value;
        this.form.email.value = $('#signUp-email').val();
        this.form.password.value = $('#signUp-password').val();
        this.form.password_confirmation.value = $('#signUp-password_confirmation').val();

        let re_name = /^([a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*){1,255}$/;

        let re_email = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        // Minimum eight characters, at least one letter and one number:
        let re_pass = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        if (form_name == 'type' || form_name == 'all') {
            if (!this.form.type.value) {
                this.form.type.valid = false;
                valid = false;
            } else {
                this.form.type.valid = true;
            }
        }

        if (form_name == 'first_name' || form_name == 'all') {
            if (!this.form.first_name.value.match(re_name)) {
                this.form.first_name.valid = false;
                valid = false;
            } else {
                this.form.first_name.valid = true;
            }
        }

        if (form_name == 'last_name' || form_name == 'all') {
            if (!this.form.last_name.value.match(re_name)) {
                this.form.last_name.valid = false;
                valid = false;
            } else {
                this.form.last_name.valid = true;
            }
        }

        if (form_name == 'country' || form_name == 'all') {
            if (!this.form.country.value.match(re_name)) {
                this.form.country.valid = false;
                valid = false;
            } else {
                this.form.country.valid = true;
            }
        }

        if (form_name == 'city' || form_name == 'all') {
            if (!this.form.city.value.match(re_name)) {
                this.form.city.valid = false;
                valid = false;
            } else {
                this.form.city.valid = true;
            }
        }

        if (form_name == 'email' || form_name == 'all') {
            if (!this.form.email.value.match(re_email)) {
                this.form.email.valid = false;
                valid = false;
            } else {
                this.form.email.valid = true;
            }
        }

        if (form_name == 'password' || form_name == 'all') {
            if (!this.form.password.value.match(re_pass)) {
                this.form.password.valid = false;
                valid = false;
            } else {
                this.form.password.valid = true;
            }
        }

        if (form_name == 'password_confirmation' || form_name == 'all') {
            if (!this.form.password_confirmation.value.match(re_pass)) {
                this.form.password_confirmation.valid = false;
                valid = false;
            } else {
                this.form.password_confirmation.valid = true;
            }
        }

        if (form_name == 'all') {
            if (this.form.password_confirmation.value != this.form.password.value) {
                this.form.password.valid = false;
                this.form.password_confirmation.valid = false;
                valid = false;
            } else if (this.form.password.value.match(re_pass) && this.form.password_confirmation.value.match(re_pass)) {
                this.form.password.valid = true;
                this.form.password_confirmation.valid = true;
            }
        }

        return valid;
    }

    showHideErrors(focusOff) {
        let _this = this;

        let focusElem = null;

        $.each(this.form, function(i,v) {
            let invalid_feedback = $(`[name="${i}"]`).parents('.form-group').find('.invalid-feedback');

            if (!v.valid) {
                focusElem = focusElem ? focusElem : i;
                invalid_feedback.addClass('d-block');
            } else {
                invalid_feedback.removeClass('d-block');
            }
        });

        if (focusElem && typeof focusOff === 'undefined')
            $(`[name="${focusElem}"]`).focus();
    }

    hideModalError() {
        $('#signUpModal').find('.alert').addClass('d-none');
    }

    showMessage(msg, type) {

        let messages = [];

        let container = $('#signUpModal').find('#errorMessagesContainer');
        container.html(null);
        container.addClass('d-none');

        if (typeof msg === 'string')
            messages.push(msg);
        else if (typeof msg === 'array' || typeof msg === 'object')
            messages = msg;
        else
            return;

        type = typeof type === 'undefined' || !type ? 'error' : type;

        let alertType = type == 'error' ? 'alert-danger' : 'alert-success';

        let html = '';
        $.each(messages, function(i,v) {
            html += `<div class="alert ${alertType} alert-dismissible fade show p-1 rounded-0 text-center" role="alert">
                  <small>${v}</small>
                  <button type="button" class="close p-1 pr-2" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            `;
        });

        container.html(html);
        container.removeClass('d-none');
        $('#signUpModal').scrollTop(0);
    }

    tryPreventModalClose(e) {

        if(typeof e === 'undefined')
            return;

        if (this.isLoading) {
            e.preventDefault();
            return;
        }

        $('#loginModal').modal('show');
    }

    showLoading() {
        this.isLoading = true;
        $('#btn-submit').attr('disabled', true);
        $('#signUp-type').attr('disabled', true);
        $('#signUp-email').attr('disabled', true);
        $('#city').attr('disabled', true);
        $('#country').attr('disabled', true);
        $('#signUp-first_name').attr('disabled', true);
        $('#signUp-last_name').attr('disabled', true);
        $('#signUp-password').attr('disabled', true);
        $('#signUp-password_confirmation').attr('disabled', true);
        $('#signUp-icon').addClass('d-none');
        $('#signUp-spinner').removeClass('d-none');
    }

    hideLoading() {
        this.isLoading = false;
        $('#btn-submit').attr('disabled', false);
        $('#signUp-type').attr('disabled', false);
        $('#signUp-email').attr('disabled', false);
        $('#city').attr('disabled', false);
        $('#country').attr('disabled', false);
        $('#signUp-first_name').attr('disabled', false);
        $('#signUp-last_name').attr('disabled', false);
        $('#signUp-password').attr('disabled', false);
        $('#signUp-password_confirmation').attr('disabled', false);
        $('#signUp-icon').removeClass('d-none');
        $('#signUp-spinner').addClass('d-none');
    }

} // class SignUp
