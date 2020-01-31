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
            password_conf : {
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
    }

    trySignUp() {

        let _this = this;

        let formValid = this.isFormValid();

        this.showLoading();

        $.ajax({
            url: this.url,
            type: "post",
            dataType: "json",
            data: {_this.form},
            success: function (res)
            {
                _this.hideLoading();

                if (!res.result || res.result == '400') {
                    _this.showModalError(res.message);
                    return;
                }

                window.location = res.data.url;
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

    isFormValid() {

        this.form.first_name.value = $('#signUp-first_name').val();
        this.form.last_name.value = $('#signUp-last_name').val();
        this.form.country.value = this.countrySearch.value;
        this.form.city.value = this.countrySearch.value;
        this.form.email.value = $('#signUp-email').val();
        this.form.email.password = $('#signUp-password').val();
        this.form.email.password_confirm = $('#signUp-password_confirmation').val();

        let re_name = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
        if (!firstName.match(re_name))
            this.form.first_name.valid = false;
        
    }

    hideModalError() {
        $('#signUpModal').find('.alert').addClass('d-none');
    }

    showModalError(msg) {

        if (typeof msg === 'undefined' || !msg)
            return;

        let modalAlert = $('#signUpModal').find('.alert');
        modalAlert.find('small').html(msg);
        modalAlert.removeClass('d-none');
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
        $('#signUp-email').attr('disabled', true);
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
        $('#signUp-email').attr('disabled', false);
        $('#signUp-first_name').attr('disabled', false);
        $('#signUp-last_name').attr('disabled', false);
        $('#signUp-password').attr('disabled', false);
        $('#signUp-password_confirmation').attr('disabled', false);
        $('#signUp-icon').removeClass('d-none');
        $('#signUp-spinner').addClass('d-none');
    }

} // class SignUp
