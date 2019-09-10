/**
 * login class
 */
class Login {

    constructor() {

        var _this = this;
        this.url = '';
        this.isLoading = false;

        $('#btn-login').on('click', function() {
            _this.tryLogin();
        });

        $('#loginModal').find('.alert').find('button').on('click', function() {
            _this.hideModalError();
        })

        $('#loginModal').on('hide.bs.modal', function(e) {
            _this.tryPreventModalClose(e);
        });

        $('#btn-signup').on('click', function() {
            $('#loginModal').modal('hide');
            setTimeout(function() {
                $('#signUpModal').modal('show');
            }, 500);
        });

    } // constructor()

    tryLogin() {

        let _this = this;
        let emailVal = $('#modal-email').val();
        let passwordVal = $('#modal-password').val();
        // let rememberVal = $('#remember').val();

        this.showLoading();

        $.ajax({
            url: this.url,
            type: "post",
            dataType: "json",
            data: {
                email: emailVal,
                password: passwordVal
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
        $('#loginModal').find('.alert').addClass('d-none');
    }

    showModalError(msg) {

        if (typeof msg === 'undefined' || !msg)
            return;

        let modalAlert = $('#loginModal').find('.alert');
        modalAlert.find('small').html(msg);
        modalAlert.removeClass('d-none');
    }

    tryPreventModalClose(e) {

        if(typeof e === 'undefined')
            return;

        if (this.isLoading)
            e.preventDefault();
    }

    showLoading() {
        this.isLoading = true;
        $('#btn-login').attr('disabled', true);
        $('#modal-email').attr('disabled', true);
        $('#modal-password').attr('disabled', true);
        $('#login-icon').addClass('d-none');
        $('#login-spinner').removeClass('d-none');
    }

    hideLoading() {
        this.isLoading = false;
        $('#btn-login').attr('disabled', false);
        $('#modal-email').attr('disabled', false);
        $('#modal-password').attr('disabled', false);
        $('#login-icon').removeClass('d-none');
        $('#login-spinner').addClass('d-none');
    }

} // class Login
