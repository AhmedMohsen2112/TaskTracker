@extends('layouts.admin')

@section('pageTitle',_lang('app.settings'))
@push('css_plugins')
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/bootstrap-summernote/summernote.css"/>
@endpush
@push('js_plugins')
<script type="text/javascript" src="{{admin_plugins()}}/bootstrap-summernote/summernote.min.js"></script>
@endpush
@section('breadcrumb')

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{route('admin.dashboard')}}">{{_lang('app.dashboard')}}</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{route('admin.settings.index')}}">{{_lang('app.settings')}}</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span>{{_lang('app.'.$result->name)}}</span>
        </li>
    </ul>
</div>
@endsection

@push('js_custom')

<script src="{{admin_scripts()}}/settings.js" type="text/javascript"></script>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
             <form role="form"  id="editSettingsForm"  enctype="multipart/form-data">
            <input type="hidden" name="setting[slug]" value="{{$result->slug}}">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <span class="caption-subject bold uppercase">{{_lang('app.details')}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle green submit-form" href="javascript:;">
                            {{_lang('app.save')}}
                        </a>
                    </div>
                </div>

                <div class="portlet-body">

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group form-md-line-input">
                                    <label for="content">{{_lang('app.content') }}</label>
                                    <input type="hidden" name="setting[value][content_ar]">
                                    <div class="summernote" id="content_ar">{!! isset($result->value->content_ar) ? $result->value->content_ar :'' !!}</div>
                                    <span class="help-block"></span>
                                </div>
                        
                            </div>


                        </div>



                    </div>











                </div>
            </div>
        </form>
    </div>

</div>
<script>
var new_lang = {

};
var new_config = {
    page: "{{$result->slug}}",
};
</script>

@endsection