var My = function () {

    // IE mode
    var isRTL = false;
    var isIE8 = false;
    var isIE9 = false;
    var isIE10 = false;


    // theme layout color set

    var brandColors = {
        'blue': '#89C4F4',
        'red': '#F3565D',
        'green': '#1bbc9b',
        'purple': '#9b59b6',
        'grey': '#95a5a6',
        'yellow': '#F8CB00'
    };

    var handleNewArrayMethods = function () {
        Array.prototype.remove = function () {
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };
    }
    var handleNewValidatorMethods = function () {
        if (typeof $.validator !== 'undefined') {
            $.validator.addMethod('filesize', function (value, element, param) {
                if (element.files.length > 0) {
                    return this.optional(element) || (element.files[0].size <= param)
                }
                return true;


            }, function (params, element) {
                var message = lang.filesize_can_not_be_more_than
                return message + ' ' + params;
            });
            $.validator.addMethod("notEqual", function (value, element, param) {
                return this.optional(element) || value != param;
            }, function (params, element) {
                return "Please specify a different " + params + " value";
            });
        }

    }
    var handleUploadBtnTrigger = function () {
        $(document).on('click', '.upload-image', function () {
            $(this).closest('.form-group').find('input[type="file"]').trigger('click');
        });
    }
    var handleAjaxSetupMethods = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }


    return {
        //main function to initiate the theme

        init: function () {
            handleNewValidatorMethods();
            handleNewArrayMethods();
            handleAjaxSetupMethods();
            handleUploadBtnTrigger();
            My.extensions();
        },

        extensions: function () {
            My.date_extension()
        },
        alert: function (type, message) {
            swal({
                title: message,
//                        text: message,
                icon: type,
                button: lang.close,
            });
        },
        pushNotiSound: function () {
            var sound = '<audio style="display:none;" id="noti-sound" controls>' +
                    '<source src="' + config.url + '/noti.ogg" type="audio/mpeg">Your browser does not support the audio element.' +
                    '</audio>';
            $('html').append(sound);
            var ele = $(document).find('#noti-sound');
            ele[0].play();

            //$('#reserve-count').html(data.reserve_count);
            setTimeout(function () {
                ele.remove()
            }, 2000);
        },
        clock: function () {
            // Create two variable with the names of the months and days in an array
            var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

            // Create a newDate() object
            var newDate = new Date();
            // Extract the current date from Date object
            newDate.setDate(newDate.getDate());
            // Output the day, date, month and year    
            $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

            setInterval(function () {
                // Create a newDate() object and extract the seconds of the current time on the visitor's
                var seconds = new Date().getSeconds();
                // Add a leading zero to seconds value
                $("#sec").html((seconds < 10 ? "0" : "") + seconds);
            }, 1000);

            setInterval(function () {
                // Create a newDate() object and extract the minutes of the current time on the visitor's
                var minutes = new Date().getMinutes();
                // Add a leading zero to the minutes value
                $("#min").html((minutes < 10 ? "0" : "") + minutes);
            }, 1000);

            setInterval(function () {
                // Create a newDate() object and extract the hours of the current time on the visitor's
                var hours = new Date().getHours();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                // Add a leading zero to the hours value
                $("#hours").html((hours < 10 ? "0" : "") + hours);
                $("#ampm").html(ampm);
            }, 1000);
        },
        roundTo: function (n) {
            if (n > 0)
                return Math.ceil(n / 5.0) * 5;
            else if (n < 0)
                return Math.floor(n / 5.0) * 5;
            else
                return 5;
        },
        NotiSound: function () {
            var sound = '<audio style="display:none;" id="noti-sound" controls>' +
                    '<source src="' + config.url + '/consequence.ogg" type="audio/mpeg">Your browser does not support the audio element.' +
                    '</audio>';
            $('html').append(sound);
            var ele = $(document).find('#noti-sound');
            ele[0].play();

            //$('#reserve-count').html(data.reserve_count);
            setTimeout(function () {
                ele.remove()
            }, 1000);
        },
        uploaded_content: function (params) {
            var multiple = typeof params.multiple == 'undefined' ? false : params.multiple;
            var view_btn = typeof params.view_btn == 'undefined' ? true : params.view_btn;
            var delete_btn = typeof params.delete_btn == 'undefined' ? true : params.delete_btn;
            var edit_btn = typeof params.edit_btn == 'undefined' ? true : params.edit_btn;
            var url = params.url;
            var background = params.background;
            var id = params.id;
            var item_upload_class = !multiple ? 'upload-image' : '';
            var html = '';
            if (multiple) {
                html += '<div class="image_box">';
            }

            html += '<img src="' + background + '" class="' + item_upload_class + '" width="100%" height="100%" />';
            if (delete_btn || view_btn) {
                html += '<div class="upload-overlay">';
                html += '<div class="icon">';
                if (delete_btn) {
                    html += '<a href="#" data-id="' + id + '" data-multiple="' + multiple + '" onclick="My.deleteUploadFile(this);return false;" class="icon-delete" title="">' +
                            '<i class="fa fa-remove"></i>' +
                            '</a>';
                }
                if (view_btn) {
                    html += '<a href="' + url + '" target="_blank" class="icon-view" title="">' +
                            '<i class="fa fa-eye"></i>' +
                            '</a>';
                }
                if (edit_btn) {
                    html += '<a href="" data-id="' + id + '" onclick="My.editUploadFile(this);return false;" class="icon-edit" title="">' +
                            '<i class="fa fa-edit"></i>' +
                            '</a>';
                }

                html += '</div>';
                html += '</div>';
            }
            if (multiple) {
                html += '</div>';
            }

            return html;
        },
        push_attachment: function (attachment_list, params) {
            var multiple = typeof params.multiple == 'undefined' ? false : params.multiple;
            var view_btn = typeof params.view_btn == 'undefined' ? true : params.view_btn;
            var delete_btn = typeof params.delete_btn == 'undefined' ? true : params.delete_btn;
            var edit_btn = typeof params.edit_btn == 'undefined' ? true : params.edit_btn;
            if (Object.prototype.toString.call(attachment_list) === '[object Object]') {
                for (x in attachment_list)
                {
                    var item_arr = attachment_list[x];
                    var upload_input = $("input[name=" + x + "]");
                    if (multiple) {
                        var items = [];
                        if (item_arr.length > 0) {
                            for (var x = 0; x < item_arr.length; x++) {
                                var one = item_arr[x];

                                items.push(My.uploaded_content({
                                    multiple: multiple,
                                    view_btn: view_btn,
                                    delete_btn: delete_btn,
                                    edit_btn: edit_btn,
                                    url: one.url,
                                    background: one.background,
                                    id: one.id,
                                }));
                            }
                        }
                        upload_input.closest('.form-group').find(".uploaded-images").html(items.join(' '));
                    } else {
                        var one = item_arr[0];
                        upload_input.closest('.form-group').find(".image_box").html(My.uploaded_content(
                                {
                                    multiple: multiple,
                                    view_btn: view_btn,
                                    delete_btn: delete_btn,
                                    edit_btn: edit_btn,
                                    url: one.url,
                                    background: one.background,
                                    id: one.id,
                                }));
                        var one = item_arr[0];
                    }

                }
            }
        },
        uploaded_content_mix: function (params) {
            var item_upload_class = '';
            var multiple = params.multiple;
            var delete_btn = params.delete_btn;
            var view_btn = params.view_btn;
            var image_name = params.image_name;
            var id = params.id;
            if (!multiple) {
                item_upload_class = 'upload-image';
            }
            var html = '<div class="image_item">';
            html += '<img src="' + config.upload_path + '/' + image_name + '" class="' + item_upload_class + '" width="120px" height="120px" />';
            if (delete_btn || view_btn) {
                html += '<div class="upload-overlay">';
                html += '<div class="icon">';
                if (delete_btn) {
                    html += '<a href="#" data-id="' + id + '" data-multiple="' + multiple + '" onclick="Attachment.delete(this);return false;" class="icon-delete" title="">' +
                            '<i class="fa fa-remove"></i>' +
                            '</a>';
                }
                if (view_btn) {
                    html += '<a href="' + config.upload_path + '/' + image_name + '" target="_blank" class="icon-view" title="">' +
                            '<i class="fa fa-eye"></i>' +
                            '</a>';
                }

                html += '</div>';
                html += '</div>';
            }

            html += '</div>';
            return html;
        },
        uploaded_content_mix__: function (image_name, id, multiple) {
            var item_upload_class = '';
            if (!multiple) {
                item_upload_class = 'upload-image';
            }
            var html = '<div class="image_item">';
            html += '<img src="' + config.upload_path + '/' + image_name + '" class="' + item_upload_class + '" width="120px" height="120px" />';
            html += '<div class="upload-overlay">' +
                    '<div class="icon">' +
                    '<a href="#" data-id="' + id + '" data-multiple="' + multiple + '" onclick="Attachment.delete(this);return false;" class="icon-delete" title="">' +
                    '<i class="fa fa-remove"></i>' +
                    '</a>' +
                    '<a href="' + config.upload_path + '/' + image_name + '" target="_blank" class="icon-view" title="">' +
                    '<i class="fa fa-eye"></i>' +
                    '</a>' +
                    '</div>' +
                    '</div>';
            html += '</div>';
            return html;
        },
        date_extension: function () {



            Date.prototype.addDays = function (num) {
                var value = this.valueOf();
                value += 86400000 * num;
                return new Date(value);
            }

            Date.prototype.addSeconds = function (num) {
                var value = this.valueOf();
                value += 1000 * num;
                return new Date(value);
            }

            Date.prototype.addMinutes = function (num) {
                var value = this.valueOf();
                value += 60000 * num;
                return new Date(value);
            }

            Date.prototype.addHours = function (num) {
                var value = this.valueOf();
                value += 3600000 * num;
                return new Date(value);
            }

            Date.prototype.addMonths = function (num) {
                var value = new Date(this.valueOf());

                var mo = this.getMonth();
                var yr = this.getYear();

                mo = (mo + num) % 12;
                if (0 > mo) {
                    yr += (this.getMonth() + num - mo - 12) / 12;
                    mo += 12;
                } else
                    yr += ((this.getMonth() + num - mo) / 12);

                value.setMonth(mo);
                value.setYear(yr);
                return value;
            }
        },
        addDays: function (startDate, numberOfDays)
        {
            var returnDate = new Date(
                    startDate.getFullYear(),
                    startDate.getMonth(),
                    startDate.getDate() + numberOfDays,
                    startDate.getHours(),
                    startDate.getMinutes(),
                    startDate.getSeconds());
            return returnDate;
        },
        getDate: function (date) {
            var dd = date.getDate();
            var mm = date.getMonth() + 1; //January is 0!
            var yyyy = date.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }
            var edited_date = yyyy + '-' + mm + '-' + dd;
            return edited_date;
        },
        formatDate: function (date) {

            var today = typeof date != 'undefined' ? new Date(date) : new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var today = yyyy + '-' + mm + '-' + dd;



            return today;
        },
        getGlobalImgPath: function () {
            return config.img_path + '/';
        },
        blockUI: function (options) {
            console.log(this.getGlobalImgPath());
            options = $.extend(true, {}, options);
            var html = '';
            if (options.animate) {
                html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>';
            } else if (options.iconOnly) {
                html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="' + this.getGlobalImgPath() + 'eclipse-loader.gif" align=""></div>';
            } else if (options.textOnly) {
                html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
            } else {
//                html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="' + this.getGlobalImgPath() + 'eclipse-loader.gif" align=""><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
                html = '<div class="loading-message"><img src="' + this.getGlobalImgPath() + 'eclipse-loader.gif" style="height:120px;width:120px;" align=""></div>';
            }

            if (options.target) { // element blocking
                var el = $(options.target);
                if (el.height() <= ($(window).height())) {
                    options.cenrerY = true;
                }
                el.block({
                    message: html,
                    baseZ: options.zIndex ? options.zIndex : 1000,
                    centerY: options.cenrerY !== undefined ? options.cenrerY : false,
                    css: {
                        top: '10%',
                        border: '0',
                        padding: '0',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        backgroundColor: options.overlayColor ? options.overlayColor : '#fff',
                        opacity: options.boxed ? 1 : 0.1,
                        cursor: 'wait'
                    }
                });
            } else { // page blocking
                $.blockUI({
                    message: html,
                    baseZ: options.zIndex ? options.zIndex : 1000,
                    css: {
                        border: '0',
                        padding: '0',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                        opacity: options.boxed ? 0.05 : 0.1,
                        cursor: 'wait'
                    }
                });
            }
        },

        // wrMetronicer function to  un-block element(finish loading)
        unblockUI: function (target) {
            if (target) {
                $(target).unblock({
                    onUnblock: function () {
                        $(target).css('position', '');
                        $(target).css('zoom', '');
                    }
                });
            } else {
                $.unblockUI();
            }
        },
        print: function (div)
        {
            var mywindow = window.open('', 'PRINT', 'height=600,width=800');
            mywindow.document.open();
            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('</head><body onload="window.print()">');
            mywindow.document.write(document.getElementById(div).innerHTML);
            mywindow.document.write('</body></html>');
            mywindow.document.close();
//            mywindow.focus(); // necessary for IE >= 10*/

            // mywindow.print();
            //mywindow.close();
            setTimeout(function () {
                mywindow.close();
            }, 10);
        },
        toast: function (obj) {

            toastr.options = {
                "debug": false,
                "onclick": null,
                "fadeIn": 300,
                "fadeOut": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            if (typeof obj == "object") {
                var message = obj.message;
                var message_type = obj.type;
                if (typeof obj.positionClass != 'undefined') {
                    toastr.options["positionClass"] = obj.positionClass;
                } else {
                    toastr.options["positionClass"] = config.lang_code == 'ar' ? "toast-top-left" : "toast-top-right";
                }
                if (message_type == "error") {
                    toastr.error(message, lang.message);
                } else {
                    toastr.success(message, lang.message);
                }
            } else {
                var message = obj;
                toastr.options["positionClass"] = config.lang_code == 'ar' ? "toast-top-left" : "toast-top-right";
                toastr.success(message, lang.message);
            }

        },
        getYoutubeEmbedUrl: function (url) {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = url.match(regExp);

            if (match && match[2].length == 11) {
                return match[2];
            } else {
                return 'error';
            }
        },
        readImage: function (input) {

            $(document).on('click', "." + input, function () {
                $("#" + input).trigger('click');
            });
            $(document).on('change', "#" + input, function () {
                //alert($(this)[0].files.length);
                for (var i = 0; i < $(this)[0].files.length; i++) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.image_uploaded_box').html('<img style="height:80px;width:150px;" id="image_upload_preview" class="' + input + '" src="' + e.target.result + '" alt="your image" />');
                    }

                    reader.readAsDataURL($(this)[0].files[i]);
                }

            });



        },
        readImageMulti: function (input, width, height) {

            $(document).on('click', "." + input, function () {
                $("#" + input).trigger('click');
            });
            $(document).on('change', "#" + input, function () {
                //alert($(this)[0].files.length);
                for (var i = 0; i < $(this)[0].files.length; i++) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.' + input + '_box').html('<img style="height:' + height + ';width:' + width + ';" class="' + input + '" src="' + e.target.result + '" alt="your image" />');
                    }

                    reader.readAsDataURL($(this)[0].files[i]);
                }

            });



        },
        number_format: function (number, decimals, dec_point, thousands_sep) {


            number = (number + '')
                    .replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function (n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + (Math.round(n * k) / k)
                                .toFixed(prec);
                    };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
                    .split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '')
                    .length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1)
                        .join('0');
            }
            return s.join(dec);
        },
        ajax_error_message: function (xhr, form = '') {
            My.unblockUI();
            if (typeof xhr.responseJSON !== "undefined") {
                var json = xhr.responseJSON;
                var message = json.message;
                if (xhr.status == 422) {
                    var errors = json.errors;
                    var input_files_messages = {image: [], pdf: [], video: []};
                    for (i in errors) {
                        var value = errors[i];
                        var key_arr = i.split('.');
                        var name = '';
                        if (key_arr[0] == 'image' || key_arr[0] == 'pdf' || key_arr[0] == 'video') {
                            var count = input_files_messages[key_arr[0]].length + 1;
                            input_files_messages[key_arr[0]].push(lang.file + ' ' + count + ' : ' + value);
                            continue;
                        }
                        for (var x = 0; x < key_arr.length; x++) {

                            if (x == 0) {
                                name += key_arr[x];
                            } else {
                                name += '[' + key_arr[x] + ']';
                            }
                        }
                        i = name;
                        console.log(i);
                        errorElements.push($('[name="' + i + '"]'));
                        $('[name="' + i + '"]')
                                .closest('.form-group').addClass('has-error');
                        $('[name="' + i + '"]').closest('.form-group').find(".help-block").html(value).css('opacity', 1);
                    }
                    console.log(input_files_messages);
                    for (x in input_files_messages) {
                        if (input_files_messages[x].length > 0) {
                            var value2 = input_files_messages[x].join('<br>');
                            console.log(value2);
                            $('[name ^="' + x + '"]')
                                    .closest('.form-group').addClass('has-error');
                            $('[name ^="' + x + '"]').closest('.form-group').find(".help-block").html(value2).css('opacity', 1);
                        }

                    }
                    My.scrollToTopWhenFormHasError(form);
                    My.toast({message: message, type: "error"});
                } else {
                    My.toast({message: message, type: "error"});
                }


            } else {
//                bootbox.dialog({
//                    message: xhr.responseText,
//                    title: lang.attention_message,
//                    buttons: {
//                        danger: {
//                            label: lang.close,
//                            className: "red"
//                        }
//                    }
//                });
                Swal.fire('', xhr.responseText, "error");
        }


        //console.log(text_message);

        }
        ,
        scrollToTopWhenFormHasError: function () {
            var $container = "html,body";
            var $scrollContainer = window;
            var containerOffsetTop = $($container).offset().top;
            var containerScrollTop = $($scrollContainer).scrollTop();
            if ($($container).is("html")) {
                containerOffsetTop = containerScrollTop;
            }
            console.log(errorElements[0], Math.floor(errorElements[0].offset().top - containerOffsetTop), (containerScrollTop));
            if (containerScrollTop > (Math.floor(errorElements[0].offset().top - containerOffsetTop) - 10)) {
                console.log('mustScroll');
                console.log(containerScrollTop - (Math.floor(errorElements[0].offset().top - containerOffsetTop) - 10));
                $($container).animate({scrollTop: containerScrollTop + (Math.floor(errorElements[0].offset().top - containerOffsetTop) - 10)});

            }
        },
        set_error: function (id, msg) {
            $('[name="' + id + '"]')
                    .closest('.form-group').addClass('has-error').removeClass("has-info");
            $('#' + id).parent()

            if ($("#" + id).parent().hasClass("input-group"))
            {
                $help_block = $('#' + id).parent().parent().find('.help-block');
            } else {
                $help_block = $('#' + id).parent().find('.help-block');
            }


            if ($help_block.length)
            {
                $help_block.html(msg);
            } else {
                if ($("#" + id).parent().hasClass("input-group"))
                    $('#' + id).parent().parent().append('<span class="help-block">' + msg + '</span>');
                else
                    $('#' + id).parent().append('<span class="help-block">' + msg + '</span>');
            }
        }
        ,
        set_errors: function (errors) {
            for (var i in errors)
            {
                My.set_error(i, errors[i]);
            }
        }
        ,
        initCheckbox: function () {

            if ($('#checkAll').length == 0)
                return false;

            var checkboxes = document.querySelectorAll('input.check-me'),
                    checkall = document.getElementById('checkAll');

            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].onclick = function () {
                    var checkedCount = document.querySelectorAll('input.check-me:checked').length;

                    checkall.checked = checkedCount > 0;
                    checkall.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
                    if (checkedCount > 0)
                    {
                        $('#delete-selected').prop("disabled", false);
                    } else {
                        $('#delete-selected').prop("disabled", true);
                    }
                    if (checkedCount > 0 && checkedCount < checkboxes.length)
                    {
                        $('#checkAll').parent().addClass("indeterminate").removeClass("checked");
                    } else {
                        $('#checkAll').parent().removeClass("indeterminate");
                    }
                    $('#delete-num').html(checkedCount)
                }
            }

            checkall.onclick = function () {

                var checkedCount = document.querySelectorAll('input.check-me:checked').length;
                if (checkedCount > 0 && checkedCount < checkboxes.length)
                {
                    this.checked = true;
                } else if (checkedCount == 0) {
                    this.checked = true;
                } else {
                    this.checked = false;
                }

                $('#checkAll').parent().addClass("checked").removeClass("indeterminate");

                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = this.checked;
                }

                if (document.querySelectorAll('input.check-me:checked').length > 0)
                {
                    $('#delete-selected').prop("disabled", false);
                } else {
                    $('#delete-selected').prop("disabled", true);
                }

                $('#delete-num').html(document.querySelectorAll('input.check-me:checked').length)
            }
        }
        ,
        emptyForm: function (form) {
            // $('[data-role="tagsinput"]').tagsinput('removeAll');
            if (typeof form != 'undefined') {
                $('' + form + ' input[type="text"],' + form + ' input[type="email"],' + form + ' input[type="date"],' + form + ' input[type="password"],' + form + ' input[type="number"],' + form + ' textarea').val("");
                $('' + form + ' .has-error').removeClass('has-error');
                $('' + form + ' .has-success').removeClass('has-success');
                $('' + form + ' .help-block').html('');
                $('' + form + ' input[type="checkbox"]').prop("checked", false).trigger("change");
            } else {
                $('input[type="text"],input[type="email"],input[type="date"],input[type="password"],input[type="number"],textarea').val("");
                $('.has-error').removeClass('has-error');
                $('.has-success').removeClass('has-success');
                $('.help-block').html('');
                $('input[type="checkbox"]').prop("checked", false).trigger("change");
            }
            $('.image_box').html('<img src="' + config.url + '/no-image.jpg" width="100%" height="100%"  class="upload-image" />');
            $('.uploaded-images').html('');
            errorElements = new Array;
            new_attachment = new Array;

        }
        ,
        editUploadFile: function (t) {
            attachment_selected_id = $(t).data("id");
            My.editForm({
                url: config.ajax_url + '/upload/' + attachment_selected_id + '/edit',
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
        deleteUploadFile: function (t) {
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
        uploadFile: function (element, additionalItems) {
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
            var progress_div = inputFile.closest('.form-group').find('.progress');
            uploadXhr = $.ajax({
                type: "POST",
                dataType: "json",
                url: config.upload_url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                xhr: function ()
                {
                    var xhr = new window.XMLHttpRequest();
                    currentUploadProgress = 0;
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
                }

            }).done(function (response) {
                if (typeof response.uploaded !== "undefined")
                {
                    progress_div.hide();
                    var result = response.uploaded;
                    var attr = inputFile.attr('multiple');

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
                        inputFile.closest('.form-group').find(".uploaded-images").append(items.join(' '));
                    } else {
                        var one = result[0];
                        new_attachment.push(one.id);
                        inputFile.closest('.form-group').find(".image_box").html(My.uploaded_content(
                                {
                                    multiple: false,
                                    edit_btn: false,
                                    url: one.url,
                                    background: one.background,
                                    id: one.id,
                                }));
                    }

                }
            }).fail(function (xhr) {
                progress_div.hide();
                My.ajax_error_message(xhr);

            });



        },
        scrollTo: function (el, offeset) {
            var pos = (el && el.size() > 0) ? el.offset().top : 0;

            if (el) {
                if ($('body').hasClass('page-header-fixed')) {
                    pos = pos - $('.page-header').height();
                } else if ($('body').hasClass('page-header-top-fixed')) {
                    pos = pos - $('.page-header-top').height();
                } else if ($('body').hasClass('page-header-menu-fixed')) {
                    pos = pos - $('.page-header-menu').height();
                }
                pos = pos + (offeset ? offeset : -1 * el.height());
            }

            $('html,body').animate({
                scrollTop: pos
            }, 'slow');
        }
        ,
        setModalTitle: function (id, title)
        {
            $(id + 'Label').html(title);
        }
        ,
        clearToolTip: function () {
            $('.tooltip.fade').each(function () {
                if ($(this).attr("id"))
                {
                    var $id = $(this).attr("id");
                    $('[aria-describedby="' + $id + '"]').removeAttr("aria-describedby");
                    $(this).remove()
                }
            })
        }
        ,
        editForm: function (args) {
            My.blockUI();
            setTimeout(function () {
                $.ajax({
                    url: args.url,
                    data: args.data,
                    type: "GET",
                    success: function (data)
                    {
                        My.unblockUI();
                        args.success(data);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        My.unblockUI();
                        My.ajax_error_message(xhr);

                    },
                    dataType: "json",
                })
            }, 500);

            return false;

        }
        ,
        clearFormErrors: function () {
            $('.has-error').removeClass("has-error");
            $('.help-block').html("");
        }
        ,
        Ajax: function (args) {
            if (args.data === undefined) {
                args.data = {};
            }
            $.ajax({
                url: args.url,
                data: args.data,
                success: function (data)
                {
                    My.unblockUI(args.blockUI);
                    args.success(data);
                },
                error: function (xhr, textStatus, errorThrown) {
                    My.unblockUI(args.blockUI);
                    My.ajax_error_message(xhr);
                },
                dataType: args.dataType,
                type: args.type
            })
            return false;

        }
        ,
        deleteForm2: function (args) {

            //My.clearToolTip();
//                $(args.element).confirmation({
//                    onConfirm: function () {
//
//                        $(args.element).html('<i class="fa fa-spin fa-spinner"></i>');
//
//                        $.ajax({
//                            url: args.url,
//                            data: args.data,
//                            success: function (data) {
//
//                                $(args.element).html('<i class="fa fa-trash fa-1-8x text-danger"></i>');
//
//                                if (data.type == 'success')
//                                {
//
//                                    $(args.element).parent().parent().fadeOut('slow');
//                                    args.success(data);
//
//                                }
//
//                            },
//                            error: function (xhr, textStatus, errorThrown) {
//                                $(args.element).html('<i class="fa fa-trash fa-1-8x text-danger"></i>');
//
//                                $('.loading').addClass('hide');
//                                bootbox.dialog({
//                                    message: xhr.responseText,
//                                    title: lang.messages_error,
//                                    buttons: {
//                                        danger: {
//                                            label: lang.close,
//                                            className: "red"
//                                        }
//                                    }
//                                });
//                            },
//                            dataType: "json",
//                            type: "post"
//                        })
//
//                        return false;
//                    }
//                }).confirmation({'trigger': 'click'});
        }
        ,
        ajaxConfirm___: function (args) {



        },
        deleteForm: function (args) {
            swal(lang.confirm_message,
                    {
                        buttons: {
                            no: {
                                text: "No",
                                value: 0,
                                closeModal: true,
                            },
                            yes: {
                                text: "Yes",
                                value: 1,
                            },
                        },
                    })
                    .then((value) => {
                        switch (value) {

                            case 1:
                                My.blockUI();
                                setTimeout(function () {
                                    $.ajax({
                                        url: args.url,
                                        data: args.data,
                                        success: function (data) {
                                            My.unblockUI();
                                            args.success(data);
                                        },
                                        error: function (xhr, textStatus, errorThrown) {
                                            My.unblockUI();
                                            My.ajax_error_message(xhr);
                                        },
                                        dataType: "json",
                                        type: "post"
                                    })
                                }, 500);
                                break;

                            case 0:
//                                swal("Gotcha!", "Pikachu was caught!", "success");
                                break;
                        }
                    });



        },
        ajaxConfirm: function (args) {
            swal(args.message,
                    {
                        buttons: {
                            no: {
                                text: "No",
                                value: 0,
                                closeModal: true,
                            },
                            yes: {
                                text: "Yes",
                                value: 1,
                            },
                        },
                    })
                    .then((value) => {
                        switch (value) {

                            case 1:
                                My.blockUI();
                                setTimeout(function () {
                                    $.ajax({
                                        url: args.url,
                                        data: args.data,
                                        success: function (data) {
                                            My.unblockUI();
                                            args.success(data);
                                        },
                                        error: function (xhr, textStatus, errorThrown) {
                                            My.unblockUI();
                                            My.ajax_error_message(xhr);
                                        },
                                        dataType: "json",
                                        type: "post"
                                    })
                                }, 500);
                                break;

                            case 0:
//                                swal("Gotcha!", "Pikachu was caught!", "success");
                                break;
                        }
                    });



        },
        ajaxConfirm_: function (args) {
            var del = bootbox.dialog({
                animate: false,
                message: '<p class="text-center bold" style="font-size: 18px;">' + args.message + '</p>',
                title: lang.attention_message,
                buttons: {
                    cancel: {
                        label: lang.no,
                        className: 'btn-default'
                    },
                    danger: {
                        label: lang.yes,
                        className: "btn-primary",
                        callback: function (ele) {
                            My.blockUI({
                                target: $('.page-content')
                            });
                            setTimeout(function () {
                                $.ajax({
                                    url: args.url,
                                    data: args.data,
                                    success: function (data) {
                                        console.log(data);
                                        My.unblockUI('.page-content');

                                        args.success(data);
                                    },
                                    error: function (xhr, textStatus, errorThrown) {
                                        My.unblockUI('.page-content');

                                        My.ajax_error_message(xhr);
                                    },
                                    dataType: "json",
                                    type: "post"
                                })
                            }, 2000);

                        }
                    }
                }
            });


        }
        ,
        showValidateTooltip: function (element, title, placement, fontSize, container) {
            var conf = {
                'template': '<div class="tooltip newValidateTooltip" style="font-size:' + fontSize + '" role="tooltip"><div class="tooltip-arrow  alshamel-tooltip-arrow"></div><div class="tooltip-inner  alshamel-tooltip"></div></div>',
                'container': container,
                'title': title,
                'placement': placement,
                'trigger': 'manual',
                'animation': false,
            };

            element.tooltip(conf).tooltip('show');


        },
        handleDateRange: function (from, to) {
            var selectors_from = $(from);
            var selectors_to = $(to);
            selectors_from.datepicker({
                format: "yyyy-mm-dd",
                rtl: config.lang_code == 'ar' ? true : false,
                orientation: "left",
                autoclose: true,
            });


            selectors_to.datepicker({
                format: "yyyy-mm-dd",
                rtl: config.lang_code == 'ar' ? true : false,
                orientation: "left",
                autoclose: true
            });
//            selectors_from.datepicker("setDate", My.formatDate());
//            selectors_to.datepicker("setDate", My.addDays(new Date(My.formatDate()), 1));

            selectors_from.datepicker({
                todayBtn: 1,
                autoclose: true,
            }).on('changeDate', function (selected) {
                var minDate = new Date(My.addDays(new Date(selected.date.valueOf()), 1));
//            var minDate = new Date(selected.date.valueOf());
                console.log('min:' + minDate);
                var from_date = My.formatDate(selected.date.valueOf())
                var to_date = My.formatDate(selectors_to.datepicker('getDate'))

                selectors_to.datepicker('setStartDate', minDate);
                if (from_date == to_date) {
//                console.log('from:' + from_date);
//                console.log('to:' + to_date);
                    selectors_to.datepicker('setDate', minDate);
                }

            });

            selectors_to.datepicker()
                    .on('changeDate', function (selected) {
                        var maxDate = new Date(selected.date.valueOf());
                        console.log('max:' + maxDate);
                        selectors_from.datepicker('setEndDate', maxDate);
                    });
        },
        init_datepicker: function (date) {
            var selectors_date = $(date);
            selectors_date.datepicker({
                format: "yyyy-mm-dd",
                rtl: config.lang_code == 'ar' ? true : false,
                orientation: "left",
                autoclose: true,
            });

            //selectors_date.datepicker("setDate", My.formatDate());


        },
        multiDeleteForm: function (args) {

            My.clearToolTip();

            if ($(args.element).hasClass("has-confirm")) {
                $(args.element).confirmation('show');
                return false;
            }
            $(args.element).addClass("has-confirm");
            $(args.element).confirmation({
                href: "javascript:;",
                onConfirm: function () {

                    $.ajax({
                        url: config.site_url + args.url,
                        data: args.data,
                        success: function (data) {

                            if (data.type == 'success')
                            {
                                args.success(data);
                                $(args.element).prop("disabled", true);
                                $('#delete-num').html(0);
                                $('#checkAll').prop("indeterminate", false).parent().removeClass("indeterminate");

                            } else {
                                bootbox.dialog({
                                    message: data.message,
                                    title: lang.messages_error,
                                    buttons: {
                                        danger: {
                                            label: lang.close,
                                            className: "red"
                                        }
                                    }
                                });
                            }

                        },
                        error: function (xhr, textStatus, errorThrown) {

                            $('.loading').addClass('hide');
                            bootbox.dialog({
                                message: xhr.responseText,
                                title: lang.messages_error,
                                buttons: {
                                    danger: {
                                        label: lang.close,
                                        className: "red"
                                    }
                                }
                            });
                        },
                        dataType: "json",
                        type: "post"
                    })

                    return false;
                }
            }).confirmation('show');
        }
        ,
    }
    ;

}();

jQuery(document).ready(function () {
    My.init();
});

