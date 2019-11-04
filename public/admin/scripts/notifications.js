var Notifications_grid;
var selected_id = 0;
var Notifications = function () {
    var init = function () {
        handleRecords();
        handleNotificationClick();
    };


    var handleNotificationClick = function () {
        $(document).on('click', '.dataTable tr', function () {
            $('.dataTable tr').removeClass('selected');
            var tableData = Notifications_grid.api().row(this).data();
            if (typeof tableData != 'undefined') {
                My.blockUI();
                window.location.href = config.admin_url + '/notifications/' + tableData.noti_object_id;
            }


        });
    }

    var handleRecords = function () {

        Notifications_grid = $('.dataTable').dataTable({
            lengthChange: false,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": config.admin_url + "/notifications/data",
                "type": "GET",
            },
            "columns": [
                {"data": "message", orderable: false, searchable: false, render: function (data, type, row) {
                        return (row.message.length > 60) ? row.message.slice(0, 59) + ' ...' : row.message;
                    }
                },
                {"data": null, name: "created_at", orderable: false, searchable: false, render: function (data, type, row) {
                        return row.time;
                    }
                },
            ],
            "order": [
                [1, "desc"]
            ],
            createdRow: function (row, data, index) {
                var rowClassName = '';
                if (data.read_status == "0") {
                    rowClassName = 'table-unread-noti';
                }
                $(row).addClass(rowClassName);
            },
            "oLanguage": {"sUrl": config.url + '/datatable-lang-' + config.lang_code + '.json'}

        });
    }




    return{
        init: function () {
            init();
        },

    };
}();
$(document).ready(function () {
    Notifications.init();
});