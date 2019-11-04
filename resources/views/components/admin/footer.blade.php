<div class="modal fade" id="AttachmentInfoEdit" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="AttachmentInfoEditLabel">{{t('edit')}}</h4>
            </div>

            <div class="modal-body">

                <form role="form"  id="AttachmentInfoEditForm"  enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">

                              
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <input type="text" class="form-control" id="title" name="title" value="">
                                        <label for="title">{{ _lang('app.title') }}</label>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <input type="text" class="form-control" id="url" name="url" value="">
                                        <label for="url">{{ _lang('app.url')}}</label>
                                        <span class="help-block"></span>
                                    </div>
                                </div>


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

<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
        All Rights Reserved ©    Co. {{date('Y')}} | <a style="color: #fff;"  target="_blank" href="">Powered By Developer</a>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
