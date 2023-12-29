<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">

                <div>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                
                <div class="ibox-title">View Course Request</div>
            </div>
            <div class="ibox-body">
        
                <div class="panel-body table-responsive ">
                    <table id="view_course_rerquests_admin" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Student Nobile Number</th>
                                <th>Tpoic Name</th>
                                <th>Course Name</th>
                                <th>Class Date</th>	
                                <th>Class Timings</th>
                                <th>Attendance Status</th>
                                <th>Approval Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->

    <!-- Add New Course Modal -->
<div class="modal fade" id="addCourseRequest" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addCourseRequestLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Class Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"addCourseRequestapproved_form","id"=>"addCourseRequestapproved_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
      <div class="modal-body">
            <div class="container">
            <div class="row col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="course_name">Course Name<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="text" id="course_name" name="course_name"  placeholder=" Course Name" class="form-control col-md-12 col-xs-12" readonly>
                        <p class="error course_name_error"></p>
                        <input autocomplete="off" autocomplete="off"  type="hidden" id="time_table_id" name="time_table_id" readonly>
                        <input autocomplete="off" autocomplete="off"  type="hidden" id="request_id" name="request_id" readonly>
                     </div>
                  </div>
                  <div class="form-group">
                     <label style="text-align: left;"  for="course_topic">Course Topic<span class="required">*</span>
                     </label>
                        <input autocomplete="off" autocomplete="off"  type="text" id="course_topic" name="course_topic"  placeholder=" Course Topic" class="form-control col-md-12 col-xs-12" readonly>
                        <p class="error course_topic_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="request_description">Request Description / Remark<span class="required">*</span>
                     </label>
                       <textarea id="request_description" name="request_description" rows="4" cols="50" class="form-control col-md-12 col-xs-12"> </textarea>
                        <p class="error request_description_error"></p>
                  </div>

                 
                  <div class="form-group">
                    <label style="text-align: left;"  for="request_description">Approval Status<span class="required">*</span>
                        </label>
                       <select class="form-control" id="updated_status" name="updated_status">
                           <option value="">Select Approval Status</option>
                           <option value="Approved">Approved</option>
                           <option value="Not Approved">Not Approved</option>
                        </select>
                        <p class="error updated_status_error"></p>
                </div>

              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        
        <button type="submit" id="save_addCourseRequestapproved_form" class="btn btn-primary save_course">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>