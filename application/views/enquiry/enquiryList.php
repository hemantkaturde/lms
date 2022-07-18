<div class="content-wrapper">
    <!-- <div class="page-heading">
        <h3 class="page-title">Users Listing</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html"><i class="la la-home font-20"></i></a>
            </li>
           <li class="breadcrumb-item">Users Listing</li> 
        </ol>
    </div> -->
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Enquiry Management</div>
                <!-- <div class="ibox-tools"> -->
                    <!-- <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a> -->
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEnquiry">
                    <i class="fa fa-plus"></i> Add Enquiry
                </button>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                <table id="view_enquirylist" class="table table-bordered">
                    <thead>
                                <tr>
                                    <th>Enquiry Number</th>
                                    <th>Name</th>
                                    <th>Mobile No</th>
                                    <th>Email</th>
                                    <th>Enquiry Date</th>
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



<!-- Add New Enquiry Modal -->
<div class="modal fade" id="addEnquiry" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addEnquiryLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="modlatitleLabel" style="color:#000">Add New Enquiry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"add_enquiry_form","id"=>"add_enquiry_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>

      <div class="modal-body">
            <div class="container">
            <div class="row col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="full_name">Full Name<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="50" type="text" id="full_name" name="full_name"  placeholder="Enter Full name Name" class="form-control col-md-12 col-xs-12">
                        <p class="error full_name_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="mobile_no">Mobile No<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="10" type="text" id="mobile_no" name="mobile_no"  placeholder="Enter Mobile No" class="form-control col-md-12 col-xs-12">
                        <p class="error mobile_no_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="alternate_mobile">Alternate Mobile
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="10" type="text" id="alternate_mobile"  placeholder="Enter Alternate Mobile" name="alternate_mobile" class="form-control col-md-12 col-xs-12">
                        <p class="error alternate_mobile_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="qualification">Qualification<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="qualification"  placeholder="Enter Qualification" name="qualification" class="form-control col-md-12 col-xs-12">
                        <p class="error qualification_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="enquiry_type">Enquiry Source<span class="required">*</span></label>
                         <select class="form-control" id="enquiry_type" name="enquiry_type">
                            <option value="">Select Enquiry Source</option>
                            <option value="Email">Email</option>
                            <option value="Friends">Friends</option>
                            <option value="Other">Other</option>
                        </select>
                        <p class="error enquiry_type_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;" for="enq_date">Date of Enquiry</label><span class="required">*</span>
                     <div >
                          <input type="text" class="form-control datepicker" id="enq_date" name="enq_date" placeholder="dd-mm-yyyy" autocomplete="off" required>
                     </div>
                     <p class="error enq_date_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="purpose">Purpose
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="purpose"  placeholder="Enter Purpose" name="purpose" class="form-control col-md-12 col-xs-12">
                        <p class="error purpose_error"></p>
                     </div>
                  </div>

              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="email">Email<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="50" type="text" id="email" name="email" placeholder="Enter Email" class="form-control col-md-12 col-xs-12">
                        <p class="error email_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="alternamte_email">Alternamte Email
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="50" type="text" id="alternamte_email" name="alternamte_email" placeholder="Enter Alternamte Email" class="form-control col-md-12 col-xs-12">
                        <p class="error alternamte_email_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="country">Course
                     </label>
                     <div class="form-group">
                         <!-- <select class="form-control course" id="course" name="course" multiple> -->
                         <select class="form-control select2_demo_1" id="course" name="course[]"  placeholder="Select Courses"  required="" multiple style="width: 320px; margin-left: -15px;">
                            <?php foreach ($course_List as $key => $value) {?>
                               <option value="<?php echo $value['courseId']; ?>"><?php echo $value['course_name']; ?></option>
                            <?php } ?>
                        </select>
                        <p class="error course_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="country">Country
                     </label>
                     <div >
                         <select class="form-control country" id="country" name="country">
                            <option value="">Select Country</option>
                            <option value="101">India</option>
                        </select>
                        <p class="error Country_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="state">State </label>
                     <div >
                        <select class="form-control state" name="state" id="state">
                            <option st-id="" value="">Select State</option>
                        </select>
                        <p class="error state_error"></p>       
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="city">City </label>
                     <div >
                        <select class="form-control" name="city" id="city">
                            <option st-id="" value="">Select City</option>
                        </select>
                        <p class="error city_error"></p>       
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
        <button type="submit" id="save_enquiry" class="btn btn-primary save_enquiry">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Update Enquiry Modal -->
<div class="modal fade" id="editEnquiry" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addEnquiryLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="modlatitleLabel" style="color:#000">Update Enquiry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"update_enquiry_form","id"=>"update_enquiry_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>

      <div class="modal-body">
            <div class="container">
            <div class="row col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="full_name">Full Name<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="50" type="text" id="full_name1" name="full_name"  placeholder="Enter Full name Name" class="form-control col-md-12 col-xs-12">
                        <p class="error full_name_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="mobile_no">Mobile No<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="10" type="text" id="mobile_no1" name="mobile_no"  placeholder="Enter Mobile No" class="form-control col-md-12 col-xs-12">
                        <p class="error mobile_no_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="alternate_mobile">Alternate Mobile
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="10" type="text" id="alternate_mobile1"  placeholder="Enter Alternate Mobile" name="alternate_mobile" class="form-control col-md-12 col-xs-12">
                        <p class="error alternate_mobile_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="qualification">Qualification<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="qualification1"  placeholder="Enter Qualification" name="qualification" class="form-control col-md-12 col-xs-12">
                        <p class="error qualification_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="enquiry_type">Enquiry Source<span class="required">*</span></label>
                         <select class="form-control" id="enquiry_type1" name="enquiry_type">
                            <option value="">Select Enquiry Source</option>
                            <option value="Email">Email</option>
                            <option value="Friends">Friends</option>
                            <option value="Other">Other</option>
                        </select>
                        <p class="error enquiry_type_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;" for="enq_date">Date of Enquiry</label><span class="required">*</span>
                     <div >
                          <input type="text" class="form-control datepicker" id="enq_date1" name="enq_date" placeholder="dd-mm-yyyy" required>
                     </div>
                     <p class="error enq_date_error"></p>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="purpose">Purpose
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="purpose1"  placeholder="Enter Purpose" name="purpose" class="form-control col-md-12 col-xs-12">
                        <p class="error purpose_error"></p>
                     </div>
                  </div>

              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="email">Email<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="50" type="text" id="email1" name="email" placeholder="Enter Email" class="form-control col-md-12 col-xs-12">
                        <p class="error email_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="alternamte_email">Alternamte Email
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="50" type="text" id="alternamte_email1" name="alternamte_email" placeholder="Enter Alternamte Email" class="form-control col-md-12 col-xs-12">
                        <p class="error alternamte_email_error"></p>
                     </div>
                   </div>

                   <?php echo $value['course_name']; ?>

                   <div class="form-group">
                     <label style="text-align: left;"  for="country">Course
                     </label>
                     <div >
                         <!-- <select class="form-control course" id="course" name="course"> -->
                         <select class="form-control select2_demo_1" id="course" name="course[]"  placeholder="Select Courses"  required="" multiple style="width: 320px; margin-left: -15px;">
                            <option value="">Select Course</option>
                            <?php foreach ($course_List as $key => $value) {?>
                               <option value="<?php echo $value['courseId']; ?>"><?php echo $value['course_name']; ?></option>
                            <?php } ?>
                        </select>
                        <p class="error course_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="country">Country
                     </label>
                     <div >
                         <select class="form-control country" id="country1" name="country">
                            <option value="0">Select Country</option>
                            <option value="101">India</option>
                        </select>
                        <p class="error enquiry_type_error"></p>
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="state">State </label>
                     <div >
                        <select class="form-control state" name="state" id="state1">
                            <option st-id="" value="0">Select State</option>
                        </select>
                        <p class="error state_error"></p>       
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;"  for="city">City </label>
                     <div >
                        <select class="form-control" name="city" id="city1">
                            <option st-id="" value="0">Select City</option>
                        </select>
                        <p class="error city_error"></p>       
                     </div>
                   </div>

                   <div class="form-group">
                     <label style="text-align: left;" for="remarks">Remarks
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="remarks1" name="remarks"  placeholder="Enter Remarks" class="form-control col-md-12 col-xs-12">
                        <p class="error remarks_error"></p>
                        <input type="hidden" name="enq_id" id="enq_id">
                     </div>
                   </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="update_enquiry" class="btn btn-primary update_enquiry">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

	 