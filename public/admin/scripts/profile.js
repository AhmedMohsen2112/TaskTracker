
var Profile = function () {
    var init = function () {
        handleSubmit();

    };

    var handleSubmit = function () {

        $('#addEditProfileForm').validate({
            rules: {
                name: {
                    required: true
                },
                username: {
                    required: true
                },
                phone: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                },
            },
            //messages: lang.messages,
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');

            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                $(element).closest('.form-group').find('.help-block').html('').css('opacity', 0);

            },
            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.help-block').html($(error).html()).css('opacity', 1);
            }
        });
        $('#addEditProfileForm .submit-form').click(function () {
            if ($('#addEditProfileForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#addEditProfileForm').submit();
                }, 1000);

            }
            return false;
        });
        $('#addEditProfileForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#addEditProfileForm').validate().form()) {
                     My.blockUI();
                    setTimeout(function () {
                        $('#addEditProfileForm').submit();
                    }, 1000);
                }
                return false;
            }
        });



        $('#addEditProfileForm').submit(function () {
            var formData = new FormData($(this)[0]);
            formData.append('_method', 'PATCH');
            var action = config.admin_url + '/profile/account/edit';
     
     

            $.ajax({
                url: action,
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                      My.unblockUI();

                   My.toast(data.message);
                },
                error: function (xhr, textStatus, errorThrown) {
                      My.unblockUI();
                    My.ajax_error_message(xhr, $(this));
                },
                dataType: "json",
                type: "POST"
            });

            return false;

        })




    }



    return{
        init: function () {
            init();
        }

    };
}();
$(document).ready(function () {
    Profile.init();
});