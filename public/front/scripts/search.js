var selected_id_arr = [];
var selected_rest_amount = 0;
var selected_rooms = [];
var selected_rooms_disabled = [];
var discount_type = 1;
var discount_value = 0;
var amount_paid = 0;
var grand_total = 0;
var Search = function () {
    var init = function () {
        $.extend(config, new_config);



       
        if (config.page == 'home' || config.page == 'hotel_details') {
            Main.handleDestinationSearchSubmit('.destination-search-frm');
            Main.handleDestinationsSearch({ele: '.destination-search-frm input[name="destination"]', multiple: false});
            My.handleDateRange('.destination-search-frm input[name="check_in"]', '.destination-search-frm input[name="check_out"]');

        }
         if (config.page == 'home') {
            $('.destination-search-frm input[name="check_in"]').datepicker("setDate", My.formatDate());
            $('.destination-search-frm input[name="check_out"]').datepicker("setDate", My.addDays(new Date(My.formatDate()), 1));
        }
        if (config.page == 'hotel_details') {
            $('.hotels-slider').slick({
                autoplay: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                pauseOnHover: false,
                prevArrow: '<button class="control control-l"><span class="PrevArrow"></span></button>',
                nextArrow: '<button class="control control-r"><span class="NextArrow"></span></button>'

            });
            handleSelectRooms();
            handleReserveSubmit();
            $('.destination-search-frm input[name="check_in"]').datepicker("setDate", config.check_in);
            $('.destination-search-frm input[name="check_out"]').datepicker("setDate", config.check_out);
            $('.destination-search-frm input[name="destination"]').select2("data", JSON.parse(config.destination));
        }
        if (config.page == 'bookings_checkout') {
            handleCheckoutSubmit();
            handleChangeCheckoutInputs();
            Main.handleUsersSearch({ele: "input[name='user']", data: {type: config.booking_type}});
            grand_total = parseFloat(config.sub_total);
            handleAddOrRemoveTravellers();
            Main.init_datepicker('input[name="travellers[' + traveller_count + '][birthdate]"]');
        }
    };

    var handleChangeCheckoutInputs = function () {
        $('input[name="user"]').on('change', function () {
            var data = $(this).select2('data');
//            console.log(data);
            if (data) {
                $('input[name="name"]').val(data.name);
                $('input[name="email"]').val(data.email);
                $('input[name="phone"]').val(data.phone);
            }

        });
        $('input[name="amount_paid"]').on('change', function () {
            amount_paid = parseFloat($(this).val());
//            console.log(amount_paid);
            calculatePrice();
        });
        $(document).on('change', 'input[name="amount_discount"]', function () {
            discount_value = parseFloat($(this).val());
            calculatePrice();
        });
    }

    var calculatePrice = function () {
        grand_total = parseFloat(config.sub_total);
        if (discount_value > 0) {
            if (discount_type == 1) {
                grand_total = grand_total - discount_value;
            } else {
                grand_total = grand_total - ((grand_total * discount_value) / 100);
            }
        }
        $('#grand-total').html(grand_total);
        if (amount_paid > 0) {
            console.log(grand_total);
            console.log(amount_paid);
            if (grand_total >= amount_paid) {
                $('#rest-amount').html(grand_total - amount_paid);
            }
        }


        return grand_total;



    }
    var handleCheckoutSubmit = function () {

        $('#CheckoutForm').validate({
            rules: {
                user: {
                    required: true
                },
                'travellers[0][name]': {
                    required: true
                },
                'travellers[0][phone]': {
                    required: true
                },
                'travellers[0][birthdate]': {
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



        $('#CheckoutForm .submit-form').click(function () {
            $('input[name="amount_paid"]').rules('add', {
                max: grand_total
            });
            if ($('#CheckoutForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#CheckoutForm').submit();
                }, 1000);

            }
            return false;
        });
        $('#CheckoutForm input').keypress(function (e) {
            if (e.which == 13) {
                $('input[name="amount_paid"]').rules('add', {
                    max: grand_total
                });
                if ($('#CheckoutForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#CheckoutForm').submit();
                    }, 1000);

                }
                return false;
            }
        });



        $('#CheckoutForm').submit(function () {
            var action = config.admin_url + '/bookings/checkout';
            var formData = new FormData($(this)[0]);
            formData.append('discount_value', discount_value);
            formData.append('discount_type', discount_type);
            formData.append('amount_paid', amount_paid);
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
                    setTimeout(function () {
                        window.location.href = data.url;
                    }, 1000);

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
    var handleSelectRooms = function () {
        $(document).on('change', '.reserve-select', function () {



            var ele = $(this);
            var quantity = parseInt(ele.val());
            var name = ele.attr('name');
            var room_count = ele.data('room-count');

            //start select rooms
            var room_id = ele.data('room-id');
            var room_total_quantity = 0;
            var room_selected = 0;
            $('select[name^="' + room_id + '"]').each(function () {
                room_total_quantity += parseInt($(this).val());
                if ($(this).val() > 0) {
                    room_selected++;
                }
                $(this).find('option').prop('disabled', false);
            });
            $('select[name^="' + room_id + '"]').each(function (i, v) {
                var select_value = $(this).val();
                console.log('select_value:' + select_value);
                var i = 1;
                for (var x = room_count; x >= 1; x--) {
                    if (i <= (room_total_quantity - $(this).val())) {
                        $(this).find('option:eq(' + x + ')').prop('disabled', true);
                    }
                    i++;
                }

            });
            //end select rooms



            if (quantity > 0) {
                var price = parseFloat(ele.find('option:selected').data('price'));
                var found = $.grep(selected_rooms, function (e) {
                    return e.name == name;
                });
                if (found.length > 0) {
                    for (var i in selected_rooms) {
                        if (selected_rooms[i].name == found[0].name) {
                            selected_rooms[i].quantity = quantity;
                            selected_rooms[i].price = price;
                            break;
                        }
                    }
                } else {
                    selected_rooms.push({name: name, price: price, quantity: quantity});
                }

            } else {
                selected_rooms = $.grep(selected_rooms, function (e) {
                    return e.name != name;
                });
            }
            console.log(selected_rooms);
            var quantity = 0;
            var price = 0;
            if (selected_rooms.length > 0) {
                for (var x = 0; x < selected_rooms.length; x++) {
                    var one = selected_rooms[x];
                    price += one.price * one.quantity;
                    quantity += one.quantity;
                }
            }
       
            if (quantity > 0) {
//                $('.reserve-select-th').tooltip('destroy');
                $('.reserve-select').closest('td').removeClass('reserve-select-error');
                $('.reserve-summary-rooms-and-price').show();
                $('#total-rooms').html('<strong>' + quantity + '</strong>');
                $('#total-price').html('<strong>' + config.currency + ' ' + price + '</strong>');
            } else {
                $('.reserve-summary-rooms-and-price').hide();
            }

        });
    }

    var _handleReserveSubmit = function () {




        $('#ReserveForm .submit-form').click(function () {
            var selected = 0;
            $('.reserve-select').each(function () {
                var value = $(this).val();
                if (value > 0) {
                    selected++;
                }
            })
            if (selected == 0) {
                $('.reserve-select').closest('td').addClass('reserve-select-error');
//                My.showValidateTooltip($('.reserve-select-th'), lang.please_select_one_or_more_option_you_want_to_book, 'right', '14', false);
                return false;
            }

        });

    }

    var handleReserveSubmit = function () {

        $('#ReserveForm').validate({
            rules: {
                destination: {
                    required: true
                },
                check_in: {
                    required: true
                },
                check_out: {
                    required: true
                },
                adults: {
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



        $('#ReserveForm .submit-form').click(function () {
            if ($('#ReserveForm').validate().form()) {
                My.blockUI();
                setTimeout(function () {
                    $('#ReserveForm').submit();
                }, 1000);

            }
            return false;
        });
        $('#ReserveForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#ReserveForm').validate().form()) {
                    My.blockUI();
                    setTimeout(function () {
                        $('#ReserveForm').submit();
                    }, 1000);

                }
                return false;
            }
        });



        $('#ReserveForm').submit(function () {
            var action = config.site_url + '/search/reserve';
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





    }


    return{
        init: function () {
            init();
        },

        empty: function () {
            My.emptyForm();
        },
    };
}();
$(document).ready(function () {
    Search.init();
});