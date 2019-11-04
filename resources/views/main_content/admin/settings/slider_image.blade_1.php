@extends('layouts.admin')

@section('pageTitle',_lang('app.settings'))

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
<script src="{{admin_scripts()}}/attachment.js" type="text/javascript"></script>
<script src="{{admin_scripts()}}/settings.js" type="text/javascript"></script>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <form role="form"  id="editSettingsForm"  enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="{{$result->name}}">
            <input type="hidden" name="setting[name]" value="{{$result->name}}">
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
                            <div style="border: 2px dashed #ccc; padding: 20px;">
                                <div class="form-group">
                                    <div class="image_box text-center">
                                        <a class="btn btn-primary upload-image"><i class="fa fa-plus"></i> {{t('upload')}}</a>
                                    </div>
                                    <input type="file" class="upload" name="slider_image" multiple style="display:none;">     
                                    <span class="help-block"></span>  
                                    <div class="progress" style="display: none;">
                                        <div class="progress-bar" id="bar" role="progressbar" aria-valuenow="70"
                                             aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            <div id="percent"></div>
                                        </div>
                                    </div>
                                    <div class="uploaded-images row">
                                        @foreach($result->value as $key=> $one)
                                        <div class="image_item">
                                            <img src="{{url('public/uploads/settings/'.$one)}}" class="" width="120px" height="120px">
                                            <div class="upload-overlay">
                                                <div class="icon">
                                                    <a href="#" data-id="{{$key}}" data-multiple="true" onclick="Attachment.delete(this);return false;" class="icon-delete" title=""><i class="fa fa-remove"></i></a>
                                                    <a href="{{url('public/uploads/settings/'.$one)}}" target="_blank" class="icon-view" title=""><i class="fa fa-eye"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
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
        upload_url: "{{route('admin.settings.upload')}}",
    };
</script>

@endsection