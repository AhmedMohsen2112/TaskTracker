var board_selected_id = 0;
var list_selected_id = 0;
var issue_selected_id = 0;
var Boards = function () {
    var init = function () {
        $.extend(config, new_config);
        handleBoardsSubmit();
        handleListsSubmit();
        handleShowListForm();
        handleShowIssueForm();
        handleAddIssuesFormSubmit();
        handleEditIssuesFormSubmit();
        My.init_datepicker('#editIssuesForm input[name="due_date"]');
        Main.handleUsersSearch({ele: '#AssignmentForm input[name="user"]', multiple: true});
        handleIssuesUpload();
        handleCommentsSubmit();
        handleDragAndDropIssues();
        handleAssignmentSubmit();

    };
    var handleDragAndDropIssues = function (Obj) {
        $('[id^="list-"]').sortable(
                {
                    connectWith: ".list-items",
                    stop: function (e, ui) {
                        var list_id = $(ui.item).closest(".list-items").data("id");
                        var id = $(ui.item).data("id");
                        var index = $(ui.item).closest(".list-items").find('[id^="issue"]').index($(ui.item)) + 1;
                        console.log('index : ' + index);
                        $.ajax({
                            url: config.admin_url + '/board-list-issues/sorting?issue=' + id + '&index='
                                    + index + '&list=' + list_id,
                            dataType: "json",
                            type: "GET",
                            async: false,
                            success: function (response) {
                            }
                        });
                    },
                    receive: function (e, ui) {
                        var list_id = $(ui.item).closest(".list-items").data("id");
                        var id = $(ui.item).data("id");
                        var index = $(ui.item).closest(".list-items").find('[id^="issue"]').index($(ui.item)) + 1;
                        $.ajax({
                            url: config.admin_url + '/board-list-issues/sorting?issue=' + id + '&index='
                                    + index + '&list=' + list_id,
                            type: "GET",
                            dataType: "json",
                            async: false,
                            success: function (response) {
                            }
                        });
                    }

                }).disableSelection();
    }
    var handleRecentActivityListHtml = function (Obj) {
        var html = '<div class="todo-tasklist-item todo-tasklist-item-border-green">' +
                '<div class="todo-tasklist-item-title">' + Obj.username + '</div>' +
                '<div class="todo-tasklist-item-text">' + Obj.comment + '</div>' +
                '<div class="todo-tasklist-controls pull-left">' +
                '<span class="todo-tasklist-date"><i class="fa fa-calendar"></i>' + Obj.created_at + ' </span>' +
                '</div>' +
                '</div>';
        return html;
    }
    var handleCommentsSubmit = function () {
        $('#CommentForm').validate({
            rules: {
                comment: {
                    required: true
                }
            },
            messages: lang.messages,
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

        $('#CommentForm .submit-form').click(function () {
            if ($('#CommentForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#CommentForm').submit();
                }, 1000);

            }
            return false;
        });
        $('#CommentForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#CommentForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#CommentForm').submit();
                    }, 1000);

                }
                return false;
            }
        });



        $('#CommentForm').submit(function () {
            var action = config.admin_url + '/board-list-issues/comment';
            var formData = new FormData($(this)[0]);
            formData.append('issue', issue_selected_id);

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
                    handleRecentActivityListHtml(data.comment);
                    $('.recent-activity').prepend(handleRecentActivityListHtml(data.comment));
                },
                error: function (xhr, textStatus, errorThrown) {
                    My.ajax_error_message(xhr, $(this));

                },
                dataType: "json",
                type: "POST"
            });

            return false;

        })
    }
    var handleIssuesUpload = function () {

        $(document).on('change', '.upload', function () {
            var ele = $(this);
            My.uploadFile(ele, {attachment_id: issue_selected_id});
        });



    }
    var handleShowListForm = function () {
        $('.add-list-btn').click(function () {
            $('#addEditBoardListsForm').show();
            $(this).hide();
        });

        $('#addEditBoardListsForm .close-btn').click(function () {
            $('#addEditBoardListsForm').hide();
            $('.add-list-btn').show();
        });
    }
    var handleShowIssueForm = function () {
        $(document).on('click', '.add-card-btn', function () {
            $('.addIssuesForm').hide();
            $(this).closest('.list').find('.addIssuesForm').show();
            $('.add-card-btn').show();
            $(this).hide();
        });

        $(document).on('click', '.addIssuesForm .close-btn', function () {
            $('.addIssuesForm').hide();
            $(this).closest('.list').find('.add-card-btn').show();
        });
    }
    var validate_issues_form = function (frm) {
        frm.validate({
            rules: {
                title: {
                    required: true
                },
                description: {
                    required: true
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
    }

    var handleAddIssuesFormSubmit = function () {



        $(document).on('click','.addIssuesForm .submit-form',function () {
            var frm = $(this).closest('.addIssuesForm');
            validate_issues_form(frm);
            if (frm.validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    frm.submit();
                }, 1000);

            }
            return false;
        });
        
        $(document).on('submit','.addIssuesForm',function () {
            var action = config.admin_url + '/board-list-issues';
            var formData = new FormData($(this)[0]);
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
                    var html = '<li id="issue' + data.issue.id + '" data-id="' + data.issue.id + '" onclick="Boards.edit_issue(this);return false;">';
                    html += '<h5>' + data.issue.title + '</h5>';
                    html += '<p>' + data.issue.description + '</p>';
                    html += ' </li>';
                    if (issue_selected_id == 0) {
                        if ($('#list-' + data.issue.list_id + ' li').length > 0) {
                            var last_one = $('#list-' + data.issue.list_id).find('li:last');
                            $(html).insertAfter(last_one);
                        } else {
                            $('#list-' + data.issue.list_id).prepend(html);
                        }
                    } else {
//                        alert('here');
                        $('#issue' + data.issue.id).replaceWith(html);
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


    var handleEditIssuesFormSubmit = function () {

        $('#editIssuesForm').validate({
            rules: {
                title: {
                    required: true
                },
                description: {
                    required: true
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

        $('#editIssuesForm .submit-form').click(function () {
            if ($('#editIssuesForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#editIssuesForm').submit();
                }, 1000);

            }
            return false;
        });
        $('#editIssuesForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#editIssuesForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#editIssuesForm').submit();
                    }, 1000);

                }
                return false;
            }
        });



        $('#editIssuesForm').submit(function () {
            var formData = new FormData($(this)[0]);
            formData.append('_method', 'PATCH');
            var action = config.admin_url + '/board-list-issues/' + issue_selected_id;
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
                    var html = '<li id="issue' + data.issue.id + '" data-id="' + data.issue.id + '" onclick="Boards.edit_issue(this);return false;">';
                    html += '<h5>' + data.issue.title + '</h5>';
                    html += '<p>' + data.issue.description + '</p>';
                    html += ' </li>';
                    $('#issue' + data.issue.id).replaceWith(html);

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
    var handleAssignmentSubmit = function () {


        $('#AssignmentForm .submit-form').click(function () {
            if ($('#AssignmentForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#AssignmentForm').submit();
                }, 1000);

            }
            return false;
        });




        $('#AssignmentForm').submit(function () {
            var formData = new FormData($(this)[0]);
            var action = config.admin_url + '/board-list-issues/assign';
            formData.append('issue', issue_selected_id);
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
    var handleListsSubmit = function () {

        $('#addEditBoardListsForm').validate({
            rules: {
                title: {
                    required: true
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

        $('#addEditBoardListsForm .submit-form').click(function () {
            if ($('#addEditBoardListsForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#addEditBoardListsForm').submit();
                }, 1000);

            }
            return false;
        });
        $('#addEditBoardListsForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#addEditBoardListsForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#addEditBoardListsForm').submit();
                    }, 1000);

                }
                return false;
            }
        });



        $('#addEditBoardListsForm').submit(function () {

            var action = config.admin_url + '/board-lists';
            var formData = new FormData($(this)[0]);
            if (list_selected_id != 0) {
                formData.append('_method', 'PATCH');
                action = config.admin_url + '/board-lists/' + list_selected_id;
            }
            formData.append('board', config.id);
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
                    var html = '<div class="list">';
                    html += '<h3 class="list-title">' + data.list.title + '</h3>';
                    html += ' <ul id="list-' + data.list.id + '" data-id="' + data.list.id + '" class="list-items" >' +
                            '<form role="form"  class="addIssuesForm"  enctype="multipart/form-data" style="display: none;">' +
                            '<input type="hidden" name="list" value="' + data.list.id + '">' +
                            '<div class="form-body">' +
                            '<div class="form-group">' +
                            '<input type="text" class="form-control"  name="title">' +
                            '<span class="help-block"></span>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<textarea rows="4" class="form-control"  name="description"></textarea>' +
                            '<span class="help-block"></span>' +
                            '</div>' +
                            '<p>' +
                            '<a class="btn purple submit-form">' + lang.save + '</a>' +
                            '<a class="btn dark close-btn" href="javascript:;">' + lang.close + '</a>' +
                            '</p>' +
                            '</div>' +
                            '</form>' +
                            '</ul>';
                    html += '<button class="add-card-btn btn"><i class="fa fa-plus"></i>' + lang.add_a_card + '</button>';
                    html += ' </div>';
                    $(html).insertBefore('#addEditBoardListsForm');

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
    var handleBoardsSubmit = function () {

        $('#addEditBoardsForm').validate({
            rules: {
                title: {
                    required: true
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

        $('#addEditBoards .submit-form').click(function () {
            if ($('#addEditBoardsForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#addEditBoardsForm').submit();
                }, 1000);

            }
            return false;
        });
        $('#addEditBoardsForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#addEditBoardsForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#addEditBoardsForm').submit();
                    }, 1000);

                }
                return false;
            }
        });



        $('#addEditBoardsForm').submit(function () {

            var action = config.admin_url + '/boards';
            var formData = new FormData($(this)[0]);
            if (board_selected_id != 0) {
                formData.append('_method', 'PATCH');
                action = config.admin_url + '/boards/' + board_selected_id;
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
                    var html = ' <li class="list-group-item board-item" id="board' + data.board.id + '">';
                    html += data.board.title;
                    html += '<a class="btn btn-xs btn-primary pull-right" data-id="' + data.board.id + '" onclick="Boards.edit(this);return false;">' + lang.edit + '</a>';
                    html += '<a class="btn btn-xs btn-warning pull-right" href="' + config.admin_url + '/boards/' + data.board.id + '">' + lang.view + '</a>';
                    html += '<a class="btn btn-xs btn-danger pull-right" data-id="' + data.board.id + '" onclick="Boards.delete(this);return false;">' + lang.delete + '</a>';
                    html += '</li>';
                    if (board_selected_id == 0) {
                        if ($('.board-item').length == 0) {
                            $('#boards-content').html(html);
                        } else {
                            $('#boards-content').prepend(html);
                        }

                    } else {
                        $('#board' + data.board.id).replaceWith(html);
                    }
                    $('#addEditBoards').modal('hide');

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
            var id = $(t).data("id");
            My.setModalTitle('#addEditBoards', lang.edit);
            //            $('.dataTable tr').removeClass('selected');
//            $(t).closest('tr').addClass('selected');
            My.editForm({
                url: config.admin_url + '/boards/' + id + '/edit',
                success: function (data)
                {
                    Boards.empty();
                    board_selected_id = id;
                    for (i in data)
                    {
                        $('#addEditBoards [name="' + i + '"]').val(data[i]);
                    }
                    $('#addEditBoards').modal('show');
                }
            });
            return false;
        },
        edit_issue: function (t) {
            var id = $(t).data("id");

            //            $('.dataTable tr').removeClass('selected');
//            $(t).closest('tr').addClass('selected');
            My.editForm({
                url: config.admin_url + '/board-list-issues/' + id + '/edit',
                success: function (data)
                {
                    Boards.empty_issue_form();
                    issue_selected_id = id;
                    for (i in data)
                    {
                        if (i == "attachment_list") {
                            My.push_attachment(data.attachment_list, {
                                multiple: true,
                                edit_btn: false
                            });
                        } else if (i == "assigned_list") {
                            $('#AssignmentForm input[name="user"]').select2("data", data.assigned_list);
                        } else if (i == "comments_list") {
                            var html = '';
                            $.each(data.comments_list, function (index, Obj) {
                                html += handleRecentActivityListHtml(Obj);

                            });
                            $('.recent-activity').html(html);
                        } else {
                            $('#EditIssues [name="' + i + '"]').val(data[i]);
                        }

                    }
                    My.setModalTitle('#EditIssues', data['title']);
                    $('#EditIssues').modal('show');
                }
            });
            return false;
        },
        delete: function (t) {
            var id = $(t).data("id");
            My.deleteForm({
                element: t,
                url: config.admin_url + '/boards/' + id,
                data: {_method: 'DELETE'},
                success: function (data)
                {
                    My.toast(data.message);
                    Boards.empty();
                    $(t).closest('.board-item').remove();
                }
            });
            return false;
        },
        add_board: function () {
            Boards.empty();
            My.setModalTitle('#addEditBoards', lang.add);
            $('#addEditBoards').modal('show');
        },
        add_issue: function () {
            Boards.empty();
            My.setModalTitle('#addEditIssues', lang.add);
            $('#addEditIssues').modal('show');
        },
        empty: function () {
            board_selected_id = 0;
            My.emptyForm();
        },
        empty_issue_form: function () {
            issue_selected_id = 0;
            $('#AssignmentForm input[name="user"]').select2("val", null);
            My.emptyForm('#IssuesBasicInfoForm');
        },
    };
}();
$(document).ready(function () {
    Boards.init();
});