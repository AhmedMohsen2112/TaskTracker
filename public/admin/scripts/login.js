
var errors = [];
var Login = function () {

    var init = function () {

        handleAjaxSetupMethods();
        handle_login();
        handle_register();
        handleShowForm();
    }
    var handleAjaxSetupMethods = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
    var handleShowForm = function () {
        $('#register-btn').click(function () {
            $('.login-form').hide();
            $('.register-form').show();
        });

        $('#register-back-btn').click(function () {
            $('.login-form').show();
            $('.register-form').hide();
        });
    }
    var handle_register = function () {
        $("#register-form").validate({
            rules: {
                name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                phone: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password",
                }
            },
            messages: lang.messages,
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');

            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                $(element).closest('.form-group').find('.help-block').html('');

            },
            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.help-block').html($(error).html());
            }

        });
        $('#register-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#register-form').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#register-form').submit();
                    }, 500);

                }
                return false;
            }
        });
        $('#register-form .submit-form').click(function () {
            //alert('33333');
            if ($('#register-form').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#register-form').submit();
                }, 500);
            }
            return false;
        });
        $('#register-form').submit(function () {
            $.ajax({
                url: config.admin_url + "/register",
                type: 'POST',
                dataType: 'JSON',
                data: $(this).serialize(),
                async: false,
                success: function (data)
                {
                    console.log(data);
                    My.unblockUI();
                    window.location.href = data.url;


                },
                error: function (xhr, textStatus, errorThrown) {
                    My.unblockUI();
                    My.ajax_error_message(xhr);

                },
            });

            return false;
        });

    }
    var handle_login = function () {
        $("#login-form").validate({
            rules: {
                username: {
                    required: true,
                },
                password: {
                    required: true
                }
            },
            messages: lang.messages,
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');

            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                $(element).closest('.form-group').find('.help-block').html('');

            },
            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.help-block').html($(error).html());
            }

        });
        $('#login-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#login-form').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#login-form').submit();
                    }, 500);

                }
                return false;
            }
        });
        $('#login-form  .submit-form').click(function () {
            //alert('33333');
            if ($('#login-form').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#login-form').submit();
                }, 500);
            }
            return false;
        });
        $('#login-form').submit(function () {
            $.ajax({
                url: config.admin_url + "/login",
                type: 'POST',
                dataType: 'JSON',
                data: $(this).serialize(),
                success: function (data)
                {
                    console.log(data);
                    My.unblockUI();
                    window.location.href = data.url;


                },
                error: function (xhr, textStatus, errorThrown) {
                    My.unblockUI();
                    My.ajax_error_message(xhr);

                },
            });

            return false;
        });

    }

    return {
        init: function () {
            init();
        }
    }

}();

jQuery(document).ready(function () {
    Login.init();
});


