@extends('layouts.admin')

@section('pageTitle',t('profile'))
@section('breadcrumb')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{route('admin.dashboard')}}">{{t('dashboard')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{t('profile')}}</span>
    </li>
</ul>

@endsection

@push('js_custom')
<script src="{{admin_scripts()}}/profile.js" type="text/javascript"></script>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <form role="form"  id="addEditProfileForm"  enctype="multipart/form-data">

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <span class="caption-subject bold uppercase">{{t('account_settings')}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle green submit-form" href="javascript:;">
                            {{t('save')}}
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                        </a>
                    </div>
                </div>

                <div class="portlet-body">

                    <div class="form-body">

                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="name" name="name" value="{{$User->name}}">
                            <label for="name">{{t('name')}}</label>
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="username" name="username" value="{{$User->username}}">
                            <label for="username">{{t('username')}}</label>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="email" name="email" value="{{$User->email}}">
                            <label for="email">{{t('email')}}</label>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="phone" name="phone" value="{{$User->phone}}">
                            <label for="phone">{{t('phone')}}</label>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="password" class="form-control" id="password" name="password">
                            <label for="password">{{t('password')}}</label>
                            <span class="help-block"></span>
                        </div>



                    </div>











                </div>
            </div>
        </form>
    </div>

</div>

@endsection