<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Course Management</div>
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="btn btn-primary addcourse"><i class="fa fa-plus"></i> Add Course</a> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <?php if (in_array("courseadd", $jsonstringtoArray)){?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourse">
                    <i class="fa fa-plus"></i> Add Course
                </button>
                <?php } ?>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_courselist" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Course Type</th>
                                <th>Course Fees</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->

<!-- Add New Course Modal -->
<div class="modal fade" id="addCourse" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addCourseLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"course_form","id"=>"course_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
      <div class="modal-body">
            <div class="container">
            <div class="row col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="course_name">Course Name<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="course_name" name="course_name"  placeholder="Enter Course Name" class="form-control col-md-12 col-xs-12">
                        <p class="error course_name_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="fees">Fees<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="fees" name="fees"  placeholder="Enter Fees" class="form-control col-md-12 col-xs-12">
                        <p class="error fees_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="one_time_admission_fees">One time admission fees
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="one_time_admission_fees"  placeholder="Enter One time admission fees" name="one_time_admission_fees" class="form-control col-md-12 col-xs-12">
                        <p class="error one_time_admission_fees_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="course_type">Course Type<span class="required">*</span>
                     </label>
                         <select class="form-control" id="course_type" name="course_type">
                           <option value="">Select Course Type</option>
                           <?php foreach ($course_type as $key => $value) { ?>
                           <option value="<?php echo $value->ct_id; ?>"><?php echo ucwords($value->ct_name); ?></option>
                           <?php } ?>
                        </select>
                        <p class="error course_type_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="books">Books <span class="required">*</span>
                     </label>
                     <div >
                          <input type="radio" name="course_books" id="course_books" value="1"> Yes
                          <input type="radio" name="course_books" id="course_books" value="0" style="margin-left:20px;" checked> No
                     </div>
                     <p class="error course_books_error"></p>

                  </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="description">Description
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="description" name="description" placeholder="Enter Description" class="form-control col-md-12 col-xs-12">
                        <p class="error description_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="certificate_cost">Certificate Cost
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="certificate_cost" name="certificate_cost" placeholder="Enter Certificate Cost" class="form-control col-md-12 col-xs-12">
                        <p class="error certificate_cost_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="kit_cost">Kit cost
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="kit_cost" name="kit_cost" placeholder="Enter Kit cost" class="form-control col-md-12 col-xs-12">
                        <p class="error kit_cost_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;" for="remarks">Remarks
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="remarks" name="remarks"  placeholder="Enter Remarks" class="form-control col-md-12 col-xs-12">
                        <p class="error remarks_error"></p>
                     </div>
                   </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="save_course" class="btn btn-primary save_course">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="editCourse" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="editCourseLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Update Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"edit_course_form","id"=>"edit_course_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
      <div class="modal-body">
            <div class="container">
            <div class="row col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="course_name">Course Name<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="course_name1" name="course_name"  placeholder="Enter Course Name" class="form-control col-md-12 col-xs-12">
                        <p class="error course_name_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="fees">Fees<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="fees1" name="fees"  placeholder="Enter Fees" class="form-control col-md-12 col-xs-12">
                        <p class="error fees_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="one_time_admission_fees">One time admission fees
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="one_time_admission_fees1"  placeholder="Enter One time admission fees" name="one_time_admission_fees" class="form-control col-md-12 col-xs-12">
                        <p class="error one_time_admission_fees_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="course_type">Course Type<span class="required">*</span>
                     </label>
                         <select class="form-control" id="course_type1" name="course_type">
                           <option value="">Select Course Type</option>
                           <?php foreach ($course_type as $key => $value) { ?>
                           <option value="<?php echo $value->ct_id; ?>"><?php echo ucwords($value->ct_name); ?></option>
                           <?php } ?>
                        </select>
                        <p class="error course_type_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="books">Books <span class="required">*</span>
                     </label>
                     <div >
                          <input type="radio" class="radio_yes" name="course_books" id="course_books1" value="1"> Yes
                          <input type="radio" class="radio_no" name="course_books" id="course_books1" value="0" style="margin-left:20px;"> No
                     </div>
                     <p class="error course_books_error"></p>

                  </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="description">Description
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="description1" name="description" placeholder="Enter Description" class="form-control col-md-12 col-xs-12">
                        <p class="error description_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="certificate_cost">Certificate Cost
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="certificate_cost1" name="certificate_cost" placeholder="Enter Certificate Cost" class="form-control col-md-12 col-xs-12">
                        <p class="error certificate_cost_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="kit_cost">Kit cost
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="kit_cost1" name="kit_cost" placeholder="Enter Kit cost" class="form-control col-md-12 col-xs-12">
                        <p class="error kit_cost_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;" for="remarks">Remarks
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="remarks1" name="remarks"  placeholder="Enter Remarks" class="form-control col-md-12 col-xs-12">
                        <p class="error remarks_error"></p>
                        <input id="course_id" name="course_id" type="hidden">
                     </div>
                   </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="update_course" class="btn btn-primary update_course">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>