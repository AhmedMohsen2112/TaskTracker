
var errors = [];
var Register = function () {

    var init = function () {

        handle_register();

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
                $(element).removeClass('is-valid').addClass('is-invalid');

            },
            unhighlight: function (element) {
//                console.log('here');
                $(element).removeClass('is-invalid').addClass('is-valid');
                $(element).closest('.form-group').find('.invalid-feedback').html('');

            },
            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.invalid-feedback').html($(error).html());
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
                url: config.site_url + "/register",
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

    return {
        init: function () {
            init();
        }
    }

}();

jQuery(document).ready(function () {
    Register.init();
});


