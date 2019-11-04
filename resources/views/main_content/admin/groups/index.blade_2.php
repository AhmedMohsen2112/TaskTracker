@extends('layouts.backend')

@section('pageTitle', _lang('app.groups'))
@section('breadcrumb')
<h3 class="page-title">
    {{_lang('app.groups')}}</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{route('admin.dashboard')}}">{{_lang('app.dashboard')}}</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span>{{_lang('app.groups')}}</span>
        </li>
    </ul>
</div>
@endsection
@section('js')
<script src="{{url('public/backend/js')}}/groups.js" type="text/javascript"></script>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <span class="caption-subject bold uppercase">{{_lang('app.list')}}</span>
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
                            <th>{{ _lang('app.name')}}</th>
                            <th>{{ _lang('app.active')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>



            </div>
        </div>
    </div>
    <div class="col-md-12">
        <form role="form"  id="addEditGroupsForm"  enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="id" value="0">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <span class="caption-subject bold uppercase">{{_lang('app.details')}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-default" href="javascript:Groups.empty();">
                            {{_lang('app.new')}}
                        </a>
                        <a class="btn btn-circle green submit-form" href="javascript:;">
                            {{_lang('app.save')}}
                        </a>
                        <a class="btn btn-circle red btn-available disabled" href="javascript:Groups.delete();">
                            {{_lang('app.delete')}}
                        </a>
                         <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                        </a>
                    </div>
                </div>

                <div class="portlet-body">


                    <div class="form-body">


                        <div class="row">
                            <div class="form-group form-md-line-input col-md-6">
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ _lang('app.name') }}">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group form-md-line-input col-md-6">
                                <select class="form-control edited" id="active" name="active">
                                    <option  value="1">{{ _lang('app.active') }}</option>
                                    <option  value="0">{{ _lang('app.not_active') }}</option>

                                </select>

                            </div>
                        </div>
                        <div class="row">
                            @php
                            $count = 0;
                            @endphp

                            @foreach ($modules as $module_one)
                            <div class="col-md-12">
                                <h4 style="padding-left: 15px;">{{ _lang('app.'.$module_one['name']) }}</h4>

                                @foreach ($module_one['children'] as $module)

                                <div class="form-group form-md-checkboxes col-md-6">
                                    <label>{{ _lang('app.'.$module['name']) }}</label>
                                    <div class="md-checkbox-inline">

                                        @foreach ($module['actions'] as $action)
                                        @if(!Permissions::check($module['name'],$action))
                                        @continue
                                        @endif
                                        <div class="md-checkbox has-success">
                                            @php
                                            $s_open_id = $module['name'] . '_' . $action 
                                            @endphp
                                            <input type="checkbox" id="{{ $s_open_id }}" name="group_options[{{ $module['name'] }}][]" value="{{ $action }}" class="md-check">
                                            <label for="{{$s_open_id }}">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{ $action }} </label>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                                @php $count ++; @endphp


                                @if($count==6)
                                @php $count=0; @endphp
                                <div class="clearfix"></div>
                                @endif
                                @endforeach
                            </div>
                            @endforeach

                        </div>






                    </div>



                </div>
            </div>
        </form>

    </div>
</div>


<script>

</script>
@endsection
