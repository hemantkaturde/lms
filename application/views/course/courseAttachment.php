<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-10">
        <div class="ibox">
            <div class="ibox-head">

                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseAttchment">
                        <i class="fa fa-plus"></i> Add Course Attachment
                    </button>

                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/courselisting';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                     </button>
                </div>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                <table id="view_topic_attchemant_main" class="table table-bordered">
                    <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Document Type</th>
                                    <th>Doctor / Non-Doctor</th>
                                    <th>Document Url / Link</th>
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
<div class="modal fade" id="addCourseAttchment" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addCourseAttchmentLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Attachment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"course_attachment_form","id"=>"course_attachment_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
      <div class="modal-body">
            <div class="container">
            <div class="row col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="document_name">Document Name<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="text" id="document_name" name="document_name"  placeholder="Enter Document Name" class="form-control col-md-12 col-xs-12">
                        <p class="error document_name_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="document_type">Doctor / Non Doctor<span class="required">*</span>
                     </label>
                         <select class="form-control" id="document_type" name="document_type">
                           <option value="">Doctor / Non Doctor</option>
                           <option value="doctor">Doctor</option>
                           <option value="non-doctor">Non-Doctor</option>
                        </select>
                        <p class="error course_type_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="document_type">Document Type<span class="required">*</span>
                     </label>
                         <select class="form-control" class="document_type" id="document_type" name="document_type">
                           <option value="">Select Document Type</option>
                           <option value="File">File</option>
                           <option value="Video">Video</option>
                           <option value="Image">Image</option>               
                        </select>
                        <p class="error course_type_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="file_uplaod">Upload <span class="required">*</span>
                     </label>
                        <input name="file" id="fileInput" type="file" class="demoInputBox form-control" required/>
                        <p class="error file_uplaod_error"></p>
                  </div>

              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        
        <button type="submit" id="save_course" class="btn btn-primary save_course">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>      

<script>
$(document).ready(function(){
    $('#document_type').on('change', function(){
    	var demovalue = $(this).val(); 
        $("div.myDiv").hide();
        $("#show"+demovalue).show();
    });
});
</script> 