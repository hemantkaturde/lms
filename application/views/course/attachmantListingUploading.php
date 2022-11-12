<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">
               
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <div>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtopicattachment">
                        <i class="fa fa-plus"></i> Add New File
                    </button>

                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url().'/topicattachmentListing?topic_id='.$topic_id.'&course_id='.$course_id;?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>

                </div>
              
                <div class="ibox-title">Attachments - <?=ucfirst($type);?> - <?=$course_topic_info[0]->topic_name;?>
                    <small>( <?=$course_topic_info[0]->course_name?> )</small>
                </div>

                <input name="course_id_form" id="course_id_form" type="hidden" value="<?php echo $course_id; ?>" />
                <input name="doc_type_form" id="doc_type_form" type="hidden" value="<?php echo $type; ?>" />
                <input name="topic_id_form"  id="topic_id_form" type="hidden"  value="<?php echo $topic_id; ?>" />

            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <table id="view_topic_document_document" class="table table-bordered">
                        <thead>
                            <tr>
                                <!-- <th>Topic / Chapter Name</th> -->
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Add New Course Modal -->
    <div class="modal fade" id="addtopicattachment" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-labelledby="addtopicattachmentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New <?=ucfirst($type);?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <?php if($_GET['type']=='documents'){ ?>

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
                                        <label for="image">Document Name</label>
                                        <input name="document_name" id="document_name" type="text" class="form-control" required/>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="image">Video URL</label>
                                        <input name="video_url" id="video_url" type="text" class="form-control" required/>
                                        <input name="course_id" id="course_id" type="hidden" value="<?php echo $course_id; ?>" />
                                        <input name="doc_type" id="doc_type" type="hidden" value="<?php echo $type; ?>" />
                                        <input name="topic_id"  id="topic_id" type="hidden"  value="<?php echo $topic_id; ?>" />
                                    </div>
                                </div> -->
                                
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="image">Upload <?=ucfirst($type);?></label>
                                        <input name="file" id="fileInput" type="file" class="demoInputBox form-control" required/>
                                        <input name="course_id" id="course_id" type="hidden" value="<?php echo $course_id; ?>" />
                                        <input name="doc_type" id="doc_type" type="hidden" value="<?php echo $type; ?>" />
                                        <input name="topic_id"  id="topic_id" type="hidden"  value="<?php echo $topic_id; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="submit" value="Upload <?=ucfirst($type);?>" class="btn btn-primary" />
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
                <?php }else{ ?>
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
                                        <label for="image">Video Title</label>
                                        <input name="video_text" id="video_text" type="text" class="form-control" required/>
                                    </div>
                                </div>

                                
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="image">Video URL</label>
                                        <input name="video_url" id="video_url" type="text" class="form-control" required/>
                                        <input name="course_id" id="course_id" type="hidden" value="<?php echo $course_id; ?>" />
                                        <input name="doc_type" id="doc_type" type="hidden" value="<?php echo $type; ?>" />
                                        <input name="topic_id"  id="topic_id" type="hidden"  value="<?php echo $topic_id; ?>" />
                                    </div>
                                </div>
                                
                                <!-- <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="image">Upload <?=ucfirst($type);?></label>
                                        <input name="file" id="fileInput" type="file" class="demoInputBox form-control" required/>
                                        <input name="course_id" id="course_id" type="hidden" value="<?php echo $course_id; ?>" />
                                        <input name="doc_type" id="doc_type" type="hidden" value="<?php echo $type; ?>" />
                                        <input name="topic_id"  id="topic_id" type="hidden"  value="<?php echo $topic_id; ?>" />
                                    </div>
                                </div> -->
                            </div>

                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="submit" value="Upload <?=ucfirst($type);?>" class="btn btn-primary" />
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <div id="toshow" style="visibility:hidden;"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
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
                            </div> -->
                        </form>
                    </div>
                <?php } ?>
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
            url : "<?php echo base_url();?>course/uploadSubmit",
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
                     window.location.href = "<?php echo base_url().'viewalltopicdocuments?type='.$type.'&topic_id='.$topic_id.'&course_id='.$course_id?>";
                }else if(resp == 'err'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                }else if(resp =='empty'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                }else if(resp == 'big_file'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Image size exceeds 3GB.</p>');
                }else if(resp == 'type_missmatch'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file .</p>');
                }
            }
        });
    });
	
    // File type validation
    $("#fileInput").change(function(){
         if($type=='documents'){
            var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','	application/vnd.ms-excel.sheet.binary.macroEnabled.12','application/vnd.ms-excel','application/vnd.ms-excel.sheet.macroEnabled.12'];
         }

         if($type=='videos'){
            var allowedTypes = ['video/mp4', 'video/webm', 'video/ogv'];
         }

         if($type=='books'){
            var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
         }

        
        var file = this.files[0];
        var fileType = file.type;
        if(!allowedTypes.includes(fileType)){
            //alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG/GIF).');
            if($type=='documents'){
               $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG/GIF).</p>');
            }
            if($type=='videos'){
                $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file (MP4/webm/OGV).</p>');
            }
            if($type=='books'){
                $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG/GIF).</p>');
            }
            $("#fileInput").val('');
            return false;
        }
    });
});
</script>