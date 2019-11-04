@extends('layouts.admin')
@section('pageTitle', t('dashboard'))
@section('breadcrumb')


@endsection
@push('css_custom')
<link rel="stylesheet" type="text/css" href="{{admin_css()}}/tasks.css"/>
@endpush
@push('css_plugins')
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/fullcalendar/fullcalendar.min.css"/>
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/fullcalendar/scheduler.min.css"/>
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<!--<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>-->
@endpush
@push('js_plugins')
<script type="text/javascript" src="{{admin_plugins()}}/select2/select2.min.js"></script>
<script type="text/javascript" src="{{admin_plugins()}}/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
<script type="text/javascript" src="{{admin_plugins()}}/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="{{admin_plugins()}}/fullcalendar/fullcalendar.js"></script>
<script type="text/javascript" src="{{admin_plugins()}}/fullcalendar/scheduler.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
@endpush

@push('js_custom')
<script src="{{admin_scripts()}}/dashboard.js" type="text/javascript"></script>

@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <span class="caption-subject bold uppercase">{{t('recent_boards')}}</span>

                </div>
            </div>

            <div class="portlet-body">
                  <ul class="list-group" id="boards-content">
                @forelse($boards as $one)
                <li class="list-group-item board-item" id="board{{$one->id}}">
                    {{$one->title}} 
                    <a class="btn btn-xs btn-warning pull-right" href="{{route('admin.boards.view',['id'=>$one->id])}}">{{t('view')}}</a>
                </li>
                @empty
                <li class="list-group-item text-center">{{t('no_boards')}}</li>
                @endforelse

            </ul>
                <div class="btn-arrow-link pull-right">
                    <a href="{{route('admin.boards.index')}}">{{t('See All Records')}}</a>
                    <i class="icon-arrow-right"></i>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>


    </div>
</div>


<script>
var new_lang = {

};
var new_config = {
};
</script>
@endsection