
var all_noti_count = 0;
var Main = function () {


    var init = function () {

        if (typeof config.ajax_message != 'undefined' && config.ajax_message != '') {
            My.toast({message: config.ajax_message, type: "success"});
        }

        all_noti_count = $('.header-noti').data('all-noti-count');
        handlePusher();
        handleGetNotificationOnScroll();


    }
    var handleGetNotificationOnScroll = function () {


        $('.noti-scroller').on('scroll', function () {
//            console.log('here');
            var container_height = $(this).innerHeight();//146
            var container_scroll_height = $(this)[0].scrollHeight; //256
            var container_scroll_top = $(this).scrollTop(); //58
            if (Math.ceil(container_scroll_top) == container_scroll_height - container_height) {
                var noti_length = $('.noti-scroller').find('li.header-noti-li').length;
                if (all_noti_count != noti_length) {
                    var action = config.ajax_url + '/notifications';
                    $.ajax({
                        url: action,
                        data: {offset: noti_length},
                        async: false,
                        success: function (data) {
//                            console.log(data);
                            var noti = data;
                            var html = '';
                            for (var x = 0; x < noti.length; x++) {
                                var obj = noti[x];
                                html += notiHtml(obj);
                            }
                            $('.noti-scroller').append(html);
                            noti_length = $('.noti-scroller').find('li.header-noti-li').length;
//                            console.log(noti_length);
                        },
                        error: function (xhr, textStatus, errorThrown) {
                        },
                        dataType: "JSON",
                        type: "GET"
                    });
                }

            }
        });
    }
    var notiHtml = function (obj) {
        var html = ' <li class="header-noti-li ' + (obj.read_status == 0 ? 'un-read-noti' : '') + '">' +
                '<a href="' + config.admin_url + '/notifications/' + obj.noti_object_id + '" class="noti-li"><p><i class="far fa-bell"></i>' + obj.message + '</p></a>' +
                ' <p>' + obj.created_at + '</p>' +
                '</li>';
        return html;
    }
    var handlePusher = function () {
        Pusher.logToConsole = true;
        var pusher_app_key = config.pusher_app_key;
        var pusher_cluster = config.pusher_cluster;
        var pusher_encrypted = config.pusher_encrypted;
        var user_id = config.user_id;
        var pusher = new Pusher(pusher_app_key, {
            cluster: 'eu',
//      forceTLS: true
            encrypted: pusher_encrypted
        });
        var notification = pusher.subscribe('notification');

        notification.bind('new_notification_' + user_id, function (data) {
            console.log(data);

            if (user_id == data.notifier_id) {
                var unread_noti_count = parseInt($('.noti-count:eq(0)').html());
                unread_noti_count += 1;
                all_noti_count += 1;
                $('.noti-count').html(unread_noti_count);
                My.pushNotiSound();
                My.toast(data.message, function () {
                    window.location.href = config.customer_url + '/notifications/' + data.noti_object_id;
                });
                $('.noti-scroller').prepend(notiHtml(data));
//                $.notify("asdf", {
//                    title: data.data.title,
//                    body: data.data.body,
//                    //icon: config.public_path + '/v2/images/akar-logo.png',
//                }).click(function () {
//                    window.location.href = data.url;
//                });


            }
        });

        pusher.connection.bind('connected', function () {
//            socketId = pusher.connection.socket_id;
//            console.log(socketId);
        });
    }
    var handlePusherNotification = function () {
        Pusher.logToConsole = true;
        var pusher_app_key = config.pusher_app_key;
        var pusher_cluster = config.pusher_cluster;
        //console.log(pusher_app_key);
        //console.log(pusher_cluster);
        var pusher_encrypted = config.pusher_encrypted;
        var user_id = config.user_id;
        var pusher = new Pusher(pusher_app_key, {
            cluster: 'eu',
//      forceTLS: true
            encrypted: pusher_encrypted
        });

//        var report = pusher.subscribe('report');
        var noti = pusher.subscribe('new_noti_' + user_id);
        //console.log(noti);

        noti.bind('App\\Events\\NotiEvent', function (data) {
            console.log(data);

            if (user_id == data.data.notifier_id) {
                var unread_noti_count = parseInt($('.noti-count:eq(0)').html());
                unread_noti_count += 1;
                all_noti_count += 1;
                $('.noti-count').html(unread_noti_count);
                My.pushNotiSound();
                My.toast(data.data.body, function () {
                    window.location.href = config.customer_url + '/notifications/' + data.data.noti_object_id;
                });
                $('.noti-scroller').prepend(notiHtml(data.data));
//                $.notify("asdf", {
//                    title: data.data.title,
//                    body: data.data.body,
//                    //icon: config.public_path + '/v2/images/akar-logo.png',
//                }).click(function () {
//                    window.location.href = data.url;
//                });


            }

        });

        pusher.connection.bind('connected', function () {
            //socketId = pusher.connection.socket_id;
            //console.log(socketId);
        });
    }








    return {
        init: function () {
            init();
        },
        handleDestinationSearchSubmit: function (form) {

            $(form).validate({
                rules: {
                    destination: {
                        required: true
                    },
                    check_in: {
                        required: true
                    },
                    check_out: {
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



            $(form + ' .submit-form').click(function () {
                if ($(form).validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $(form).submit();
                    }, 1000);

                }
                return false;
            });
            $(form + ' input').keypress(function (e) {
                if (e.which == 13) {
                    if ($(form).validate().form()) {
                        My.blockUI();
                        setTimeout(function () {
                            $(form).submit();
                        }, 1000);

                    }
                    return false;
                }
            });



            $(form).submit(function () {
                var action = config.site_url + '/search';
                var formData = new FormData($(this)[0]);
                var destination = $('input[name="destination"]').select2('data');
//                console.log(destination);
                formData.append('dest_id', destination.id);
                formData.append('dest_type', destination.dest_type);
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
                        window.location.href = data.url;
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





        },
        handleDestinationsSearch: function (params) {
            var data = typeof params.data !== 'undefined' ? params.data : {};
            var multiple = typeof params.multiple !== 'undefined' ? params.multiple : false;
            function movieFormatResult(item) {
                return '<span style="font-weight:bold;">' + item.title + '</span><br>' + ' ' + item.location_path;
            }

            function movieFormatSelection(item) {
                return item.title + ' ' + item.location_path;
            }
            $(params.ele).select2({
                placeholder: lang.search,
                minimumInputLength: 1,
                multiple: multiple,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: config.ajax_url + '/search-destinations',
                    dataType: 'json',
                    data: function (term, page) {
                        return $.extend(data, {q: term});

                    },

                    results: function (data, page) { // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to alter remote JSON data
                        console.log(data);
                        return {
                            results: data,
//                        more: (page * 10) < data.total
                        };
                    }
                },
                formatResult: movieFormatResult, // omitted for brevity, see the source of this page
                formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
                dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
                escapeMarkup: function (m) {
                    return m;
                } // we do not want to escape markup since we are displaying html in results
            });

        },

    }

}();

jQuery(document).ready(function (e) {
    Main.init();

});


