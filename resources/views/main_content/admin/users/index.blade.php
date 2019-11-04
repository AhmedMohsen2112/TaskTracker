@extends('layouts.admin')

@section('pageTitle', t('users'))
@section('breadcrumb')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{route('admin.dashboard')}}">{{t('dashboard')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{t('users')}}</span>
    </li>
</ul>

@endsection


@push('js_custom')
<script src="{{admin_scripts()}}/users.js" type="text/javascript"></script>
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
                    <!--                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                                        </a>-->
                </div>
            </div>

            <div class="portlet-body">


                <table class = "table table-bordered table-checkable order-column dataTable no-footer">
                    <thead>
                        <tr>
                            <th>{{t('username')}}</th>
                            <th>{{t('phone')}}</th>
                            <th>{{t('email')}}</th>
                            <th>{{t('status')}}</th>
                            <th>{{t('created_at')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>



            </div>
        </div>
    </div>
   <div class="col-md-12">
        <form role="form"  id="addEditUsersForm"  enctype="multipart/form-data">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <!--                    <div class="caption font-red-sunglo">
                                            <span class="caption-subject bold uppercase">{{t('details')}}</span>
                                        </div>-->
                    <div class="actions">
                        <a class="btn btn-circle btn-default" href="javascript:Users.empty();">
                            {{t('new')}}
                        </a>
                        <a class="btn btn-circle green submit-form" href="javascript:;">
                            {{t('save')}}
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                        </a>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">{{ t('user_info') }}</legend>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="{{t('name')}}">
                                            <label for="name">{{t('name')}}</label>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <input type="text" class="form-control" id="username" name="username" placeholder="{{t('username')}}">
                                            <label for="username">{{t('username')}}</label>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <input type="text" class="form-control" id="email" name="email" placeholder="{{t('email')}}">
                                            <label for="email">{{t('email')}}</label>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-md-line-input">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="{{t('phone')}}">
                                            <label for="phone">{{t('phone')}}</label>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                         <div class="form-group form-md-line-input">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="{{t('password')}}">
                                            <label for="password">{{t('password')}}</label>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

 
                                    
                                    <div class="col-md-4">
                                        <div class = "form-group form-md-line-input">
                                            <select class = "form-control edited" id = "active" name = "active">
                                                <option value = "1">{{t('active')}}</option>
                                                <option value = "0">{{t('not_active')}}</option>
                                            </select>
                                            <label for = "status">{{t('status')}}</label>
                                            <span class="help-block"></span>

                                        </div>
                                    </div>
                  



                                </fieldset>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </form>

    </div>
</div>



@endsection