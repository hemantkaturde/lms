<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="btn btn-primary addcourse"><i class="fa fa-plus"></i> Add Course</a> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->  
                <div>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourse">
                     <i class="fa fa-plus"></i> Add Course
                  </button>

                  <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                  </button>
                </div> 
            
                <div class="ibox-title">Course Management</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_courselist" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Certificate Type</th>
                                <th>Course Fees</th>
                                <th>Course Mode</th>
                                <th>Course Books</th>
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
                        <input autocomplete="off" autocomplete="off"  type="text" id="course_name" name="course_name"  placeholder="Enter Course Name" class="form-control col-md-12 col-xs-12">
                        <p class="error course_name_error"></p>
                     </div>
                  </div>

                  <!-- <div class="form-group">
                     <label style="text-align: left;"  for="description">Description
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="text" id="description" name="description" placeholder="Enter Description" class="form-control col-md-12 col-xs-12">
                        <p class="error description_error"></p>
                     </div>
                  </div> -->

                  <div class="form-group">
                     <label style="text-align: left;"  for="course_type">Certificate Type<span class="required">*</span>
                     </label>
                         <select class="form-control" id="course_type" name="course_type">
                           <option value="">Select Certificate Type</option>
                           <?php foreach ($course_type as $key => $value) { ?>
                           <option value="<?php echo $value->ct_id; ?>"><?php echo ucwords($value->ct_name); ?></option>
                           <?php } ?>
                        </select>
                        <p class="error course_type_error"></p>
                  </div>

                  <!-- <div class="form-group">
                     <label style="text-align: left;" for="remarks">Remarks
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="text" id="remarks" name="remarks"  placeholder="Enter Remarks" class="form-control col-md-12 col-xs-12">
                        <p class="error remarks_error"></p>
                     </div>
                   </div> -->

                  <!-- <div class="form-group">
                     <label style="text-align: left;"  for="trainer">Trainer
                     </label>
                         <select class="form-control" id="trainer" name="trainer">
                           <option value="">Select Trainer</option>
                           <?php foreach ($get_trainer as $key => $value) { ?>
                           <option value="<?php echo $value->userId; ?>"><?php echo ucwords($value->name); ?></option>
                           <?php } ?>
                        </select>
                        <p class="error trainer_error"></p>
                  </div> -->

                  <div class="form-group">
                     <label style="text-align: left;"  for="books">Books <span class="required">*</span>
                     </label>
                     <div >
                          <input type="radio" name="course_books" id="course_books" value="1"> Yes
                          <input type="radio" name="course_books" id="course_books" value="0" style="margin-left:20px;" checked> No
                     </div>
                     <p class="error course_books_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="course_mode">Select Course Mode <span class="required">*</span>
                     </label>
                     <div >
                           <input type="checkbox" class="course_mode_online" id="course_mode_online" name="course_mode_online" value="1"> Online
                           <input type="checkbox" class="course_mode_offline" id="course_mode_offline" name="course_mode_offline" value="1"> Offline
                          <!-- <input type="radio" name="course_mode" id="course_mode" value="1"> Online
                          <input type="radio" name="course_mode" id="course_mode" value="0" style="margin-left:20px;" checked> Offline -->
                     </div>
                     <p class="error course_mode_error"></p>
                  </div>

              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">

                  <div class="form-group">
                     <label style="text-align: left;"  for="fees">Fees<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="number" id="fees" name="fees"  placeholder="Enter Fees" class="form-control col-md-12 col-xs-12">
                        <p class="error fees_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="certificate_cost">Certificate Cost
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="number" id="certificate_cost" name="certificate_cost" placeholder="Enter Certificate Cost" class="form-control col-md-12 col-xs-12">
                        <p class="error certificate_cost_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="kit_cost"> Apron Cost/Courier Charges
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="number" id="kit_cost" name="kit_cost" placeholder="Apron Cost/Courier Charges" class="form-control col-md-12 col-xs-12">
                        <p class="error kit_cost_error"></p>
                     </div>
                   </div>

                   
                  <div class="form-group">
                     <label style="text-align: left;"  for="one_time_admission_fees">One time admission fees
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="number" id="one_time_admission_fees"  placeholder="Enter One time admission fees" name="one_time_admission_fees" class="form-control col-md-12 col-xs-12">
                        <p class="error one_time_admission_fees_error"></p>
                     </div>
                  </div>
           
                  <div class="form-group">
                     <label style="text-align: left;"  for="cgst">CGST (9 %)
                     </label>
                     <div >
                        <input type="hidden" id="cgst_tax" value="9" name="cgst_tax" >
                        <input type="number" id="cgst" readonly placeholder="Enter CGST" name="cgst" class="form-control col-md-12 col-xs-12">
                        <p class="error cgst_error"></p>
                     </div>
                  </div>


                  <div class="form-group">
                     <label style="text-align: left;"  for="sgst">SGST (9 %)
                     </label>
                     <div>
                        <input type="hidden" id="sgst_tax" value="9" name="sgst_tax" >
                        <input type="number" id="sgst" readonly placeholder="Enter SGST" name="sgst" class="form-control col-md-12 col-xs-12">
                        <p class="error sgst_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="sgst">Total Course Fees (All Inclusive)
                     </label>
                     <div>
                        <input type="number" id="total_course_fees" readonly placeholder="Total Course Fees" name="total_course_fees" class="form-control col-md-12 col-xs-12">
                        <p class="error total_course_fees_error"></p>
                     </div>
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
                        <input autocomplete="off" autocomplete="off"  type="text" id="course_name1" name="course_name"  placeholder="Enter Course Name" class="form-control col-md-12 col-xs-12">
                        <p class="error course_name_error"></p>
                     </div>
                  </div>

                  <!-- <div class="form-group">
                     <label style="text-align: left;"  for="description">Description
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="text" id="description1" name="description" placeholder="Enter Description" class="form-control col-md-12 col-xs-12">
                        <p class="error description_error"></p>
                     </div>
                  </div>
                  -->

                  <div class="form-group">
                     <label style="text-align: left;"  for="course_type">Certificate Type<span class="required">*</span>
                     </label>
                         <select class="form-control" id="course_type1" name="course_type">
                           <option value="">Select Certificate Type</option>
                           <?php foreach ($course_type as $key => $value) { ?>
                           <option value="<?php echo $value->ct_id; ?>"><?php echo ucwords($value->ct_name); ?></option>
                           <?php } ?>
                        </select>
                        <p class="error course_type_error"></p>
                  </div>

                  <!-- <div class="form-group">
                     <label style="text-align: left;" for="remarks">Remarks
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="text" id="remarks1" name="remarks"  placeholder="Enter Remarks" class="form-control col-md-12 col-xs-12">
                        <p class="error remarks_error"></p>
                      
                     </div>
                   </div> -->

                   <!-- <div class="form-group">
                     <label style="text-align: left;"  for="trainer">Trainer
                     </label>
                         <select class="form-control" id="trainer1" name="trainer">
                           <option value="">Select Trainer</option>
                           <?php foreach ($get_trainer as $key => $value) { ?>
                           <option value="<?php echo $value->userId; ?>"><?php echo ucwords($value->name); ?></option>
                           <?php } ?>
                        </select>
                        <p class="error trainer_error"></p>
                  </div> -->


                     <input id="course_id" name="course_id" type="hidden">
                  <div class="form-group">
                     <label style="text-align: left;"  for="books">Books <span class="required">*</span>
                     </label>
                     <div >
                          <input type="radio" class="radio_yes1" name="course_books1" id="course_books1" value="1"> Yes
                          <input type="radio" class="radio_no1" name="course_books1" id="course_books1" value="0" style="margin-left:20px;"> No
                     </div>
                     <p class="error course_books_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="course_mode">Select Course Mode <span class="required">*</span>
                     </label>
                     <div >
                          <!-- <input type="radio" class="radio_mode_yes" name="course_mode" id="course_mode1" value="1"> Online
                          <input type="radio" class="radio_mode_no" name="course_mode" id="course_mode1" value="0" style="margin-left:20px;"> Offline -->
                          <input type="checkbox" class="course_mode_online1" id="course_mode_online" name="course_mode_online1" value="1"> Online
                           <input type="checkbox" class="course_mode_offline1" id="course_mode_offline" name="course_mode_offline1" value="1"> Offline
                     </div>
                     <p class="error course_mode_error"></p>
                  </div>
                  
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="fees">Fees<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="number" id="fees1" name="fees"  placeholder="Enter Fees" class="form-control col-md-12 col-xs-12">
                        <p class="error fees_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="certificate_cost">Certificate Cost
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="number" id="certificate_cost1" name="certificate_cost" placeholder="Enter Certificate Cost" class="form-control col-md-12 col-xs-12">
                        <p class="error certificate_cost_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="kit_cost">Apron Cost/Courier Charges
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="number" id="kit_cost1" name="kit_cost" placeholder="Apron Cost/Courier Charges" class="form-control col-md-12 col-xs-12">
                        <p class="error kit_cost_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="one_time_admission_fees">One time admission fees
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off"  type="number" id="one_time_admission_fees1"  placeholder="Enter One time admission fees" name="one_time_admission_fees" class="form-control col-md-12 col-xs-12">
                        <p class="error one_time_admission_fees_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="cgst">CGST (9 %)
                     </label>
                     <div>
                        <input type="hidden" id="cgst_tax1edit" value="9" name="cgst_tax1edit" >
                        <input type="number" id="cgst1"  placeholder="Enter CGST" name="cgst" class="form-control col-md-12 col-xs-12">
                        <p class="error cgst_error"></p>
                     </div>
                  </div>


                  <div class="form-group">
                     <label style="text-align: left;"  for="sgst">SGST (9 %)
                     </label>
                     <div>
                        <input type="hidden" id="sgst_tax1edit" value="9" name="sgst_tax1edit" >
                        <input type="number" id="sgst1"  placeholder="Enter SGST" name="sgst" class="form-control col-md-12 col-xs-12">
                        <p class="error sgst_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="sgst">Total Course Fees (All Inclusive)
                     </label>
                     <div>
                        <input type="number" id="total_course_fees1" readonly placeholder="Total Course Fees" name="total_course_fees" class="form-control col-md-12 col-xs-12">
                        <p class="error total_course_fees_error"></p>
                     </div>
                  </div>
                  
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        
        <button type="submit" id="update_course" class="btn btn-primary update_course">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>