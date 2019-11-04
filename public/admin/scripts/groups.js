var Groups_grid;
var selected_id = 0;
var Groups = function () {
    var init = function () {
        handleRecords();
        handleSubmit();
        handleCheckAll();

    };
    var handleCheckAll = function () {
        $("#check-all").on('change', function () {
            $('.check-one').not(this).prop('checked', this.checked);
        });
    }

    var handleRecords = function () {

        Groups_grid = $('.dataTable').dataTable({
            lengthChange: false,
            "serverSide": true,
            "ajax": {
                "url": config.admin_url + "/groups/data",
                "type": "GET",
            },
            "columns": [
//                    {"data": "user_input", orderable: false, "class": "text-center"},
                {"data": "name", name: "groups.name"},
                {"data": "created_by", name: "users.username"},
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
                {"data": null, orderable: false, searchable: false, render: function (data, type, row) {
                        var $back = '';
                        if (Main.check_access('groups', 'add_edit')) {
                            $back += '<a href="" data-id="' + row.id + '" onclick="Groups.edit(this);return false;" class="btn btn-default btn-xs" style="margin:2px;">' + lang.edit + ' </a>';

                        }
                        if (Main.check_access('groups', 'delete')) {

                            $back += '<a href="" data-id="' + row.id + '" onclick="Groups.delete(this);return false;" class="btn btn-danger btn-xs" style="margin:2px;">' + lang.delete + ' </a>';
                        }
                        return $back;
                    }
                },
            ],
            "order": [
                [0, "desc"]
            ],
            "oLanguage": {"sUrl": config.url + '/datatable-lang-' + config.lang_code + '.json'}

        });
    }
    var handleSubmit = function () {
        if ($('#addEditGroupsForm').length > 0) {
            $('#addEditGroupsForm').validate({
                rules: {
                    name: {
                        required: true

                    },
                    active: {
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
            $('#addEditGroupsForm .submit-form').click(function () {
                if ($('#addEditGroupsForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#addEditGroupsForm').submit();
                    }, 1000);

                }
                return false;
            });
            $('#addEditGroupsForm input').keypress(function (e) {
                if (e.which == 13) {
                    if ($('#addEditGroupsForm').validate().form()) {
                        My.blockUI();
                        setTimeout(function () {
                            $('#addEditGroupsForm').submit();
                        }, 1000);

                    }
                    return false;
                }
            });



            $('#addEditGroupsForm').submit(function () {
                var action = config.admin_url + '/groups';
                var formData = new FormData($(this)[0]);
                if (selected_id != 0) {
                    formData.append('id', selected_id);
                    formData.append('_method', 'PATCH');
                    action = config.admin_url + '/groups/' + selected_id;
                }

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
                        Groups_grid.api().ajax.reload();

                        if (selected_id == 0) {
                            Groups.empty();
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
    }



    return{
        init: function () {
            init();
        },
        edit: function (t) {
            var id = $(t).data("id");
            My.editForm({
                url: config.admin_url + '/groups/' + id + '/edit',
                success: function (data)
                {
                    Groups.empty();
                    selected_id = id;
                    for (i in data)
                    {
                        if (i == 'permissions') {
                            var permissions = data[i];
                            for (var x = 0; x < permissions.length; x++)
                            {
                                var permission = permissions[x];
//                                console.log(permission);
                                $('#' + permission).prop("checked", true).trigger("change");

                            }
                        } else {
                            $('[name="' + i + '"]').val(data[i]);
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
                url: config.admin_url + '/groups/' + id,
                data: {_method: 'DELETE'},
                success: function (data)
                {
                    My.toast(data.message);
                    Groups.empty();
                    Groups_grid.api().ajax.reload();
                }
            });
            return false;
        },
        add: function () {
            Groups.empty();
            My.setModalTitle('#addEditGroups', lang.add_group);
            $('#addEditGroups').modal('show');
        },
        empty: function () {
            selected_id = 0;
            $('#active').find('option').eq(0).prop('selected', true);
            My.emptyForm();
        },
    };
}();
$(document).ready(function () {
    Groups.init();
});