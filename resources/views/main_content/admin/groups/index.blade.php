@extends('layouts.admin')

@section('pageTitle', t('permissions_groups'))
@section('breadcrumb')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{route('admin.dashboard')}}">{{t('dashboard')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{t('groups')}}</span>
    </li>
</ul>

@endsection
@push('js_custom')
<script src="{{admin_scripts()}}/groups.js" type="text/javascript"></script>
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
                            <th>{{ t('name')}}</th>
                            <th>{{ t('created_by')}}</th>
                            <th>{{ t('active')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>



            </div>
        </div>
    </div>
    @if(\Permissions::check('groups', 'add_edit'))
    <div class="col-md-12">
        <form role="form"  id="addEditGroupsForm"  enctype="multipart/form-data">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <!--                    <div class="caption font-red-sunglo">
                                            <span class="caption-subject bold uppercase">{{t('details')}}</span>
                                        </div>-->
                    <div class="actions">
                        <a class="btn btn-circle btn-default" href="javascript:Groups.empty();">
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
                                    <legend class="scheduler-border">{{ t('group_info') }}</legend>
                                    <div class="form-group form-md-line-input col-md-6">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ t('name') }}">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group form-md-line-input col-md-6">
                                        <select class="form-control edited" id="active" name="active">
                                            <option  value="1">{{ t('active') }}</option>
                                            <option  value="0">{{ t('not_active') }}</option>

                                        </select>

                                    </div>
                                </fieldset>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">{{ t('permissions') }}</legend>
                                    <div class="form-group form-md-checkboxes col-md-12">
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="check-all" class="md-check">
                                            <label for="check-all">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                {{ t('all') }} </label>
                                        </div>
                                    </div>
                                    @php $count=0;@endphp
                                    @foreach ($modules as $module)

                                    <div class="col-md-6">

                                        <div class="form-group form-md-checkboxes">
                                            <label>{{ t($module['name']) }}</label>
                                            <div class="md-checkbox-inline">

                                                @foreach ($module['actions'] as $action)
                                                <div class="md-checkbox has-success">
                                                    @php
                                                    $s_open_id = $module['name'] . '_' . $action 
                                                    @endphp
                                                    <input type="checkbox" id="{{ $s_open_id }}" name="group_options[{{$count}}]" value="{{ $s_open_id }}" class="check-one md-check">
                                                    <label for="{{$s_open_id }}">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> {{ t($action) }} </label>
                                                </div>
                                                @php $count++;@endphp
                                                @endforeach

                                            </div>
                                        </div>

                                    </div>

                                    @endforeach
                                </fieldset>
                            </div>
                        </div>









                    </div>



                </div>
            </div>
        </form>

    </div>
</div>
@endif


<script>

</script>
@endsection
