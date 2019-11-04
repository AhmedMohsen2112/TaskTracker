var group;
var branchPlanCalendar;
var FromDate;
var ToDate;
var Dashboard = function () {
    var init = function () {
        $.extend(config, new_config);
//        handleBookingMonthsChart();
//        handleChangeBranch();
//        handleBranchesSearch();
//        fetchBrancPlanData();
//        handleBranchesChart();
//        handleStudentsChart();
//        handleFirstMonthGroupsCalender();
//        handleSecondMonthGroupsCalender();
//        handleThirdMonthGroupsCalender();
//        handleViewDebtorDetails();
//
//        handleGlobalDateRange();




    };
    var handleChangeRange = function () {
        //$(document).on('click', '.range-apply-btn', function () {
        var action = config.admin_url + '/change_range';
        $.ajax({
            url: action,
            data: {from_date: FromDate, to_date: ToDate},
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
        //});
    }
    var handleGlobalDateRange = function () {
        $('#reportrange').daterangepicker({
            opens: (Metronic.isRTL() ? 'left' : 'right'),
            startDate: config.from_date,
            endDate: config.to_date,
//            minDate: '01/01/2012',
//            maxDate: '12/31/2020',
//            minYear: 1901,
//            maxYear: parseInt(moment().format('YYYY'), 10),
            dateLimit: {
                days: 60
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            buttonClasses: ['btn'],
            applyClass: 'green range-apply-btn',
            cancelClass: 'default',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Apply',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        },
                function (start, end) {
                    $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                    FromDate = start.format('YYYY-MM-DD');
                    ToDate = end.format('YYYY-MM-DD');
                    handleChangeRange();
                }
        );
        //Set the initial state of the picker label
        FromDate = config.from_date;
        ToDate = config.to_date;
        //console.log(ToDate);
        $('#reportrange span').html(FromDate + ' - ' + ToDate);
    }
    var handleViewDebtorDetails = function () {

        $(document).on('click', '.debtor-details-row-button', function () {
            var btn = $(this);
            var row = btn.closest('tr').next();
            if (row.is(':visible')) {
                // This row is already open - close it
                btn.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                row.hide();
            } else {
                // Open this row
                btn.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                row.show();
            }
            return false;
        });
    }

    var handleStudentsChart = function () {
        var students = JSON.parse(config.students_count);
        var days = students.days;
        var leads_count = students.leads_count;
        var registered_count = students.registered_count;
        var myLineChart = new Chart($('#students-chart'), {
            type: 'line',
            data: {
                labels: days,
                datasets: [
                    {
                        label: 'leads',
                        data: leads_count,
                        backgroundColor: 'blue',
                        borderColor: 'lightblue',
                        fill: false,
                        lineTension: 0.3,
                    },
                    {
                        label: 'registered',
                        data: registered_count,
                        backgroundColor: 'purple',
                        borderColor: 'purple',
                        fill: false,
                        lineTension: 0.3,
                    }
                ]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    //text: 'Chart.js Bar Chart'
                }
            },

        });
    }
    var handleBookingMonthsChart = function () {
        var booking_statistics_monthly = JSON.parse(config.booking_statistics_monthly);
        var myLineChart = new Chart($('#booking-months-chart'), {
            type: 'line',
            data: {
                labels: booking_statistics_monthly.months,
                datasets: [{
                        label: 'total income',
                        data: booking_statistics_monthly.income,
                        backgroundColor: 'blue',
                        borderColor: 'lightblue',
                        fill: false,
                        lineTension: 0.3,
                    }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: false,
                    text: lang.monthly_booking_income
                }
            }
        });
    }
    var handleBranchesChart = function () {
        var branches_income = JSON.parse(config.branches_income);
        var myLineChart = new Chart($('#branches-chart'), {
            type: 'bar',
            data: {
                labels: branches_income.branches,
                datasets: [{
                        label: 'total income',
                        data: branches_income.income,
                        backgroundColor: 'blue',
                        borderColor: 'lightblue',
                        fill: false,
                        lineTension: 0.3,
                    }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    // text: 'Chart.js Bar Chart'
                }
            }
        });
    }
    var handleBranchesAmChart2 = function () {
        // Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
        var chart = am4core.create(document.getElementById("branches-chart"), am4charts.XYChart);

// Add data
        chart.data = JSON.parse(config.branches_income);

// Create axes

        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "branch";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;

//        categoryAxis.renderer.labels.template.adapter.add("dy", function (dy, target) {
//            if (target.dataItem && target.dataItem.index & 2 == 2) {
//                return dy + 25;
//            }
//            return dy;
//        });

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "income";
        series.dataFields.categoryX = "branch";
        series.name = 'name';
        series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
        series.columns.template.fillOpacity = .8;

        var columnTemplate = series.columns.template;
        columnTemplate.strokeWidth = 2;
        columnTemplate.strokeOpacity = 1;
    }
    var handleMonthsAmChart2 = function () {
        am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
        var chart = am4core.create("months-chart", am4charts.XYChart);

// Add data
        chart.data = [{
                "date": "2012-07-27",
                "value": 13
            }, {
                "date": "2012-07-28",
                "value": 11
            }, {
                "date": "2012-07-29",
                "value": 15
            }, {
                "date": "2012-07-30",
                "value": 16
            }, {
                "date": "2012-07-31",
                "value": 18
            }, {
                "date": "2012-08-01",
                "value": 13
            }, {
                "date": "2012-08-02",
                "value": 22
            }, {
                "date": "2012-08-03",
                "value": 23
            }, {
                "date": "2012-08-04",
                "value": 20
            }, {
                "date": "2012-08-05",
                "value": 17
            }, {
                "date": "2012-08-06",
                "value": 16
            }, {
                "date": "2012-08-07",
                "value": 18
            }, {
                "date": "2012-08-08",
                "value": 21
            }, {
                "date": "2012-08-09",
                "value": 26
            }, {
                "date": "2012-08-10",
                "value": 24
            }, {
                "date": "2012-08-11",
                "value": 29
            }, {
                "date": "2012-08-12",
                "value": 32
            }, {
                "date": "2012-08-13",
                "value": 18
            }, {
                "date": "2012-08-14",
                "value": 24
            }, {
                "date": "2012-08-15",
                "value": 22
            }, {
                "date": "2012-08-16",
                "value": 18
            }, {
                "date": "2012-08-17",
                "value": 19
            }, {
                "date": "2012-08-18",
                "value": 14
            }, {
                "date": "2012-08-19",
                "value": 15
            }, {
                "date": "2012-08-20",
                "value": 12
            }, {
                "date": "2012-08-21",
                "value": 8
            }, {
                "date": "2012-08-22",
                "value": 9
            }, {
                "date": "2012-08-23",
                "value": 8
            }, {
                "date": "2012-08-24",
                "value": 7
            }, {
                "date": "2012-08-25",
                "value": 5
            }, {
                "date": "2012-08-26",
                "value": 11
            }, {
                "date": "2012-08-27",
                "value": 13
            }, {
                "date": "2012-08-28",
                "value": 18
            }, {
                "date": "2012-08-29",
                "value": 20
            }, {
                "date": "2012-08-30",
                "value": 29
            }, {
                "date": "2012-08-31",
                "value": 33
            }, {
                "date": "2012-09-01",
                "value": 42
            }, {
                "date": "2012-09-02",
                "value": 35
            }, {
                "date": "2012-09-03",
                "value": 31
            }, {
                "date": "2012-09-04",
                "value": 47
            }, {
                "date": "2012-09-05",
                "value": 52
            }, {
                "date": "2012-09-06",
                "value": 46
            }, {
                "date": "2012-09-07",
                "value": 41
            }, {
                "date": "2012-09-08",
                "value": 43
            }, {
                "date": "2012-09-09",
                "value": 40
            }, {
                "date": "2012-09-10",
                "value": 39
            }, {
                "date": "2012-09-11",
                "value": 34
            }, {
                "date": "2012-09-12",
                "value": 29
            }, {
                "date": "2012-09-13",
                "value": 34
            }, {
                "date": "2012-09-14",
                "value": 37
            }, {
                "date": "2012-09-15",
                "value": 42
            }, {
                "date": "2012-09-16",
                "value": 49
            }, {
                "date": "2012-09-17",
                "value": 46
            }, {
                "date": "2012-09-18",
                "value": 47
            }, {
                "date": "2012-09-19",
                "value": 55
            }, {
                "date": "2012-09-20",
                "value": 59
            }, {
                "date": "2012-09-21",
                "value": 58
            }, {
                "date": "2012-09-22",
                "value": 57
            }, {
                "date": "2012-09-23",
                "value": 61
            }, {
                "date": "2012-09-24",
                "value": 59
            }, {
                "date": "2012-09-25",
                "value": 67
            }, {
                "date": "2012-09-26",
                "value": 65
            }, {
                "date": "2012-09-27",
                "value": 61
            }, {
                "date": "2012-09-28",
                "value": 66
            }, {
                "date": "2012-09-29",
                "value": 69
            }, {
                "date": "2012-09-30",
                "value": 71
            }, {
                "date": "2012-10-01",
                "value": 67
            }, {
                "date": "2012-10-02",
                "value": 63
            }, {
                "date": "2012-10-03",
                "value": 46
            }, {
                "date": "2012-10-04",
                "value": 32
            }, {
                "date": "2012-10-05",
                "value": 21
            }, {
                "date": "2012-10-06",
                "value": 18
            }, {
                "date": "2012-10-07",
                "value": 21
            }, {
                "date": "2012-10-08",
                "value": 28
            }, {
                "date": "2012-10-09",
                "value": 27
            }, {
                "date": "2012-10-10",
                "value": 36
            }, {
                "date": "2012-10-11",
                "value": 33
            }, {
                "date": "2012-10-12",
                "value": 31
            }, {
                "date": "2012-10-13",
                "value": 30
            }, {
                "date": "2012-10-14",
                "value": 34
            }, {
                "date": "2012-10-15",
                "value": 38
            }, {
                "date": "2012-10-16",
                "value": 37
            }, {
                "date": "2012-10-17",
                "value": 44
            }, {
                "date": "2012-10-18",
                "value": 49
            }, {
                "date": "2012-10-19",
                "value": 53
            }, {
                "date": "2012-10-20",
                "value": 57
            }, {
                "date": "2012-10-21",
                "value": 60
            }, {
                "date": "2012-10-22",
                "value": 61
            }, {
                "date": "2012-10-23",
                "value": 69
            }, {
                "date": "2012-10-24",
                "value": 67
            }, {
                "date": "2012-10-25",
                "value": 72
            }, {
                "date": "2012-10-26",
                "value": 77
            }, {
                "date": "2012-10-27",
                "value": 75
            }, {
                "date": "2012-10-28",
                "value": 70
            }, {
                "date": "2012-10-29",
                "value": 72
            }, {
                "date": "2012-10-30",
                "value": 70
            }, {
                "date": "2012-10-31",
                "value": 72
            }, {
                "date": "2012-11-01",
                "value": 73
            }, {
                "date": "2012-11-02",
                "value": 67
            }, {
                "date": "2012-11-03",
                "value": 68
            }, {
                "date": "2012-11-04",
                "value": 65
            }, {
                "date": "2012-11-05",
                "value": 71
            }, {
                "date": "2012-11-06",
                "value": 75
            }, {
                "date": "2012-11-07",
                "value": 74
            }, {
                "date": "2012-11-08",
                "value": 71
            }, {
                "date": "2012-11-09",
                "value": 76
            }, {
                "date": "2012-11-10",
                "value": 77
            }, {
                "date": "2012-11-11",
                "value": 81
            }, {
                "date": "2012-11-12",
                "value": 83
            }, {
                "date": "2012-11-13",
                "value": 80
            }, {
                "date": "2012-11-14",
                "value": 81
            }, {
                "date": "2012-11-15",
                "value": 87
            }, {
                "date": "2012-11-16",
                "value": 82
            }, {
                "date": "2012-11-17",
                "value": 86
            }, {
                "date": "2012-11-18",
                "value": 80
            }, {
                "date": "2012-11-19",
                "value": 87
            }, {
                "date": "2012-11-20",
                "value": 83
            }, {
                "date": "2012-11-21",
                "value": 85
            }, {
                "date": "2012-11-22",
                "value": 84
            }, {
                "date": "2012-11-23",
                "value": 82
            }, {
                "date": "2012-11-24",
                "value": 73
            }, {
                "date": "2012-11-25",
                "value": 71
            }, {
                "date": "2012-11-26",
                "value": 75
            }, {
                "date": "2012-11-27",
                "value": 79
            }, {
                "date": "2012-11-28",
                "value": 70
            }, {
                "date": "2012-11-29",
                "value": 73
            }, {
                "date": "2012-11-30",
                "value": 61
            }, {
                "date": "2012-12-01",
                "value": 62
            }, {
                "date": "2012-12-02",
                "value": 66
            }, {
                "date": "2012-12-03",
                "value": 65
            }, {
                "date": "2012-12-04",
                "value": 73
            }, {
                "date": "2012-12-05",
                "value": 79
            }, {
                "date": "2012-12-06",
                "value": 78
            }, {
                "date": "2012-12-07",
                "value": 78
            }, {
                "date": "2012-12-08",
                "value": 78
            }, {
                "date": "2012-12-09",
                "value": 74
            }, {
                "date": "2012-12-10",
                "value": 73
            }, {
                "date": "2012-12-11",
                "value": 75
            }, {
                "date": "2012-12-12",
                "value": 70
            }, {
                "date": "2012-12-13",
                "value": 77
            }, {
                "date": "2012-12-14",
                "value": 67
            }, {
                "date": "2012-12-15",
                "value": 62
            }, {
                "date": "2012-12-16",
                "value": 64
            }, {
                "date": "2012-12-17",
                "value": 61
            }, {
                "date": "2012-12-18",
                "value": 59
            }, {
                "date": "2012-12-19",
                "value": 53
            }, {
                "date": "2012-12-20",
                "value": 54
            }, {
                "date": "2012-12-21",
                "value": 56
            }, {
                "date": "2012-12-22",
                "value": 59
            }, {
                "date": "2012-12-23",
                "value": 58
            }, {
                "date": "2012-12-24",
                "value": 55
            }, {
                "date": "2012-12-25",
                "value": 52
            }, {
                "date": "2012-12-26",
                "value": 54
            }, {
                "date": "2012-12-27",
                "value": 50
            }, {
                "date": "2012-12-28",
                "value": 50
            }, {
                "date": "2012-12-29",
                "value": 51
            }, {
                "date": "2012-12-30",
                "value": 52
            }, {
                "date": "2012-12-31",
                "value": 58
            }, {
                "date": "2013-01-01",
                "value": 60
            }, {
                "date": "2013-01-02",
                "value": 67
            }, {
                "date": "2013-01-03",
                "value": 64
            }, {
                "date": "2013-01-04",
                "value": 66
            }, {
                "date": "2013-01-05",
                "value": 60
            }, {
                "date": "2013-01-06",
                "value": 63
            }, {
                "date": "2013-01-07",
                "value": 61
            }, {
                "date": "2013-01-08",
                "value": 60
            }, {
                "date": "2013-01-09",
                "value": 65
            }, {
                "date": "2013-01-10",
                "value": 75
            }, {
                "date": "2013-01-11",
                "value": 77
            }, {
                "date": "2013-01-12",
                "value": 78
            }, {
                "date": "2013-01-13",
                "value": 70
            }, {
                "date": "2013-01-14",
                "value": 70
            }, {
                "date": "2013-01-15",
                "value": 73
            }, {
                "date": "2013-01-16",
                "value": 71
            }, {
                "date": "2013-01-17",
                "value": 74
            }, {
                "date": "2013-01-18",
                "value": 78
            }, {
                "date": "2013-01-19",
                "value": 85
            }, {
                "date": "2013-01-20",
                "value": 82
            }, {
                "date": "2013-01-21",
                "value": 83
            }, {
                "date": "2013-01-22",
                "value": 88
            }, {
                "date": "2013-01-23",
                "value": 85
            }, {
                "date": "2013-01-24",
                "value": 85
            }, {
                "date": "2013-01-25",
                "value": 80
            }, {
                "date": "2013-01-26",
                "value": 87
            }, {
                "date": "2013-01-27",
                "value": 84
            }, {
                "date": "2013-01-28",
                "value": 83
            }, {
                "date": "2013-01-29",
                "value": 84
            }, {
                "date": "2013-01-30",
                "value": 81
            }];

// Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

// Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

// Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

// Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";

// Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        chart.events.on("ready", function () {
            dateAxis.zoom({start: 0.79, end: 1});
        });
    }
    var handleMonthsAmChart3 = function () {
        am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
        var chart = am4core.create("months-chart", am4charts.XYChart);

// Add data
        chart.data = JSON.parse(config.months_income);


// Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
//        var dateAxis = chart.xAxes.push(new am4charts.MonthAxis());
//        var valueAxis = chart.yAxes.push(new am4charts.IncomeAxis());

// Create series
        var series = chart.series.push(new am4charts.LineSeries());
//        series.dataFields.incomeY = "income";
//        series.dataFields.monthX = "month";
        series.dataFields.valueY = "income";
        series.dataFields.dateX = "month";
        series.tooltipText = "{income}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

// Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

// Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

// Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";

// Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

        chart.events.on("ready", function () {
            dateAxis.zoom({start: 0.79, end: 1});
        });
    }
    var handleBranchesSearch = function () {
        var branches = $('#branch').select2({
            placeholder: lang.search,
        });


    }
    var handleChangeBranch = function () {
        $('#branch').on('change', function () {
            My.blockUI({
                target: $('#branch-plan-calendar'),
            });
            setTimeout(function () {
                fetchBrancPlanData($(this));
            }, 1000);

        });

    }

    var fetchBrancPlanData = function () {
        console.log($('#branch').val());
        var action = config.ajax_url + '/get-branch-plan-rooms';


        $.ajax({
            url: action,
            data: {branch: $('#branch').val()},
            async: false,
            success: function (data) {
                console.log(data);

                if (data.type == 'success') {
                    My.unblockUI('#branch-plan-calendar');
                    if (typeof branchPlanCalendar != 'undefined') {
                        var events = {
                            url: config.ajax_url + '/get-branch-plan-groups',
                            type: 'get',
                            data: {
                                branch: $('#branch').val()
                            }
                        }
                        $('#branch-plan-calendar').fullCalendar('option', {
                            resources: data.data,
                            validRange: {
                                start: My.formatDate(),
                                end: My.addDays(new Date(My.formatDate()), 1)
                            },
                        });
                        $('#branch-plan-calendar').fullCalendar('removeEventSource', events);
                        $('#branch-plan-calendar').fullCalendar('addEventSource', events);
                        $('#branch-plan-calendar').fullCalendar('refetchEvents');
                        $('#branch-plan-calendar').fullCalendar('refetchResources');
                    } else {
                        //console.log(data.data);
                        handleCalender(data.data, {
                            barnch: $('#branch').val(),
                            date_from: My.formatDate()
                        });
                    }




                } else {
                    if (typeof data.message != "undefined") {
                        My.toast({message: data.message, type: "error"});
                    }

                }

            },
            error: function (xhr, textStatus, errorThrown) {
                My.ajax_error_message(xhr, $(this));

            },
            dataType: "JSON",
            type: "get"
        });

    }
    var handleCalender = function (rooms, obj) {
        branchPlanCalendar = $('#branch-plan-calendar').fullCalendar({
            height: 450,
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            defaultView: 'timelineDay',
            groupByResource: true,
            resources: rooms,
            minTime: config.time_slot_from,
            maxTime: config.time_slot_to,
            validRange: {
                start: obj.date_from,
                end: My.addDays(new Date(obj.date_from), 1)
            },
            //events: config.ajax_url + '/get-branch-plan-groups',
            events: {
                url: config.ajax_url + '/get-branch-plan-groups',
                type: 'get',
                data: {
                    branch: obj.branch
                },
                error: function () {
                    alert('there was an error while fetching events!');
                }
            },
            eventRender: function (event, element, view) {
                console.log(event);

                 Main.CalendarGroupHtml(event, element, view);
            },
//            eventAfterRender: function (event, element, view) {
//                $(element).css('width', '50px');
//            }
        });
//        $('#branch-plan-calendsar').fullCalendar({
//            header: {
//                left: 'today prev,next',
//                center: 'title',
//                right: ''
//            },
//            defaultView: 'basicWeek',
//            displayEventTime: false,
////      resourceColumns: [
////        {
////          labelText: 'students',
////          field: 'title'
////        }
////      ],
//            validRange: {
//                start: group.start_date,
//                end: group.end_date
//            },
//            events: group.sessions,
//            //resources: group.students
//        });
//        $('#sessionss-calendar').fullCalendar({
//            defaultView: 'agendaFourDay',
//            validRange: {
//                start: group.start_date,
//                end: group.end_date
//            },
//            groupByResource: true,
//            header: {
//                left: 'prev,next',
//                center: 'title',
//                right: 'agendaDay,agendaFourDay'
//            },
//            displayEventTime: false,
//            views: {
//                agendaFourDay: {
//                    type: 'agenda',
//                    duration: {days: 4},
//
//                }
//            },
//            events: group.sessions,
//            //resources: group.students,
//        });
//        $('#sessions-calendar').fullCalendar({
//            dayRender: function (date, cell) {
//                console.log(date.format('MM/DD/YYYY'));
//                if (date.format('YYYY-MM-DD') == '2018-03-01') {
//                    cell.css("background-color", "red");
//                }
//
//            },
//            defaultView: 'agendaFourDay',
//            validRange: {
//                start: group.start_date,
//                end: group.end_date
//            },
//            header: {
////            left: 'prev,next today',
//                left: 'prev,next today',
//                center: 'title',
//                right: '',
////            allDay: false
//            },
//            navLinks: false, // can click day/week names to navigate views
//            editable: false,
//            eventLimit: true, // allow "more" link when too many events
//            views: {
//                month: {// name of view
//                    titleFormat: 'YYYY, MM, DD',
//                }
//            },
//            events: group.sessions
//        });
        //console.log(group);
    }
    var handleFirstMonthGroupsCalender = function (rooms, obj) {
        var date = new Date();
        var first_day = new Date(date.getFullYear(), date.getMonth(), 1);
        var last_day = new Date(date.getFullYear(), date.getMonth(), 0);
        FirstMonthCalendar = $('#appointments-month-calendar').fullCalendar({
            eventLimit: 1,
//            eventLimitText: "Something",
            height: 450,
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            defaultView: 'month',
            groupByResource: true,
            //resources: JSON.parse(config.month_days),
            minTime: config.time_slot_from,
            maxTime: config.time_slot_to,
            validRange: {
                start: first_day,
                end: last_day
            },
            views: {
                month: {// name of view
                    titleFormat: 'MMMM YYYY'
                            // other view-specific options here
                }
            },
            events: {
                url: config.ajax_url + '/get-month-groups',
                type: 'get',
                data: {
                    month: 'current_month',
                },
                error: function () {
                    alert('there was an error while fetching events!');
                }
            },
            //events: config.ajax_url + '/get-month-groups',

            eventRender: function (event, element, view) {

                  Main.CalendarGroupHtml(event, element, view);
            },
            eventClick: function (event, jsEvent, view) {
                if (event.url) {
                    window.open(event.url);
                    return false;
                }
            }
        });

    }
    var handleSecondMonthGroupsCalender = function (rooms, obj) {
        var date = new Date();
        var first_day = new Date(date.getFullYear(), date.getMonth() + 1, 1);
        var last_day = new Date(date.getFullYear(), date.getMonth() + 2, 0);
        console.log('first_day' + first_day);
        console.log('last_day' + last_day);
        FirstMonthCalendar = $('#second-month-calendar').fullCalendar({
            eventLimit: 1,
//            eventLimitText: "Something",
            height: 450,
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            defaultView: 'month',
            groupByResource: true,
            //resources: JSON.parse(config.month_days),
            minTime: config.time_slot_from,
            maxTime: config.time_slot_to,
            validRange: {
                start: first_day,
                end: last_day
            },
            views: {
                month: {// name of view
                    titleFormat: 'MMMM YYYY'
                            // other view-specific options here
                }
            },
            events: {
                url: config.ajax_url + '/get-month-groups',
                type: 'get',
                data: {
                    month: 'next_month',
                },
                error: function () {
                    alert('there was an error while fetching events!');
                }
            },

            eventRender: function (event, element, view) {

                Main.CalendarGroupHtml(event, element, view);
            },
            eventClick: function (event, jsEvent, view) {
                if (event.url) {
                    window.open(event.url);
                    return false;
                }
            }
        });

    }
    var handleThirdMonthGroupsCalender = function (rooms, obj) {
        var date = new Date();
        var first_day = new Date(date.getFullYear(), date.getMonth() + 2, 1);
        var last_day = new Date(date.getFullYear(), date.getMonth() + 3, 0);
        console.log('first_day' + first_day);
        console.log('last_day' + last_day);
        FirstMonthCalendar = $('#third-month-calendar').fullCalendar({
            eventLimit: 1,
//            eventLimitText: "Something",
            height: 450,
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            defaultView: 'month',
            groupByResource: true,
            //resources: JSON.parse(config.month_days),
            minTime: config.time_slot_from,
            maxTime: config.time_slot_to,
            validRange: {
                start: first_day,
                end: last_day
            },
            views: {
                month: {// name of view
                    titleFormat: 'MMMM YYYY'
                            // other view-specific options here
                }
            },
            events: {
                url: config.ajax_url + '/get-month-groups',
                type: 'get',
                data: {
                    month: 'third_month',
                },
                error: function () {
                    alert('there was an error while fetching events!');
                }
            },

            eventRender: function (event, element, view) {
                console.log(event);

                 Main.CalendarGroupHtml(event, element, view);
                element.popover({
                    trigger: "click",
                    container: $(element).closest('.fc-view-container')
                });
            },
            eventClick: function (event, jsEvent, view) {
                if (event.url) {
                    window.open(event.url);
                    return false;
                }
            }
        });

    }
    var handleMonthGroupsCalender2 = function (events) {


        $('#first-month-calendar').fullCalendar({

            eventRender: function (event, element, view) {
                console.log(event);
//                var html = '<p class="text-center bold" style="color:#000;font-size:16px;">';
//                html += event.session_number + "<br>";
//                html += event.title + "<br>";
//                html += event.feedback_title + "<br>";
//                html += "</p>";
//                if (event.can_edit) {
//                    html += "<div class='text-center'><a data-session='" + event.session_date + "'  data-id='" + event.id + "' data-feedback='" + event.feedback_id + "' data-employee='" + event.employee_id + "' onclick='CoursesGroups.edit_session(this);return false;' class='btn btn-sm btn-info'><i class='fa fa-edit'></i></a></div>";
//                }
//                element.find('.fc-content').html(html);
            },
            validRange: {
                start: group.start_date,
                end: My.addDays(new Date(group.end_date), 1)
            },
            header: {
//            left: 'prev,next today',
                left: 'prev,next today',
                center: 'title',
                right: '',
//            allDay: false
            },
            navLinks: false, // can click day/week names to navigate views
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            views: {
                month: {// name of view
                    titleFormat: 'MMMM YYYY',
                }
            },
            events: {
                url: config.ajax_url + '/get-month-groups',
                type: 'get',
                data: {

                },
                error: function () {
                    alert('there was an error while fetching events!');
                }
            }
        });


    }



    return{
        init: function () {
            init();
        },

    };
}();
$(document).ready(function () {
    Dashboard.init();
    //Dashboard.initCharts();
});