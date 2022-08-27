<?php

$enquiryId = '';
$enq_fullname = '';
$enq_mobile = '';
$enq_mobile1 ='';
$enq_qualification ='';
$enq_source ='';
$enq_date  = '';
$enq_purpose  = '';
$enq_email  = '';
$alternet_email  = '';
$enq_course_id  = '';
$remark  = '';

if(!empty($editDataenquiry))
{
    foreach ($editDataenquiry as $rf)
    {

        $enquiryId = $rf->enq_id ;
        $enq_fullname = $rf->enq_fullname;
        $enq_mobile = $rf->enq_mobile;
        $enq_mobile1 = $rf->enq_mobile1;
        $enq_qualification = $rf->enq_qualification;
        $enq_source = $rf->enq_source;
        $enq_date  = $rf->enq_date;
        $enq_purpose  = $rf->enq_purpose;
        $enq_email  = $rf->enq_email;
        $alternet_email  =  $rf->enq_email1;
        $enq_course_id  =  $rf->enq_course_id;
        $remark  =  $rf->enq_remark;
        // $role = $rf->role;
        // $role_type = $rf->role_type;
        // $discription = $rf->discription;
        // $access = $rf->access; 
    }
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-content fade-in-up col-md-8">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Edit Enquiry</div>
            </div>
            <div class="ibox-body">
                <?php
                        $attributes = array("name"=>"update_enquiry_form","id"=>"update_enquiry_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);
                        
                    ?>
                <form role="form" id="enquiry_form">
                    <div class="row">
                        <!-- <div class="col-md-12"> -->
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <!-- <div class="box-header">
                                    <h3 class="box-title">Edit Enquiry</h3>
                                </div> -->
                                <div class="box-body">
                                    <div class="row col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label style="text-align: left;" for="full_name">Full Name<span class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="100" type="text" id="full_name1" name="full_name" placeholder="Enter Full name Name" value="<?php echo $enq_fullname;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error full_name_error"></p>
                                                    <input type="hidden" id="enq_id" name="enq_id"  value="<?php echo $enquiryId;?>">
                                                    <p class="error full_name_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="mobile_no">Mobile No<span class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="10" type="text" id="mobile_no1" name="mobile_no" placeholder="Enter Mobile No" value="<?php echo $enq_mobile;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error mobile_no_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="alternate_mobile">Alternate Mobile
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="100" type="text" id="alternate_mobile1" placeholder="Enter Alternate Mobile" name="alternate_mobile" value="<?php echo $enq_mobile1;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error alternate_mobile_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="qualification">Qualification<span class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" 
                                                        type="text" id="qualification1"
                                                        placeholder="Enter Qualification" name="qualification"
                                                        value="<?php echo $enq_qualification; ?>"
                                                        class="form-control col-md-12 col-xs-12">
                                                    <p class="error qualification_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="enquiry_type">Enquiry Source<span
                                                        class="required">*</span></label>
                                                <select class="form-control" id="enquiry_type1" name="enquiry_type">
                                                    <option value="">Select Enquiry Source</option>
                                                    <option value="Email" <?php if($enq_source=='Email'){ echo 'selected';} ?>>Email</option>
                                                    <option value="Friends" <?php if($enq_source=='Friends'){ echo 'selected';} ?>>Friends</option>
                                                    <option value="Other" <?php if($enq_source=='Other'){ echo 'selected';} ?>>Other</option>
                                                </select>
                                                <p class="error enquiry_type_error"></p>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="enq_date">Date of
                                                    Enquiry</label><span class="required">*</span>
                                                <div>
                                                    <input type="text" class="form-control datepicker" id="enq_date1"
                                                        name="enq_date" placeholder="dd-mm-yyyy" value="<?php echo  date("Y-m-d", strtotime($enq_date));?>" required>
                                                </div>
                                                <p class="error enq_date_error"></p>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="purpose">Purpose
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="500"
                                                        type="text" id="purpose1" 
                                                        value="<?php echo $enq_purpose; ?>"
                                                        placeholder="Enter Purpose"
                                                        name="purpose" class="form-control col-md-12 col-xs-12">
                                                    <p class="error purpose_error"></p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label style="text-align: left;" for="email">Email<span
                                                        class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="100"
                                                        type="text" id="email1" name="email" placeholder="Enter Email"
                                                        value= "<?php echo $enq_email;?>"
                                                        class="form-control col-md-12 col-xs-12">
                                                    <p class="error email_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="alternamte_email">Alternamte Email
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="100"
                                                        type="text" id="alternamte_email1" name="alternamte_email"
                                                        placeholder="Enter Alternamte Email"
                                                        value= "<?php echo $alternet_email;?>"
                                                        class="form-control col-md-12 col-xs-12">
                                                    <p class="error alternamte_email_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="country">Course
                                                </label>
                                                <div>
                                                    <!-- <select class="form-control course" id="course" name="course"> -->
                                                    <select class="form-control select2_demo_1 c1" id="course1"
                                                        name="course[]" placeholder="Select Courses" required=""
                                                        multiple style="width: 320px; margin-left: -15px;">
                                                        <option value="">Select Course</option>
                                                        <?php foreach ($course_List as $key => $value) { ?>                
                                                            <option value="<?php echo $value['courseId']; ?>" <?php if(in_array($value['courseId'], explode(',', $enq_course_id))){ echo 'selected';} ?> > <?php echo $value['course_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <p class="error course_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="country">Country
                                                </label>
                                                <div>
                                                    <select class="form-control country" id="countryEnquiry" name="country">
                                                        <option value="0">Select Country</option>
                                                        <option value="101" selected>India</option>
                                                    </select>
                                                    <p class="error enquiry_type_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="state">State </label>
                                                <div>
                                                    <select class="form-control state" name="state" id="stateEnquiry">
                                                    <option st-id="" value="0">Select State</option>
                                                    <?php foreach ($state_List as $key => $value) { ?>       
                                                        <option st-id="" value="<?php echo $value['id'] ?>" <?php echo $value['selected'];?> ><?php echo $value['name'] ?></option>
                                                    <?php } ?>
                                                    </select>
                                                    <p class="error state_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="city">City </label>
                                                <div>
                                                    <select class="form-control" name="city" id="cityEnquiry">
                                                        <option st-id="" value="0">Select City</option>
                                                        <?php foreach ($city_List as $key => $value) { ?>   
                                                            <option st-id="" value="<?php echo $value['id'] ?>" <?php echo $value['selected'];?>><?php echo $value['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <p class="error city_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="remarks">Remarks
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="5000"
                                                        type="text" id="remarks1" name="remarks"
                                                        value= "<?php  echo $remark;?>"
                                                        placeholder="Enter Remarks"
                                                        class="form-control col-md-12 col-xs-12">
                                                    <p class="error remarks_error"></p>
                                                    <input type="hidden" name="enq_id" id="enq_id">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <!-- ENTER BUTTON HERE -->
                                <input type="button" id="update_enquiry" class="btn btn-primary" value="UPDATE" />
                                <input type="button" onclick="location.href='<?php echo base_url().'enquirylisting'?>'"
                                    class="btn btn-default" value="CANCEL" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>