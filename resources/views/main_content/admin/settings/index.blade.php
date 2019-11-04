@extends('layouts.admin')

@section('pageTitle',_lang('app.settings'))

@section('breadcrumb')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{route('admin.dashboard')}}">{{t('dashboard')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{t('settings')}}</span>
    </li>
</ul>

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <span class="caption-subject bold uppercase">{{_lang('app.list')}}</span>
                    </div>
            
                </div>

                <div class="portlet-body">

                    <table class = "table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2">{{_lang('app.title')}}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settings as $one)
                            <tr>
                                <td>{{_lang('app.'.$one->name)}}</td>
                                <td>
                                    <a href="{{route('admin.settings.edit', ['id' => $one->slug])}}" class="btn btn-xs btn-primary"><i class="icon-cog5 position-left"></i>{{_lang('app.configure')}}</a>
                                </td>
                            </tr>
                            @endforeach

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
    page: "index",
};
</script>

@endsection