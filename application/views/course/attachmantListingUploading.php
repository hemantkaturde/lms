<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-10">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Attachments - <?=ucfirst($type);?> - <?=$course_topic_info[0]->topic_name;?>
                    <small>( <?=$course_topic_info[0]->course_name?> )</small>
                </div>
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtopicattachment">
                    <i class="fa fa-plus"></i> Add New File
                </button>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <table id="" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Topic / Chapter Name</th>
                                <th>File Name</th>
                                <th>Link</th>
                                <th>Downlaod</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->


    <!-- Add New Course Modal -->
    <div class="modal fade" id="addtopicattachment" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-labelledby="addtopicattachmentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="uploadmain-div container">
                    <form id="imageupload" action="<?php echo base_url('course/uploadSubmit');?>"
                        enctype='multipart/form-data' method="post">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div id="progressbr-container">
                                        <div id="progress-bar-status-show"> </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label for="image">Upload Image</label>
                                    <input name="image_up" id="image_up_id" type="file"
                                        class="demoInputBox form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <input type="submit" value="Upload Image" class="btn btn-success" />
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div id="toshow" style="visibility:hidden;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div id="imageDiv" style="display:none;color:red;"><strong>Your Uploaded Image
                                            :-</strong> </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div id="loader" style="display:none;">
                                        <img src="<?php echo base_url('assets/img/LoaderIcon.gif');?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>