var Settings = function () {

    var init = function () {
        $.extend(config, new_config);
        handleSubmit();
        handleEditors();


    };
    var handleEditors = function () {
        if ($('#content_ar').length > 0) {
            $('#content_ar').summernote({height: 200});
        }

    }


    var handleSubmit = function () {

        $('#editSettingsForm').validate({
//            ignore: "",
            rules: {
//                'ssetting[value][phone]': {
//                    required: true
//                },
//                'ssetting[value][email]': {
//                    required: true
//                },

            },
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
        $('#editSettingsForm .submit-form').click(function () {
            if ($('#editSettingsForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#editSettingsForm').submit();
                }, 500);
            }
            return false;
        });
        $('#editSettingsForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#editSettingsForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#editSettingsForm').submit();
                    }, 500);
                }
                return false;
            }
        });



        $('#editSettingsForm').submit(function () {
            var id = $('#id').val();
            var action = config.admin_url + '/settings/' + id;
            var formData = new FormData($(this)[0]);
            formData.append('_method', 'PATCH');
             if ($('#content_ar').length > 0) {
                formData.append('setting[value][content_ar]', $('#content_ar').code());
            }
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

    return {
        init: function () {
            init();
        }
    };

}();
jQuery(document).ready(function () {
    Settings.init();
});