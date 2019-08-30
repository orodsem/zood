/**
 * login class
 */
class Login {

    constructor() {

        var _this = this;
        this.url = '';

        $('#btn-login').on('click', function() {
            _this.tryLogin();
        });

        // @todo: delete
        $('#login-button').click();

    } // constructor()

    tryLogin() {

        let _this = this;
        let emailVal = $('#email').val();
        let passwordVal = $('#password').val();
        let rememberVal = $('#remember').val();

        this.showLoading();

        $.ajax({
            url: this.url,
            type: "post",
            dataType: "json",
            data: {
                email: emailVal,
                password: passwordVal
            },
            success: function (data)
            {
                _this.hideLoading();
                console.log(data);
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

    showLoading() {
        $('#btn-login').attr('disabled', true);
        $('#email').attr('disabled', true);
        $('#password').attr('disabled', true);
        $('#login-text').addClass('d-none');
        $('#login-spinner').removeClass('d-none');
    }

    hideLoading() {
        $('#btn-login').attr('disabled', false);
        $('#email').attr('disabled', false);
        $('#password').attr('disabled', false);
        $('#login-text').removeClass('d-none');
        $('#login-spinner').addClass('d-none');
    }

} // class Login
