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
            <span>{{_lang('app.slider')}}</span>
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
            <input type="hidden" name="setting[name]" value="{{$result->slug}}">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <span class="caption-subject bold uppercase">{{_lang('app.details')}}</span>
                    </div>
                    <div class="actions">
                        <!--                        <a class="btn btn-circle green submit-form" href="javascript:;">
                                                    {{_lang('app.save')}}
                                                </a>-->
                    </div>
                </div>

                <div class="portlet-body">

                    <div class="form-body">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="col-sm-12" style="margin-top: 40%;">
                                    <div class="form-group">
                                        @if(isset($result->value['offer_first'])&&isset($result->value['offer_first'][0]))
                                        <div class="image_box" style="height:220px;">
                                            <img src="{{url('public/uploads/settings/'.$result->value['offer_first'][0]->file_name)}}" class="" width="100%" height="100%">
                                            <div class="upload-overlay">
                                                <div class="icon">
                                                    <a href="#" data-id="{{$result->value['offer_first'][0]->id}}" onclick="Attachment.delete(this);return false;" class="icon-delete" title=""><i class="fa fa-remove"></i></a>
                                                    <a href="{{url('public/uploads/settings/'.$result->value['offer_first'][0]->file_name)}}" target="_blank" class="icon-view" title=""><i class="fa fa-eye"></i></a>
                                                    <a href="#" data-id="{{$result->value['offer_first'][0]->id}}"  onclick="Attachment.edit(this);return false;" class="icon-edit" title=""><i class="fa fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="image_box" style="height: 220px">
                                            <img src="{{url('no-image.jpg')}}" width="100%" height="100%"  class="upload-image" />
                                        </div>
                                        @endif
                                        <input type="file" class="upload" name="offer_first"  style="display:none;">     
                                        <span class="help-block"></span>  
                                        <div class="progress" style="display: none;">
                                            <div class="progress-bar" id="bar" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                <div id="percent"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @if(isset($result->value['offer_second'])&&isset($result->value['offer_second'][0]))
                                        <div class="image_box" style="height:220px;">
                                            <img src="{{url('public/uploads/settings/'.$result->value['offer_second'][0]->file_name)}}" class="" width="100%" height="100%">
                                            <div class="upload-overlay">
                                                <div class="icon">
                                                    <a href="#" data-id="{{$result->value['offer_second'][0]->id}}" onclick="Attachment.delete(this);return false;" class="icon-delete" title=""><i class="fa fa-remove"></i></a>
                                                    <a href="{{url('public/uploads/settings/'.$result->value['offer_second'][0]->file_name)}}" target="_blank" class="icon-view" title=""><i class="fa fa-eye"></i></a>
                                                    <a href="#" data-id="{{$result->value['offer_second'][0]->id}}"  onclick="Attachment.edit(this);return false;" class="icon-edit" title=""><i class="fa fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="image_box" style="height: 220px">
                                            <img src="{{url('no-image.jpg')}}" width="100%" height="100%"  class="upload-image" />
                                        </div>
                                        @endif
                                        <input type="file" class="upload" name="offer_second"  style="display:none;">     
                                        <span class="help-block"></span>  
                                        <div class="progress" style="display: none;">
                                            <div class="progress-bar" id="bar" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                <div id="percent"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                       @if(isset($result->value['offer_third'])&&isset($result->value['offer_third'][0]))
                                        <div class="image_box" style="height:220px;">
                                            <img src="{{url('public/uploads/settings/'.$result->value['offer_third'][0]->file_name)}}" class="" width="100%" height="100%">
                                            <div class="upload-overlay">
                                                <div class="icon">
                                                    <a href="#" data-id="{{$result->value['offer_third'][0]->id}}" onclick="Attachment.delete(this);return false;" class="icon-delete" title=""><i class="fa fa-remove"></i></a>
                                                    <a href="{{url('public/uploads/settings/'.$result->value['offer_third'][0]->file_name)}}" target="_blank" class="icon-view" title=""><i class="fa fa-eye"></i></a>
                                                    <a href="#" data-id="{{$result->value['offer_third'][0]->id}}"  onclick="Attachment.edit(this);return false;" class="icon-edit" title=""><i class="fa fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="image_box" style="height: 220px">
                                            <img src="{{url('no-image.jpg')}}" width="100%" height="100%"  class="upload-image" />
                                        </div>
                                        @endif
                                        <input type="file" class="upload" name="offer_third"  style="display:none;">     
                                        <span class="help-block"></span>  
                                        <div class="progress" style="display: none;">
                                            <div class="progress-bar" id="bar" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                <div id="percent"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @if(isset($result->value['offer_forth'])&&isset($result->value['offer_forth'][0]))
                                        <div class="image_box" style="height:220px;">
                                            <img src="{{url('public/uploads/settings/'.$result->value['offer_forth'][0]->file_name)}}" class="" width="100%" height="100%">
                                            <div class="upload-overlay">
                                                <div class="icon">
                                                    <a href="#" data-id="{{$result->value['offer_forth'][0]->id}}" onclick="Attachment.delete(this);return false;" class="icon-delete" title=""><i class="fa fa-remove"></i></a>
                                                    <a href="{{url('public/uploads/settings/'.$result->value['offer_forth'][0]->file_name)}}" target="_blank" class="icon-view" title=""><i class="fa fa-eye"></i></a>
                                                    <a href="#" data-id="{{$result->value['offer_forth'][0]->id}}"  onclick="Attachment.edit(this);return false;" class="icon-edit" title=""><i class="fa fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="image_box" style="height: 220px">
                                            <img src="{{url('no-image.jpg')}}" width="100%" height="100%"  class="upload-image" />
                                        </div>
                                        @endif
                                        <input type="file" class="upload" name="offer_forth"  style="display:none;">     
                                        <span class="help-block"></span>  
                                        <div class="progress" style="display: none;">
                                            <div class="progress-bar" id="bar" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                <div id="percent"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                       @if(isset($result->value['offer_five'])&&isset($result->value['offer_five'][0]))
                                        <div class="image_box" style="height:220px;">
                                            <img src="{{url('public/uploads/settings/'.$result->value['offer_five'][0]->file_name)}}" class="" width="100%" height="100%">
                                            <div class="upload-overlay">
                                                <div class="icon">
                                                    <a href="#" data-id="{{$result->value['offer_five'][0]->id}}" onclick="Attachment.delete(this);return false;" class="icon-delete" title=""><i class="fa fa-remove"></i></a>
                                                    <a href="{{url('public/uploads/settings/'.$result->value['offer_five'][0]->file_name)}}" target="_blank" class="icon-view" title=""><i class="fa fa-eye"></i></a>
                                                    <a href="#" data-id="{{$result->value['offer_five'][0]->id}}"  onclick="Attachment.edit(this);return false;" class="icon-edit" title=""><i class="fa fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="image_box" style="height: 220px">
                                            <img src="{{url('no-image.jpg')}}" width="100%" height="100%"  class="upload-image" />
                                        </div>
                                        @endif
                                        <input type="file" class="upload" name="offer_five"  style="display:none;">     
                                        <span class="help-block"></span>  
                                        <div class="progress" style="display: none;">
                                            <div class="progress-bar" id="bar" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                <div id="percent"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                              <div class="col-sm-12">
                                    <div class="form-group">
                                       @if(isset($result->value['offer_six'])&&isset($result->value['offer_five'][0]))
                                        <div class="image_box" style="height:100px;">
                                            <img src="{{url('public/uploads/settings/'.$result->value['offer_six'][0]->file_name)}}" class="" width="100%" height="100%">
                                            <div class="upload-overlay">
                                                <div class="icon">
                                                    <a href="#" data-id="{{$result->value['offer_six'][0]->id}}" onclick="Attachment.delete(this);return false;" class="icon-delete" title=""><i class="fa fa-remove"></i></a>
                                                    <a href="{{url('public/uploads/settings/'.$result->value['offer_six'][0]->file_name)}}" target="_blank" class="icon-view" title=""><i class="fa fa-eye"></i></a>
                                                    <a href="#" data-id="{{$result->value['offer_six'][0]->id}}"  onclick="Attachment.edit(this);return false;" class="icon-edit" title=""><i class="fa fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="image_box" style="height: 130px">
                                            <img src="{{url('no-image.jpg')}}" width="100%" height="100%"  class="upload-image" />
                                        </div>
                                        @endif
                                        <input type="file" class="upload" name="offer_six"  style="display:none;">     
                                        <span class="help-block"></span>  
                                        <div class="progress" style="display: none;">
                                            <div class="progress-bar" id="bar" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                <div id="percent"></div>
                                            </div>
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
    page:"{{$result->slug}}",
    attachment_id: "{{$result->id}}",
    class_name: "{{$class_name}}",
    upload_path: config.public_path + '/uploads/settings/'
};
</script>

@endsection