@extends('layouts.admin')

@section('pageTitle',t('settings'))

@section('breadcrumb')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{route('admin.dashboard')}}">{{t('dashboard')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{route('admin.settings.index')}}">{{t('settings')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{t(''.$result->name)}}</span>
    </li>
</ul>

@endsection

@push('js_custom')

<script src="{{admin_scripts()}}/settings.js" type="text/javascript"></script>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <form role="form"  id="editSettingsForm"  enctype="multipart/form-data">
            <input type="hidden" id="id" name="setting[slug]" value="{{$result->slug}}">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <span class="caption-subject bold uppercase">{{t('details')}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle green submit-form" href="javascript:;">
                            {{t('save')}}
                        </a>
                    </div>
                </div>

                <div class="portlet-body">

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="phone" name="setting[value][phone]" value="{{ isset($result->value->phone) ? $result->value->phone :'' }}">
                                    <label for="phone">{{t('phone') }}</label>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="phone" name="setting[value][whatsapp]" value="{{ isset($result->value->whatsapp) ? $result->value->whatsapp :'' }}">
                                    <label for="whatsapp">{{t('whatsapp') }}</label>
                                    <span class="help-block"></span>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="email" name="setting[value][email]" value="{{ isset($result->value->email) ? $result->value->email :'' }}">
                                    <label for="email">{{t('email') }}</label>
                                    <span class="help-block"></span>
                                </div>
                      
                      
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="email" name="setting[value][twitter_url]" value="{{ isset($result->value->twitter_url) ? $result->value->twitter_url :'' }}">
                                    <label for="twitter_url">{{t('twitter_url') }}</label>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="email" name="setting[value][facebook_url]" value="{{ isset($result->value->facebook_url) ? $result->value->facebook_url :'' }}">
                                    <label for="facebook_url">{{t('facebook_url') }}</label>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="email" name="setting[value][youtube_url]" value="{{ isset($result->value->youtube_url) ? $result->value->youtube_url :'' }}">
                                    <label for="youtube_url">{{t('youtube_url') }}</label>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="email" name="setting[value][instagram_url]" value="{{ isset($result->value->instagram_url) ? $result->value->instagram_url :'' }}">
                                    <label for="instagram_url">{{t('instagram_url') }}</label>
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