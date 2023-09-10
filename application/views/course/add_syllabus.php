<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtopicattachment">
                        <i class="fa fa-plus"></i> Add New Syllabus
                    </button>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/courselisting';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                <div class="ibox-title">Course Topic / Chapter List - <?=$getCourseinfo[0]->course_name;?> <small>(
                        <?=$getCourseinfo[0]->course_name?> )</small></div>
                <input type="hidden" id="course_id" name="course_id" value="<?=$getCourseinfo[0]->courseId;?>">
            </div>   

            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <table id="view_course_syllabus" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Link</th>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Add New Course Modal -->
    <div class="modal fade" id="addtopicattachment" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-labelledby="addtopicattachmentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Syllabus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                    <div class="uploadmain-div container">
                        <!-- <form id="imageupload" action="<?php echo base_url('course/uploadSubmit');?>"
                            enctype='multipart/form-data' method="post"> -->
                        <form id="uploadForm" enctype="multipart/form-data">
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
                                        <label for="image">Document Name</label><span class="required">*</span>
                                        <input name="document_name" id="document_name" type="text" class="form-control" required/>
                                    </div>
                                </div>
                                
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="image">Upload Syllabus File (PDF /DOC / DOCX / JPEG /JPG / PNG /GIF)</label><span class="required">*</span>
                                        <input name="file" id="fileInput" type="file" class="demoInputBox form-control" required/>
                                        <input name="course_id" id="course_id" type="hidden" value="<?php echo $course_id; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="submit" value="Upload Syllabus" class="btn btn-primary" />
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
                                        <div id="imageDiv" style="display:none;color:red;"><strong>Your Uploaded <?=ucfirst($type);?>
                                                :-</strong> </div>
                                        <div id="uploadStatus"></div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <div id="loader" style="display:none;">
                                        <div class="progress">
                                            <div class="progress-bar"></div>
                                        </div>
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



<script>
$(document).ready(function(){
    // File upload via Ajax
    $("#uploadForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete+'%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url : "<?php echo base_url();?>course/uploadCoursesayllabus",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $(".progress-bar").width('0%');
                $('#uploadStatus').html('<img src="<?php echo base_url();?>assets/img/LoaderIcon.gif"/>');
            },
            error:function(){
                $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
            },
            success: function(resp){
                if(resp == 'ok'){
                    $('#uploadForm')[0].reset();
                    $('#uploadStatus').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
                     window.location.href = "<?php echo base_url().'addsyllabus/'.$course_id?>";
                }else if(resp == 'err'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                }else if(resp =='empty'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                }else if(resp == 'big_file'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Image size exceeds 3GB.</p>');
                }else if(resp == 'type_missmatch'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file .</p>');
                } else if(resp == 'exits'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Document Already Exits</p>');
                }
            }
        });
    });
	
    // File type validation
    $("#fileInput").change(function(){
        var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','	application/vnd.ms-excel.sheet.binary.macroEnabled.12','application/vnd.ms-excel','application/vnd.ms-excel.sheet.macroEnabled.12'];
        
        var file = this.files[0];
        var fileType = file.type;
        if(!allowedTypes.includes(fileType)){
            //alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG/GIF).');
            $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG/GIF).</p>');
            $("#fileInput").val('');
            return false;
        }
    });
});
</script>