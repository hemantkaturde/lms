<?php
$roleText = $this->session->userdata('roleText');
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
$counsellor_id ='';
$gst_number ='';
$gst_holder_name ='';

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
        $doctor_non_doctor	  =  $rf->doctor_non_doctor;
        $enq_city	  =  $rf->enq_city;
        $counsellor_id =  $rf->counsellor_id;
        $gst_number = $rf->gst_number;
        $gst_holder_name = $rf->gst_holder_name;


    }
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-content fade-in-up col-md-8">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Edit Inquiry</div>
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
                                                <label style="text-align: left;" for="full_name">Full Name<span
                                                        class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="100"
                                                        type="text" id="full_name1" name="full_name"
                                                        placeholder="Enter Full name Name"
                                                        value="<?php echo $enq_fullname;?>"
                                                        class="form-control col-md-12 col-xs-12">
                                                    <p class="error full_name_error"></p>
                                                    <input type="hidden" id="enq_id" name="enq_id"
                                                        value="<?php echo $enquiryId;?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="mobile_no">Mobile No<span
                                                        class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="10"
                                                        type="text" id="mobile_no1" name="mobile_no"
                                                        placeholder="Enter Mobile No" value="<?php echo $enq_mobile;?>"
                                                        class="form-control col-md-12 col-xs-12">
                                                    <p class="error mobile_no_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="qualification">Qualification<span
                                                        class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text"
                                                        id="qualification1" placeholder="Enter Qualification"
                                                        name="qualification" value="<?php echo $enq_qualification; ?>"
                                                        class="form-control col-md-12 col-xs-12">
                                                    <p class="error qualification_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="enquiry_type">Inquiry Source<span
                                                        class="required">*</span></label>
                                                <select class="form-control" id="enquiry_type1" name="enquiry_type">
                                                    <!-- <option value="">Select Enquiry Source</option>
                                                    <option value="Email" <?php if($enq_source=='Email'){ echo 'selected';} ?>>Email</option>
                                                    <option value="Friends" <?php if($enq_source=='Friends'){ echo 'selected';} ?>>Friends</option>
                                                    <option value="Other" <?php if($enq_source=='Other'){ echo 'selected';} ?>>Other</option> -->
                                                    <option value="Email"
                                                        <?php if($enq_source=='Email'){ echo 'selected';} ?>>Email
                                                    </option>
                                                    <option value="Friends"
                                                        <?php if($enq_source=='Friends'){ echo 'selected';} ?>>Friends
                                                    </option>
                                                    <option value="Google"
                                                        <?php if($enq_source=='Other'){ echo 'selected';} ?>>Google
                                                    </option>
                                                    <option value="Facebook"
                                                        <?php if($enq_source=='Facebook'){ echo 'selected';} ?>>Facebook
                                                    </option>
                                                    <option value="Instagram"
                                                        <?php if($enq_source=='Instagram'){ echo 'selected';} ?>>
                                                        Instagram</option>
                                                    <option value="Reference"
                                                        <?php if($enq_source=='Reference'){ echo 'selected';} ?>>
                                                        Reference</option>
                                                    <option value="Social Media"
                                                        <?php if($enq_source=='Social Media'){ echo 'selected';} ?>>
                                                        Social Media</option>
                                                    <option value="Direct"
                                                        <?php if($enq_source=='Direct'){ echo 'selected';} ?>>Direct
                                                    </option>
                                                    <option value="Call"
                                                        <?php if($enq_source=='Call'){ echo 'selected';} ?>>Call
                                                    </option>
                                                    <option value="Chat"
                                                        <?php if($enq_source=='Chat'){ echo 'selected';} ?>>Chat
                                                    </option>
                                                    <option value="Cold calling"
                                                        <?php if($enq_source=='Cold calling'){ echo 'selected';} ?>>Cold
                                                        calling</option>
                                                    <option value="Ads Campaign"
                                                        <?php if($enq_source=='Ads Campaign'){ echo 'selected';} ?>>Ads
                                                        Campaign</option>
                                                    <option value="WhatsApp"
                                                        <?php if($enq_source=='WhatsApp'){ echo 'selected';} ?>>WhatsApp
                                                    </option>


                                                    <option value="Other"
                                                        <?php if($enq_source=='Other'){ echo 'selected';} ?>>Other
                                                    </option>
                                                </select>
                                                <p class="error enquiry_type_error"></p>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="enq_date">Date of
                                                    Inquiry</label><span class="required">*</span>
                                                <div>
                                                    <input type="text" class="form-control datepicker" id="enq_date1"
                                                        name="enq_date" placeholder="dd-mm-yyyy"
                                                        value="<?php echo  date("Y-m-d", strtotime($enq_date));?>"
                                                        required>
                                                </div>
                                                <p class="error enq_date_error"></p>
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label style="text-align: left;" for="email">Email
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" maxlength="100"
                                                        type="text" id="email1" name="email" placeholder="Enter Email"
                                                        value="<?php echo $enq_email;?>"
                                                        class="form-control col-md-12 col-xs-12">
                                                    <p class="error email_error"></p>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label style="text-align: left;" for="country">Course<span
                                                        class="required">*</span>
                                                </label>
                                                <div>
                                                    <!-- <select class="form-control course" id="course" name="course"> -->
                                                    <select class="form-control select2_demo_1 c1" id="course1"
                                                        name="course[]" placeholder="Select Courses" required=""
                                                        multiple style="width: 320px; margin-left: -15px;">
                                                        <option value="">Select Course</option>
                                                        <?php foreach ($course_List as $key => $value) { ?>
                                                        <option value="<?php echo $value['courseId']; ?>"
                                                            <?php if(in_array($value['courseId'], explode(',', $enq_course_id))){ echo 'selected';} ?>>
                                                            <?php echo $value['course_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <p class="error course_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="doctor_non_doctor">Doctor / Non-
                                                    Doctor<span class="required">*</span></label>
                                                <select class="form-control" id="doctor_non_doctor"
                                                    name="doctor_non_doctor">
                                                    <option value="">Select Doctor / Non- Doctor</option>
                                                    <option value="Doctor" <?php if($doctor_non_doctor=='Doctor'){ echo 'selected';} ?>>Doctor</option>
                                                    <option value="Non-Doctor" <?php if($doctor_non_doctor=='Non-Doctor'){ echo 'selected';} ?>>Non-Doctor</option>
                                                </select>
                                                <p class="error doctor_non_doctor_error"></p>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="city">City </label>
                                                <div>
                                                    <select class="form-control" name="city" id="cityEnquiry">
                                                        <option st-id="" value="0">Select City</option>
                                                        <?php foreach ($city_List as $key => $value) { ?>   
                                                            <option st-id="" value="<?php echo $value['id'] ?>"  <?php if($enq_city==$value['id']){ echo 'selected';} ?>><?php echo $value['name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <p class="error city_error"></p>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                            <label style="text-align: left;"  for="counsellor">Counsellor Name <span class="required">*</span></label>
                                            <div >
                                            <?php if($roleText=='Counsellor'){ ?>
                                                <select class="form-control" name="counsellor" id="counsellor">
                                                    <option st-id="" value="">Select Counsellor</option>
                                                    <?php foreach ($counseller_Name as $key => $value) {
                                                        $counsellor_id = $this->session->userdata('userId');
                                                            if($value['userId']==$counsellor_id){ ?>
                                                                <option value="<?php echo $value['userId']; ?>"  selected  ><?php echo $value['name']; ?></option>
                                                            <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            <?php }else{ ?>
                                                <select class="form-control" name="counsellor" id="counsellor">
                                                    <option st-id="" value="">Select Counsellor</option>
                                                    <?php foreach ($counseller_Name as $key => $value) {?>
                                                    <option value="<?php echo $value['userId']; ?>" <?php if($counsellor_id==$value['userId']){ echo 'selected';} ?> ><?php echo $value['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php } ?>    
                                                <p class="error counsellor_error"></p>       
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="text-align: left;"  for="gst_number">GST Number
                                                </label>
                                                <div>
                                                <input autocomplete="off" autocomplete="off" maxlength="50" value="<?php echo $gst_number;?>" type="text" id="gst_number" name="gst_number" placeholder="GST Number" class="form-control col-md-12 col-xs-12">
                                                <p class="error gst_number_error"></p>
                                                </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="text-align: left;"  for="gst_holder_name">GST Holder Name
                                            </label>
                                                <div >
                                                <input autocomplete="off" autocomplete="off" maxlength="50" type="text" value="<?php echo $gst_holder_name;?>" id="gst_holder_name" name="gst_holder_name" placeholder="GST Holder Name" class="form-control col-md-12 col-xs-12">
                                                <p class="error gst_holder_name_error"></p>
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
                                    class="btn btn-default" value="BACK" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>