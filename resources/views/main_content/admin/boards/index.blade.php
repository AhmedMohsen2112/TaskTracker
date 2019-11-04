@extends('layouts.admin')

@section('pageTitle', t('meal_plans'))

@section('breadcrumb')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{route('admin.dashboard')}}">{{t('dashboard')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{t('boards')}}</span>
    </li>
</ul>

@endsection

@push('js_custom')
<script src="{{admin_scripts()}}/boards.js" type="text/javascript"></script>
@endpush
@section('content')

<div class="modal fade" id="addEditBoards" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addEditBoardsLabel"></h4>
            </div>

            <div class="modal-body">

                <form role="form"  id="addEditBoardsForm"  enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input">
                                <input type="text" class="form-control" id="title" name="title" value="">
                                <label for="title">{{ t('title') }}</label>
                                <span class="help-block"></span>
                            </div>
                        </div>






                    </div>
                </form>

            </div>
            <div class = "modal-footer">
                <button type = "button" class = "btn btn-info submit-form"
                        >{{_lang("app.save")}}</button>
                <button type = "button" class = "btn btn-white"
                        data-dismiss = "modal">{{_lang("app.close")}}</button>
            </div>

        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="panel panel-primary">
            <!-- Default panel contents -->

            <div class="panel-body">
                <button class="btn btn-info" onclick="Boards.add_board(this);return false;">
                    <i class="fa fa-plus"></i>
                    {{t('add_new_board')}}
                </button>
            </div>
            <!-- List group -->
            <ul class="list-group" id="boards-content">
                @forelse($boards as $one)
                <li class="list-group-item board-item" id="board{{$one->id}}">
                    {{$one->title}} 
                    <a class="btn btn-xs btn-primary pull-right" data-id="{{$one->id}}" onclick="Boards.edit(this);return false;">{{t('edit')}}</a>
                    <a class="btn btn-xs btn-warning pull-right" href="{{route('admin.boards.view',['id'=>$one->id])}}">{{t('view')}}</a>
                    <a class="btn btn-xs btn-danger pull-right" data-id="{{$one->id}}" onclick="Boards.delete(this);return false;">{{t('delete')}}</a>
                </li>
                @empty
                <li class="list-group-item text-center">{{t('no_boards')}}</li>
                @endforelse

            </ul>
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