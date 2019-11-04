@extends('layouts.admin')

@section('pageTitle', t('notifications'))

@section('breadcrumb')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{route('admin.dashboard')}}">{{t('dashboard')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{t('notifications')}}</span>
    </li>
</ul>

@endsection

@push('js_custom')
<script src="{{admin_scripts()}}/notifications.js" type="text/javascript"></script>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <span class="caption-subject bold uppercase">{{t('list')}}</span>
                </div>
                <div class="actions">
                    <!--                      <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                                            </a>-->
                </div>
            </div>

            <div class="portlet-body">


                <table class = "table table-bordered table-checkable order-column dataTable no-footer">
                    <thead>
                        <tr>
                            <th>{{t('message')}}</th>
                            <th>{{t('time')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>



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