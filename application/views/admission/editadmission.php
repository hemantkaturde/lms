<?php
$admission_id = '';
$fullname = '';
$lastname = '';
$gender = '';
$enq_id= '';
$mobile = '';
$alt_mobile = '';
$email ='';
$dateofbirth ='';
$counsellor_name ='';
$permanant_address ='';
$country_id ='';
$state_id ='';
$city_id ='';
$source ='';
$source_ans ='';  
$image_1 =''; 
$image_2 ='';
$image_3 ='';
$pin='';

if(!empty($editDataAdmission))
{
    foreach ($editDataAdmission as $rf)
    {
        $admission_id = $rf->id;
        $enq_id = $rf->enq_id;
        $fullname = $rf->name;
        $lastname = $rf->lastname;
        $gender = $rf->gender;
        $mobile = $rf->mobile;
        $alt_mobile = $rf->alt_mobile;
        $email =$rf->email;
        $dateofbirth =$rf->dateofbirth;
        $counsellor_name =$rf->counsellor_name;
        $permanant_address =$rf->address;
        $country_id =$rf->country;
        $state_id =$rf->state;
        $city_id =$rf->city;
        $source = $rf->source_about;
        $pin = $rf->pin;
        $source_ans = $rf->source_ans;
        $image_1 =$rf->document_1; 
        $image_2 =$rf->document_2;
        $image_3 =$rf->document_3;
    }
}


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Edit Admission</div>
            </div>
            <div class="ibox-body">
                    <?php $attributes = array("name"=>"update_admission_form","id"=>"update_admission_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);?>
                            <form role="form" id="update_admission_form">
                              <div class="row">
                                    <div class="row col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label style="text-align: left;" for="full_name">First Name<span class="required">*</span></label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="full_name1" name="full_name" placeholder="Enter Full name Name" value="<?php echo $fullname;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error full_name_error"></p>
                                                    <input type="hidden" id="admission_id" name="admission_id"  value="<?php echo $admission_id;?>">
                                                    <input type="hidden" id="enq_id" name="enq_id"  value="<?php echo $enq_id;?>">
                                                </div>
                                            </div> 
                                            
                                            <div class="form-group">
                                                <label style="text-align: left;" for="full_name">Last Name<span class="required">*</span></label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="lastname" name="lastname" placeholder="Enter Last Name" value="<?php echo $lastname;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error lastname_error"></p>
                                                </div>
                                            </div>  

                                            <div class="form-group">
                                                <label style="text-align: left;" for="full_name">Gender<span class="required">*</span></label>
                                                <div>
                                                    <select id="gender" name="gender" class="form-control" Required>
                                                        <option value="">Select Gender</option>
                                                        <option value="Male" <?php if($gender=='Male'){ echo 'selected';} ?>>Male</option>
                                                        <option value="Female" <?php if($gender=='Female'){ echo 'selected';} ?>>Female</option>
                                                    </select>
                                                    <p class="error gender_error"></p>
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <label style="text-align: left;" for="mobile_number">Mobile Number<span class="required">*</span></label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text"   maxlength="10" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number" value="<?php echo $mobile;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error mobile_number_error"></p>
                                                </div>
                                            </div>   

                                            <div class="form-group">
                                                <label style="text-align: left;" for="alternate_mobile_number">Alternate Mobile Number</label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text"  maxlength="10" id="alternate_mobile_number" name="alternate_mobile_number" placeholder="Enter Alternate Mobile Number" value="<?php echo $alt_mobile;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error alternate_mobile_number_error"></p>
                                                </div>
                                            </div>  

                                            <div class="form-group">
                                                <label style="text-align: left;" for="email_address">E-mail Address<span class="required">*</span></label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="email_address" name="email_address" placeholder="E-mail Address" value="<?php echo $email;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error email_address_error"></p>
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <label style="text-align: left;" for="date_of_birth">Date Of Birth<span class="required">*</span></label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="date_of_birth" name="date_of_birth" placeholder="Date Of Birth" value="<?php echo $dateofbirth;?>" class="form-control col-md-12 col-xs-12 datepickerdateofbirth">
                                                    <p class="error date_of_birth_error"></p>
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label style="text-align: left;" for="permanent_address">Permanent Address<span class="required">*</span></label>
                                                <div>
                                                <textarea  rows="5" id="permanent_address" name="permanent_address" class="form-control"><?php echo $permanant_address;?></textarea>
                                                    <p class="error permanent_address_error"></p>
                                                </div>
                                            </div> 

                                            
                                            <div class="form-group">
                                                <label style="text-align: left;" for="country">Country </label>
                                                <div>
                                                    <select class="form-control country" name="country" id="countryEditAdmission">
                                                    <option st-id="" value="0">Select Country</option>
                                                        <option st-id="" value="101" <?php echo 'selected'; ?>>India</option>
                                                    </select>
                                                    <p class="error country_error"></p>
                                                </div>
                                            </div>

 
                                            <div class="form-group">
                                                <label style="text-align: left;" for="state">State </label>
                                                <div>
                                                    <select class="form-control state" name="state" id="stateEditadmission">
                                                    <option st-id="" value="0">Select State</option>
                                                    <?php foreach ($state_List as $key => $value) { ?>       
                                                        <option st-id="" value="<?php echo $value['id'] ?>" <?php if($state_id==$value['id']){ echo 'selected';} ?>><?php echo $value['name'] ?></option>
                                                    <?php } ?>
                                                    </select>
                                                    <p class="error state_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="city"> City</label>
                                                <div>
                                                    <select class="form-control city" name="city" id="cityEditadmission">
                                                    <option st-id="" value="0">Select City</option>
                                                    <?php foreach ($city_List as $key => $value) { ?>       
                                                        <option st-id="" value="<?php echo $value['id'] ?>" <?php if($city_id==$value['id']){ echo 'selected';} ?>><?php echo $value['name'] ?></option>
                                                    <?php } ?>
                                                    </select>
                                                    <p class="error city_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="pin_number">PIN</label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off"  maxlength="6" type="text" id="pin_number" name="pin_number" placeholder="Enter PIN Number" value="<?php echo $pin;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error pin_number_error"></p>
                                                </div>
                                            </div>  


                                            <input type="hidden" id="counsellor_name" name="counsellor_name" value="<?php echo $counsellor_name;?>">


                                            <div class="form-group">
                                                <label style="text-align: left;" for="counsellor_name_varchar">Counsellor Name <span class="required">*</span></label>
                                                <div>
                                                    <select class="form-control counsellor_name_varchar" name="counsellor_name_varchar" id="counsellor_name_varchar" disabled>
                                                    <option st-id="" value="0">Select Counsellor Name</option>
                                                    <?php foreach ($counsellor_list_data as $key => $value) { ?>       
                                                        <option st-id="" value="<?php echo $value['userId'] ?>" <?php if($counsellor_name==$value['userId']){ echo 'selected';} ?>><?php echo $value['name'] ?></option>
                                                    <?php } ?>
                                                    </select>
                                                    <p class="error counsellor_name_varchar_error"></p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <div class="form-group">
                                                <label style="text-align: left;" for="how_did_you_know">HOW DID YOU KNOW ABOUT US<span class="required">*</span></label>
                                                <div>
                                                    <select class="form-control how_did_you_know" name="how_did_you_know" id="how_did_you_know">
                                                            <option value="">Source*</option>
                                                            <option value="Google" <?php if($source=='Google'){ echo 'selected';} ?>>Google</option>
                                                            <option value="Facebook" <?php if($source=='Facebook'){ echo 'selected';} ?>>Facebook</option>
                                                            <option value="Instagram" <?php if($source=='Instagram'){ echo 'selected';} ?>>Instagram</option>
                                                            <option value="Reference" <?php if($source=='Reference'){ echo 'selected';} ?>>Reference</option>
                                                            <option value="Social Media" <?php if($source=='Social Media'){ echo 'selected';} ?>>Social Media</option>
                                                            <option value="Other" <?php if($source=='Other'){ echo 'selected';} ?>>Other</option>
                                                    </select>
                                                    <p class="error how_did_you_know_error"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label style="text-align: left;" for="how_about_us">How Did You Know About us</label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="how_about_us" name="how_about_us" placeholder="How Did You Know About us" value="<?php echo $source_ans;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error full_name_error"></p>
                                                </div>
                                            </div> 
                                        </div>    
                                    </div>

                                    <div class="row col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <p class="error student_photo_error"></p>
                                                <label style="text-align: left;" for="student_photo">Student Photo<span class="required">*</span></label>
                                               <img src='<?php echo base_url(); ?>uploads/admission/<?=$image_1 ?>'>

                                               <input type="file" id="student_photo" name="student_photo" class="form-control"
                                                    accept="image/*" onchange="loadFile_student_photo(event)">
                                                <input type="hidden" id="student_photo_existing" name="student_photo_existing" value="<?=$image_1?>" class="form-control">
                                                <small class="text-default">( Upload photo as Show on Admin Panel)</small>
                                                <p><img id="output_student_photo" width="200" /></p>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                            <p class="error edu_certificate_error"></p>
                                                <label style="text-align: left;" for="edu_certificate">Education Certificate <span class="required">*</span></label>
                                               <img src='<?php echo base_url(); ?>uploads/admission/<?=$image_2 ?>'>
                                               <input type="file" id="edu_certificate" name="edu_certificate" class="form-control"
                                                    accept="image/*" onchange="loadFile_education_certificate(event)">
                                                <input type="hidden" id="edu_certificate_existing" name="edu_certificate_existing" value="<?=$image_2?>" class="form-control">
                                                <small class="text-default">( Upload photo as Show on Admin Panel)</small>
                                                <p><img id="output_education_certificate" width="200" /></p>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                            <p class="error adhar_copy_error"></p>
                                                <label style="text-align: left;" for="adhar_copy">Aadhar Copy<span class="required">*</span></label>
                                               <img src='<?php echo base_url(); ?>uploads/admission/<?=$image_3 ?>'>
                                               <input type="file" id="adhar_copy" name="adhar_copy" class="form-control"
                                                    accept="image/*" onchange="loadFile_adhar_copy(event)">
                                                <input type="hidden" id="adhar_copy_existing" name="adhar_copy_existing" value="<?=$image_3?>" class="form-control">
                                                <small class="text-default">( Upload photo as Show on Admin Panel)</small>
                                                <p><img id="output_adhar_copy" width="200" /></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <!-- ENTER BUTTON HERE -->
                                                <input type="button" id="update_admission" class="btn btn-primary" value="UPDATE" />
                                                <input type="button" onclick="location.href='<?php echo base_url().'admissionListing'?>'"class="btn btn-default" value="BACK" />
                                            </div>
                                    </div>
                              </div>
                              <form>
                    <?php echo form_close(); ?>
            </div>
        </div>    
    </div>    
