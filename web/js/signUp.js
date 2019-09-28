/**
 * signUp class
 */
class SignUp {

    constructor() {

        var _this = this;
        this.url = '';
        this.isLoading = false;

        $('#btn-signUp-submit').on('click', function() {
            _this.trySignUp();
        });

        $('#signUpModal').find('.alert').find('button').on('click', function() {
            _this.hideModalError();
        })

        $('#signUpModal').on('hide.bs.modal', function(e) {
            _this.tryPreventModalClose(e);
        });

        // @todo: delete
        $('#signUpModal').modal('show');

    } // constructor()

    trySignUp() {

        let _this = this;

        this.showLoading();

        $.ajax({
            url: this.url,
            type: "post",
            dataType: "json",
            data: {
                first_name: $('#signUp-first_name').val(),
                last_name: $('#signUp-last_name').val(),
                email: $('#signUp-email').val(),
                password: $('#signUp-password').val(),
                password_confirmation: $('#signUp-password_confirmation').val(),
            },
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
