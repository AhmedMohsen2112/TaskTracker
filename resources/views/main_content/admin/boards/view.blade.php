@extends('layouts.admin')

@section('pageTitle', $board->title)

@section('breadcrumb')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{route('admin.dashboard')}}">{{t('dashboard')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{route('admin.boards.index')}}">{{t('boards')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{$board->title}}</span>
    </li>
</ul>

@endsection
@push('css_plugins')
<link rel="stylesheet" type="text/css" href="{{admin_plugins()}}/select2/select2.css"/>
@endpush

@push('js_plugins')
<script type="text/javascript" src="{{admin_plugins()}}/select2/select2.min.js"></script>
@endpush
@push('css_custom')
<link rel="stylesheet" type="text/css" href="{{admin_css()}}/todo.css"/>
<link rel="stylesheet" type="text/css" href="{{admin_css()}}/tasks.css"/>
@endpush
@push('js_custom')
<!--<script src="{{admin_scripts()}}/attachment.js" type="text/javascript"></script>-->
<script src="{{admin_scripts()}}/boards.js" type="text/javascript"></script>
<script>
$(function () {

});
</script>
@endpush
@section('content')
<div class="modal fade" id="EditIssues" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-remove"></i></button>
                <h4 class="modal-title" id="EditIssuesLabel"></h4>
            </div>

            <div class="modal-body">
                <div class="row">


                    <div class="col-md-12">
                        <div class="col-md-12">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">{{ t('basic_info') }} </legend>
                                <form role="form"  id="editIssuesForm"  enctype="multipart/form-data">
                                    <div class="form-body">
                                        <div class="col-md-12">
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" id="title" name="title" value="">
                                                <label for="title">{{ t('title') }}</label>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group form-md-line-input">
                                                <textarea rows="4" class="form-control" id="description" name="description"></textarea>
                                                <label for="description">{{ t('description') }}</label>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="control-label">{{ t('due_date') }}</label>
                                            <input class="form-control form-control-inline date-picker from-date"  type="text"  name="due_date">
                                        </div>
                                        <div class="form-actions col-md-12">
                                            <button type="button" class="btn blue submit-form">{{t('save')}}</button>
                                        </div>
                                    </div>

                                </form>

                            </fieldset>


                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">{{ t('attachment') }} <a class="btn btn-sm btn-primary upload-image"><i class="fa fa-plus"></i></a></legend>
                                    <input type="file" class="upload" name="image" multiple style="display:none;">     
                                    <span class="help-block"></span>  
                                    <div class="progress" style="display: none;">
                                        <div class="progress-bar" id="bar" role="progressbar" aria-valuenow="70"
                                             aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            <div id="percent"></div>
                                        </div>
                                    </div>
                                    <div class="uploaded-images row">

                                    </div>


                                </fieldset>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                      
                        <div class="col-md-8">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">{{ t('activity') }} </legend>
                                <form role="form"  id="CommentForm"  enctype="multipart/form-data">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group form-md-line-input">
                                                    <textarea class="form-control" id="comment" name="comment" cols="5" rows="5"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions noborder">
                                            <button type="button" class="btn blue submit-form">{{t('save')}}</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="todo-tasklist recent-activity" style="max-height:550px;overflow-y: auto;margin-top: 1.8rem;">



                                </div>

                            </fieldset>


                        </div>
                          <div class="col-md-4">
                            <form role="form"  id="AssignmentForm"  enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label">{{ t('assign_to') }}</label>
                                    <input type="text" name="user" id="user" class="select2-container form-control select2">
                                    <span class="help-block"></span>
                                </div>

                                <div class="form-actions noborder">
                                    <button type="button" class="btn blue submit-form">{{t('assign')}}</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>










            </div>


        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="aa-tasks">
            <!-- Lists container -->

            <section class="lists-container">
                @foreach($board->lists_data() as $list)
                <div  class="list">

                    <h3 class="list-title">{{$list->title}}</h3>

                    <ul id="list-{{$list->id}}" data-id="{{$list->id}}" class="list-items" >
                        @foreach($list->issues_data() as $issue)
                        <li id="issue{{$issue->id}}" data-id="{{$issue->id}}" onclick="Boards.edit_issue(this);return false;">
                            <h5>{{$issue->title}}</h5>
                            <p>{{$issue->description}}</p>
                        </li>
                        @endforeach
                        <form role="form"  class="addIssuesForm"  enctype="multipart/form-data" style="display: none;">
                            <input type="hidden" name="list" value="{{$list->id}}">
                            <div class="form-body">
                                <div class="form-group">
                                    <input type="text" class="form-control"  name="title">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <textarea rows="4" class="form-control"  name="description"></textarea>
                                    <span class="help-block"></span>
                                </div>
                                <p>
                                    <a class="btn purple submit-form">{{t('save')}}</a>
                                    <a class="btn dark close-btn" href="javascript:;">{{t('close')}}</a>
                                </p>
                            </div>
                        </form>

                    </ul>


                    <button class="add-card-btn btn"><i class="fa fa-plus"></i>{{t('add_a_card')}}</button>

                </div>
                @endforeach

                <form role="form"  id="addEditBoardListsForm"  enctype="multipart/form-data" style="display: none;">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" value="">
                        <span class="help-block"></span>
                    </div>
                    <p>
                        <a class="btn purple submit-form">{{t('save')}}</a>
                        <a class="btn dark close-btn" href="javascript:;">{{t('close')}}</a>
                    </p>
                </form>



                <button class="add-list-btn btn">
                    <i class="fa fa-plus"></i>{{t('add_a_list')}}
                </button>

            </section>
            <!-- End of lists container -->
        </div>


    </div>
</div>
<script>
    var new_lang = {

    };
    var new_config = {
        page: "boards_view",
        id: "{{$board->id}}",
        upload_url: "{{route('admin.board.list.issues.upload.submit')}}",
    };
</script>
@endsection