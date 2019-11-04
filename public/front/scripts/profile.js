var BookingRequestsGrid;
var Profile = function () {

    var init = function () {
        $.extend(config, new_config);
        if (config.page == 'profile_account_settings') {
            handleEditAccount();
        }
        if (config.page == "profile_booking_requests_index") {
            My.handleDateRange('#filter-form input[name="from"]', '#filter-form input[name="to"]');
            handleBookingRequestsRecords();
            handleFilter();
        }

    }
    var handleFilter = function () {
        $('#filter-form .btn-filter').on('click', function () {
            handleBookingRequestsRecordsReport();
            return false;
        })
    }
    var handleBookingRequestsRecordsReport = function () {
        if (typeof BookingRequestsGrid !== 'undefined') {
            var filter = $("#filter-form").serializeArray();
            var params = {created_by: config.user_id};
            $.each(filter, function (index, field) {
                var name = field.name;
                var value = field.value;
                if (value) {
                    params[name] = value;
                }
            });
            BookingRequestsGrid.api().ajax.url(config.customer_url + "/booking-requests/data?" + $.param(params)).load();
        }

    }
    var handleBookingRequestsRecords = function () {

        BookingRequestsGrid = $('.dataTable')
                .on('preDraw.dt', function () {
                    My.blockUI({
                        target: $('.table-responsive'),
                        //boxed: true
                    });
                })
                .on('draw.dt', function () {
                    My.unblockUI('.table-responsive');
                })
                .dataTable({
                    lengthChange: false,
                    "serverSide": true,
                    "ajax": {
                        "url": config.customer_url + "/booking-requests/data?created_by=" + config.user_id,
                        "type": "GET",
                    },
                    "columns": [

                        {"data": "code", name: "booking.code"},
                        {"data": null, name: "hotel_trans.title", render: function (data, type, row) {
                                var $back = '';
                                $back += row.hotel_title;
                                $back += '<br>';
                                $back += row.hotel_location_path;
                                return $back;
                            }
                        },
                        {"data": null, orderable: false, searchable: false, render: function (data, type, row) {
                                var $back = row.check_in + ' - ' + row.check_out;
                                return $back;
                            }
                        },
                        {"data": "total_amount", orderable: false, searchable: false},
                        {"data": null, orderable: false, searchable: false, render: function (data, type, row) {
                                var $back = '<span class="label label-info label-sm">' + row.status_text + '</span>';
                                return $back;
                            }
                        },

                        {"data": "created_at", searchable: false},
                        {"data": null, orderable: false, searchable: false, render: function (data, type, row) {
                                var $back = '';
                                $back += '<a href="' + config.customer_url + '/booking-requests/' + row.id + '" class="btn btn-primary btn-xs">' + lang.view + ' </a>';
                                return $back;
                            }
                        },
                    ],
                    "order": [
                        [5, "desc"]
                    ],

                    "oLanguage": {"sUrl": config.base_url + '/datatable-lang-' + config.lang_code + '.json'}

                });
    }
    var handleEditAccount = function () {
        $("#edit-form").validate({
            rules: {
                name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                mobile: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                confirm_password: {
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
        $('#edit-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#edit-form').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#edit-form').submit();
                    }, 500);

                }
                return false;
            }
        });
        $('#edit-form .submit-form').click(function () {
            //alert('33333');
            if ($('#edit-form').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#edit-form').submit();
                }, 500);
            }
            return false;
        });
        $('#edit-form').submit(function () {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: config.customer_url + "/user/edit",
                type: 'POST',
                dataType: 'JSON',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data)
                {
                    console.log(data);
                    My.unblockUI();
                    window.location.href = config.site_url;


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
    Profile.init();
});


