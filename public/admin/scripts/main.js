
var all_noti_count = 0;
var Main = function () {


    var init = function () {
        handleChangeLang();
//        handlePusherNotification();
//        handlePusher();
        handleOneSignal();
        handleGetNotificationOnScroll();

        if (typeof config.ajax_message != 'undefined' && config.ajax_message != '') {
            My.toast(config.ajax_message);
        }
        $('.dataTable')
                .on('preDraw.dt', function () {
                    My.blockUI({
                        target: $('#main-content'),
                        //boxed: true
                    });
                })
                .on('draw.dt', function () {
                    My.unblockUI('#main-content');
                })
        all_noti_count = $('.header-noti').data('all-noti-count');
//         My.pushNotiSound();

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
                '<a href="' + config.admin_url + '/notifications/' + obj.noti_object_id + '" class="noti-li">' +
                '<span class="time">' + obj.created_at + '</span>' +
                '<span class="details">' +
                '<span class="label label-sm label-icon label-success">' +
                '<i class="fa fa-bell-o"></i>' +
                '</span>' +
                obj.message
                + '</span>' +
                '</a>' +
                '</li>';
        return html;
    }
    var handleOneSignal = function () {
//        var OneSignal = window.OneSignal || [];
//        OneSignal.push(function () {
//            OneSignal.init({
//                appId: "4beb1622-1cff-41c5-a84a-af6b8420d79b",
//                notifyButton: {
//                    enable: true,
//                },
//                allowLocalhostAsSecureOrigin: true,
//            });
//        });
       
//        var OneSignal = window.OneSignal || [];
//        OneSignal.push(["init", {
//                appId: "4beb1622-1cff-41c5-a84a-af6b8420d79b",
////                subdomainName: 'tasks',
//                allowLocalhostAsSecureOrigin: true,
//                autoRegister: true,
//                promptOptions: {
//                    /* These prompt options values configure both the HTTP prompt and the HTTP popup. */
//                    /* actionMessage limited to 90 characters */
//                    actionMessage: "We'd like to show you notifications for the latest news.",
//                    /* acceptButtonText limited to 15 characters */
//                    acceptButtonText: "ALLOW",
//                    /* cancelButtonText limited to 15 characters */
//                    cancelButtonText: "NO THANKS"
//                }
//            }]);

        function subscribe() {
            // OneSignal.push(["registerForPushNotifications"]);
            OneSignal.push(["registerForPushNotifications"]);
            event.preventDefault();
        }
        function unsubscribe() {
            OneSignal.setSubscription(true);
        }

//        var OneSignal = OneSignal || [];
        OneSignal.push(function () {
            /* These examples are all valid */
            // Occurs when the user's subscription changes to a new value.
            OneSignal.on('subscriptionChange', function (isSubscribed) {
                console.log("The user's subscription state is now:", isSubscribed);
                OneSignal.sendTag("user_id", "1", function (tagsSent)
                {
                    // Callback called when tags have finished sending
                    console.log("Tags have finished sending!");
                });
            });

            var isPushSupported = OneSignal.isPushNotificationsSupported();
            if (isPushSupported)
            {
                // Push notifications are supported
                OneSignal.isPushNotificationsEnabled().then(function (isEnabled)
                {
                    if (isEnabled)
                    {
                        console.log("Push notifications are enabled!");
                           OneSignal.getUserId(function(userId) {

				    console.log("OneSignal User ID:", userId);


				  });

                    } else {
                        OneSignal.showHttpPrompt();
                        console.log("Push notifications are not enabled yet.");
                    }
                });

            } else {
                console.log("Push notifications are not supported.");
            }
        });


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







    var handleChangeLang = function () {
        $(document).on('click', '.change-lang', function () {
            var lang_code = $(this).data('locale');
            var action = config.admin_url + '/change_lang';
            $.ajax({
                url: action,
                data: {lang_code: lang_code},
                async: false,
                success: function (data) {
                    console.log(data);
                    if (data.type == 'success') {

                        window.location.reload()

                    }


                },
                error: function (xhr, textStatus, errorThrown) {
                    My.ajax_error_message(xhr);
                },
                dataType: "JSON",
                type: "GET"
            });

            return false;
        });
    }



    return {
        init: function () {
            init();
        },
        check_access: function ($module, $action) {
            var permissions = JSON.parse(config.prm);
            var check = $module + '_' + $action;
            if (permissions) {
                if (permissions.indexOf(check) != -1) {
                    return true;
                }
            }
            return false;
        },

        handleUsersSearch: function (params) {
            var data = typeof params.data !== 'undefined' ? params.data : {};
            var multiple = typeof params.multiple !== 'undefined' ? params.multiple : false;
            function movieFormatResult(item) {
                return '<span style="font-weight:bold;">' + item.name + '</span><br>' + ' ' + item.phone;
            }

            function movieFormatSelection(item) {
                return item.name + ' - ' + item.phone;
            }

            var item = $(params.ele).select2({
                multiple: multiple,
                placeholder: lang.search,
                minimumInputLength: 1,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: config.admin_url + '/ajax/search-users',
                    dataType: 'json',
                    data: function (term, page) {
                        return $.extend({
                            q: term, // search term
                            page: page, // search term
                            page_limit: 10
                        }, data)
                    },

                    results: function (data, page) { // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to alter remote JSON data
                        console.log(data);
                        return {
                            results: data.result,
                            more: (page * 10) < data.total
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
        handleChangeLocation: function (params) {
            $(document).on('change', params.ele, function () {
                var ele = $(this);
                var value = ele.val();

                if (value && value != '') {

                    $.get('' + config.ajax_url + '/locations?id=' + value, function (data) {
                        console.log(data);
                        ele.closest('.location-item').nextAll('.location-item').remove();
                        if (data.length != 0)
                        {
                            var html = '<div class="col-md-3 location-item">' +
                                    '<div class="form-group form-md-line-input">' +
                                    '<select class="form-control location-input" name="location[' + location_count + ']">';
                            html += '<option value="">Choose</option>';
                            $.each(data, function (key, obj) {
                                var selected = '';
                                console.log(obj);
                                html += '<option ' + selected + ' value="' + obj.id + '">' + obj.title + '</option>';
                            });
                            html += '</select>' +
                                    '<span class="help-block"></span>' +
                                    ' </div>' +
                                    '</div>';
                            ele.closest('.location-item').after(html);
                            $('select[name="location[' + location_count + ']"]').rules('add', {
                                required: true
                            });
                            location_count++;
                        }

                    }, "json");
                } else {
                    ele.closest('.location-item').nextAll('.location-item').remove();
                }
            });


        },
        remove_payment: function (t) {
            var id = $(t).data("id");
            My.deleteForm({
                element: t,
                url: config.ajax_url + '/payments/' + id,
                data: {_method: 'DELETE'},
                success: function (data)
                {
                    My.toast(data.message);
                    $(t).closest('tr').remove();
                }
            });
            return false;
        },

        handleTimePlugin: function () {
            $('.timepicker-no-seconds').timepicker({

                autoclose: true,
                minuteStep: 30
            });
        }

    }

}();

jQuery(document).ready(function (e) {
    Main.init();

});


