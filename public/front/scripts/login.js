
var errors = [];
var Login = function () {

    var init = function () {

        handle_login();
  

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
            messages: {
                username: {
                    required: lang.required
                },
                password: {
                    required: lang.required
                }
            },
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
        $('#login-form .submit-form').click(function () {
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
                url: config.site_url + "/login",
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


