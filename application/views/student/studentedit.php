<?php

$student_id = '';
$name = '';
$email = '';
$mobile = '';
$username = '';
$password = '';
$c_password = '';
$profile_pic = '';

if(!empty($student_infromation))
{
    foreach ($student_infromation as $rf)
    {
        $studentid = $rf->userId;
        $name = $rf->name;
        $email = $rf->email;
        $mobile = $rf->mobile;
        $username = $rf->username;
        $password = $rf->password;
        $c_password =$rf->password;
        $profile_pic = $rf->profile_pic;
    }
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-content fade-in-up col-md-8">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Edit Student</div>
            </div>
            <div class="ibox-body">
                <?php
                        $attributes = array("name"=>"update_staudent_form","id"=>"update_staudent_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);
                        
                    ?>
                <form role="form" id="enquiry_form">
                    <div class="row">
                        <!-- <div class="col-md-12"> -->
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label style="text-align: left;" for="full_name">Full Name<span
                                                        class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="full_name" name="full_name" placeholder="Enter Full name Name" value="<?php echo $name;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error full_name_error"></p>
                                                    <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="mobile_number">Telephone No / Mobile Number<span
                                                        class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number" value="<?php echo $mobile;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error mobile_number_error"></p>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label style="text-align: left;" for="password">Password<span class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="password" placeholder="Enter Password" name="password" value="<?php echo $password ;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error password_error"></p>
                                                </div>
                                            </div>

                                                                                        
                                            <div class="form-group">
                                                <label style="text-align: left;" for="profile_photo1">Profile Pic</label>
                                                <input type="file" id="profile_photo1" name="profile_photo1" class="form-control"
                                                    ccept="image/*" onchange="loadFile(event)">
                                                <small class="text-default">( Upload photo as Show on Admin Panel)</small>
                                                <input type="text" id="existing_img" name="existing_img" value="<?=$profile_pic?>" >
                                                <p><img id="output" name="exsting_img" width="80" height="80" /></p>
                                            </div>


                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label style="text-align: left;" for="email">Email <span
                                                        class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="email" name="email" placeholder="Enter Email" value="<?php echo $email;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error email_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="username">Username<span
                                                        class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" type="text" id="username" name="username" placeholder="Enter Username" value="<?php echo $username;?>" class="form-control col-md-12 col-xs-12">
                                                    <p class="error username_error"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align: left;" for="confirm_password">Confirm Password<span class="required">*</span>
                                                </label>
                                                <div>
                                                    <input autocomplete="off" autocomplete="off" value="<?php echo $c_password ;?>"  type="text" id="confirm_password" placeholder="Enter Confirm Password" name="confirm_password" class="form-control col-md-12 col-xs-12">
                                                    <p class="error confirm_password_error"></p>
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
                                <!-- <input type="button" onclick="location.href='<?php echo base_url().'enquirylisting'?>'"
                                    class="btn btn-default" value="CANCEL" /> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>