

var attachment_selected_id = 0;
var Attachment = function () {

    var init = function () {
        $.extend(lang, new_lang);
        $.extend(config, new_config);
        //alert('here');
        handleUpload();
        handleChangeArrowLeftAndRight();
        handleDeleteUploadPic();
        handleEditSubmit();

    };
    var handleEditSubmit = function () {

        $('#AttachmentInfoEditForm').validate({
            rules: {
                title: {
                    required: true

                },
                url: {
                    required: true

                }
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

        $('#AttachmentInfoEdit .submit-form').click(function () {
            if ($('#AttachmentInfoEditForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#AttachmentInfoEditForm').submit();
                }, 1000);

            }
            return false;
        });
        $('#AttachmentInfoEditForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#AttachmentInfoEditForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#AttachmentInfoEditForm').submit();
                    }, 1000);

                }
                return false;
            }
        });



        $('#AttachmentInfoEditForm').submit(function () {
            var id = $('#id').val();
            var action = config.upload_url + '/' + attachment_selected_id;
            var formData = new FormData($(this)[0]);
            formData.append('_method', 'PATCH');
            $.ajax({
                url: action,
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    My.unblockUI();
                    My.toast(data.message);
                    $('#AttachmentInfoEdit').modal('hide');

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
    var handleDeleteUploadPic = function () {
        $(document).off('click', '.deleteClassifiedUploadedPic');
        $(document).on('click', '.deleteClassifiedUploadedPic', function () {
            var $this = $(this);
            $(this).parent().parent().remove();
            if ($('.classifiedUploadedPicContainer').length == 0) {
                $('.uploadedPics').html('<p class="text-center  empty-message">' + lang.no_images + '</p>')
            }

        });
    }
    var handleChangeArrowLeftAndRight = function () {

        $(document).off('click', '.moveClassifiedUploadedPicRight');
        $(document).on('click', '.moveClassifiedUploadedPicRight', function () {
            var thisPic = $(this).parent().parent();
            var toReplace = thisPic.prev('.classifiedUploadedPicContainer');
            if (toReplace.length > 0) {
                toReplace.insertAfter(thisPic);
            }
        });


        $(document).off('click', '.moveClassifiedUploadedPicLeft');
        $(document).on('click', '.moveClassifiedUploadedPicLeft', function () {
            var thisPic = $(this).parent().parent();
            var toReplace = thisPic.next('.classifiedUploadedPicContainer');
            if (toReplace.length > 0) {
                toReplace.insertBefore(thisPic);
            }
        });
    }

    var handleUpload = function () {
        $(document).on('click', '.upload-image', function () {
            $(this).closest('.form-group').find('input[type="file"]').trigger('click');
        });

        //$(document).off('click', '.submit-form');
        $(document).on('change', '.upload', function () {
            var ele = $(this);
            var name = ele.attr('name');
            var progress_div = ele.closest('.form-group').find('.progress');
            setTimeout(function () {
                uploadFile(ele, function (response) {
                    console.log(response);

                    if (response.type === 'error') {
                        progress_div.hide();


                    } else if (response.type === 'success') {

                        Attachment.empty();
                        if (typeof response.data.uploaded !== "undefined")
                        {

                            progress_div.hide();
                            var result = response.data.uploaded;
                            var attr = ele.attr('multiple');

                            if (typeof attr !== typeof undefined && attr !== false) {
                                var items = [];
                                if (result.length > 0) {
                                    for (var x = 0; x < result.length; x++) {
                                        var one = result[x];
                                        new_attachment.push(one.id);

                                        items.push(My.uploaded_content({
                                            multiple: true,
                                            edit_btn: false,
                                            url: one.url,
                                            background: one.background,
                                            id: one.id,
                                        }));
                                    }
                                }
                                ele.closest('.form-group').find(".uploaded-images").append(items.join(' '));
                            } else {
                                var one = result[0];
                                new_attachment.push(one.id);
                                ele.closest('.form-group').find(".image_box").html(My.uploaded_content(
                                        {
                                            multiple: false,
                                            edit_btn: false,
                                            url: one.url,
                                            background: one.background,
                                            id: one.id,
                                        }));
                            }

                        }





                    }


                }, function ()
                {
                    var xhr = new window.XMLHttpRequest();
                    currentUploadProgress = 0;
                    var inputFile = ele;
                    var fileToUpload = inputFile[0].files;
                    if (fileToUpload.length > 0) {
                        xhr.upload.addEventListener("progress", function (evt) {

                            progress_div.show();
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                console.log(percentComplete);

                                var i = Math.round(percentComplete * 100);
                                var i2 = Math.round(percentComplete * 100);
                                if (i > currentUploadProgress) {
                                    currentUploadProgress = i;
                                    progress_div.find('.progress-bar').css({'width': i + '%'});
                                    progress_div.find('#percent').html(i + '%');
                                }
                            }
                        }, false);
                    }





                    return xhr;
                });
            }, 1000);




        });



    }
    var uploadFile = function (element, callback, xhrFunction, additionalItems) {
        var formData = new FormData();
        var inputFile = element;
        var nameFile = element.attr('name');
        var fileToUpload = inputFile[0].files;
        formData.append('name', nameFile);
        console.log(inputFile[0].files);
        for (var x = 0; x < fileToUpload.length; x++) {
            formData.append('attachment[]', fileToUpload[x]);
        }
        if (additionalItems && Object.keys(additionalItems).length > 0) {
            $.each(additionalItems, function (k, v) {
                formData.append(k, v);
            });

        }
        formData.append('attachment_id', config.attachment_id);


        uploadXhr = $.ajax({
            type: "POST",
            dataType: "json",
            url: config.upload_url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            xhr: xhrFunction

        }).done(function (data) {
            callback(data);

        }).fail(function (xhr) {
            $('.submit-form').prop('disabled', false);
            $('.submit-form').html(lang.save);
            console.log(xhr);
            My.ajax_error_message(xhr);

        });



    }


    return {
        init: function () {
            init();
        },
        delete: function (t) {
            var id = $(t).data('id');
            var multiple = $(t).data('multiple');
            My.deleteForm({
                element: t,
                url: config.ajax_url + '/upload/' + id,
                data: {_method: 'DELETE'},
                success: function (data)
                {
                    var index = new_attachment.indexOf(id);
                    if (new_attachment > -1) {
                        new_attachment.splice(index, 1);
                    }
                    if (multiple) {
                        $(t).closest('.image_box').remove();
                    } else {
                        $(t).closest('.image_box').html('<img src="' + config.url + '/no-image.jpg" class="upload-image" width="100%" height="100%" />')
                    }
                }
            });

            return false;
        },
        edit: function (t) {
            attachment_selected_id = $(t).data("id");
            My.editForm({
                url: config.upload_url + '/' + attachment_selected_id + '/edit',
                success: function (data)
                {
                    console.log(data);
                    $('#AttachmentInfoEdit').modal('show');
                    $('#AttachmentInfoEdit input[name="title"]').val(data.title);
                    $('#AttachmentInfoEdit input[name="url"]').val(data.url);

                }
            });
            return false;
        },
        empty: function () {
            attachment_selected_id = 0;

        }
    };

}();
jQuery(document).ready(function () {
    Attachment.init();
});

