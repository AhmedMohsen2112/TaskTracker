var Users_grid;
var selected_id = 0;
var Users = function () {
    var init = function () {
        handleRecords();
        handleSubmit();


    };

    var handleRecords = function () {

        Users_grid = $('.dataTable').dataTable({
            lengthChange: false,
            "serverSide": true,
//            stateSave: true,
            "ajax": {
                "url": config.admin_url + "/users/data",
                "type": "GET",
            },
            "columns": [
//                    {"data": "user_input", orderable: false, "class": "text-center"},
                {"data": "username", 'name': 'users.username'},
                {"data": "phone", 'name': 'users.phone'},
                {"data": "email", 'name': 'users.email'},
                {"data": null, orderable: false, searchable: false, render: function (data, type, row) {
                        var $back = '';
                        var $message = '';
                        var $class = '';
                        if (row.active == 1) {
                            $message = lang.active;
                            $class = 'label-success';
                        } else {
                            $message = lang.not_active;
                            $class = 'label-danger';
                        }
                        $back += '<span class="label label-sm ' + $class + '">' + $message + '</span>';
                        return $back;
                    }
                },
                {"data": "created_at", 'name': 'users.created_at', searchable: false},

                {"data": null, orderable: false, searchable: false, render: function (data, type, row) {
                        var $back = '';
                        $back += '<a href="" data-id="' + row.id + '" onclick="Users.edit(this);return false;" class="btn btn-default btn-xs" style="margin:2px;">' + lang.edit + ' </a>';
                        $back += '<a href="" data-id="' + row.id + '" onclick="Users.delete(this);return false;" class="btn btn-danger btn-xs" style="margin:2px;">' + lang.delete + ' </a>';
                        return $back;
                    }
                },
            ],
            "order": [
                [4, "desc"]
            ],
            "oLanguage": {"sUrl": config.url + '/datatable-lang-' + config.lang_code + '.json'}

        });
    }
    var handleSubmit = function () {

        $('#addEditUsersForm').validate({
            rules: {
                name: {
                    required: true
                },
                username: {
                    required: true
                },
                group: {
                    required: true
                },
                phone: {
                    required: true
                },
                email: {
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
        $('#addEditUsersForm .submit-form').click(function () {
            if ($('#addEditUsersForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#addEditUsersForm').submit();
                }, 1000);

            }
            return false;
        });
        $('#addEditUsersForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#addEditUsersForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#addEditUsersForm').submit();
                    }, 1000);
                }
                return false;
            }
        });



        $('#addEditUsersForm').submit(function () {
            var formData = new FormData($(this)[0]);
            var action = config.admin_url + '/users';
            if (selected_id != 0) {
                formData.append('_method', 'PATCH');
                formData.append('id', selected_id);
                action = config.admin_url + '/users/' + selected_id;
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
                    Users_grid.api().ajax.reload();
                    if (selected_id == 0) {
                        Users.empty();
                    }
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
        },
        edit: function (t) {
            selected_id = $(t).data("id");
            My.editForm({
                url: config.admin_url + '/users/' + selected_id + '/edit',
                success: function (data)
                {
                    for (i in data)
                    {
                        if (i == 'password') {
                            continue;
                        } else if (i == 'group_id') {
                            $('#group').val(data[i]);
                        } else if (i == 'hotel_assigned') {
                            $('input[name="hotel"]').select2('data', data[i]);
                        } else {
                            $('#' + i).val(data[i]);
                        }


                    }

                }
            });
            return false;
        },
        delete: function (t) {
            var id = $(t).data("id");
            My.deleteForm({
                element: t,
                url: config.admin_url + '/users/' + id,
                data: {_method: 'DELETE'},
                success: function (data)
                {
                    My.toast(data.message);
                    Users.empty();
                    Users_grid.api().ajax.reload();
                }
            });
            return false;
        },
        add: function () {
            Users.empty();
            My.setModalTitle('#addEditUsers', lang.add_admin);
            $('#addEditUsers').modal('show');
        },
        empty: function () {
            $('#active,#branch,#group').find('option').eq(0).prop('selected', true);
            selected_id = 0;
            My.emptyForm();
        },
    };
}();
$(document).ready(function () {
    Users.init();
});