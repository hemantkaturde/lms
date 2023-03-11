<?php $roleText = $this->session->userdata('roleText');?>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Profile Setting</div>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
              <div class="container">
                <div class="row flex-lg-nowrap">
                <div class="col">
                    <div class="row">
                    <div class="col mb-3">
                         <?php $attributes = array("name"=>"profileupdate_form","id"=>"profileupdate_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
		                	echo form_open("admin/updateprofile", $attributes);
		                 ?> 
                        <div class="card">
                        <div class="card-body">
                            <div class="e-profile">
                            <div class="row">
                                <div class="col-12 col-sm-auto mb-3">
                                <div class="mx-auto" style="width: 140px;">
                                    <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                                    <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">
                                
                                    <!-- <p><img id="output" name="exsting_img_pic" src="" width="80" height="80" /></p> -->

                                    <input type="hidden" id="existing_img" name="existing_img" value="<?php echo $profile_details[0]->profile_pic;?>" >

                                    <!-- <input type="hidden" id="profile_id" name="profile_id" value="<?php echo $profile_details[0]->profile_pic;?>" > -->


                                    <?php if($role_text!="Student"){
                                        if(!empty($this->session->userdata('profile_pic'))){ ?>
                                            <img  src="<?php echo IMGPATH.'/'.$this->session->userdata('profile_pic');?>" id="output"  width="140px"  height="140px"/>
                                    <?php }else{ ?>
                                        <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" id="output" width="140px" height="140px" />
                                    <?php } }else{ 
                                    if(!empty($this->session->userdata('profile_pic'))){ ?>
                                        <img  src="<?php echo IMGPATH_ADMISSION.'/'.$this->session->userdata('profile_pic');?>" id="output"  width="140px" height="140px"/>
                                    <?php }else{ ?>
                                        <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" id="output" width="140px" height="140px" />
                                    <?php } } ?>

                                
                                    </span>
                                    </div>
                                </div>
                                </div>
                                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                <div class="text-center text-sm-left mb-2 mb-sm-0">
                                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?=$profile_details[0]->name;?></h4>
                                    <p class="mb-0"><?=$profile_details[0]->email;?></p>
                                    <div class="text-muted"><small>IICTN-<?=$role_text?></small></div>
                                    <div class="mt-2">
                                        <input type="file" id="profile_photo" name="profile_photo" class="form-control" ccept="image/*" onchange="loadFile(event)" style="display:none;" >  </input>
                                        <button class="btn btn-primary"  onclick="thisFileUpload();" type="button"><i class="fa fa-fw fa-camera"></i><span>Change Photo</span></button>
                                    </div>
                                </div>
                                <div class="text-center text-sm-right">
                                    <span class="badge badge-secondary"><?php echo $role_text; ?></span>
                                    <div class="text-muted"><small>Joined <?=$profile_details[0]->createdDtm;?></small></div>
                                </div>
                                </div>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="" class="active nav-link">Settings</a></li>
                            </ul>
                            <div class="tab-content pt-3">
                                <div class="tab-pane active">
                                <form class="form" novalidate="">
                                    <div class="row">
                                    <div class="col">
                                    <div class="mb-2"><b>Personal Information</b></div>
                                        <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input class="form-control" type="text" id="full_name" name="full_name" placeholder="Full Name" value="<?=$profile_details[0]->name;?>">
                                                <input class="form-control" type="hidden" id="userid" name="userid" value="<?=$this->session->userdata('userId');?>">
                                                <p class="error full_name_error"></p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input class="form-control" type="text" id="username" name="username" placeholder="Enter username" value="<?=$profile_details[0]->username;?>">
                                                <p class="error username_error"></p>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control" type="text" placeholder="Enter Email Id" id="email" name="email"  value="<?=$profile_details[0]->email;?>">
                                                    <p class="error email_error"></p>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Mobile Number</label>
                                                    <input class="form-control" type="text" placeholder="Enter Mobile Number" id="mobile" name="mobile"  value="<?=$profile_details[0]->mobile;?>">
                                                    <p class="error mobile_error"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-12 col-sm-6 mb-3">
                                        <div class="mb-2"><b>Change Password</b></div>
                                        <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                            <label>Current Password</label>
                                                <input autocomplete="off" autocomplete="off" maxlength="20" type="password" id="password" name="password" class="form-control col-md-7 col-xs-12" value="<?php echo trim(base64_decode($profile_details[0]->password)); ?>">
                                                <input type="button" id="showhide" value="Show Password" onclick="if(password.type == 'text'){ password.type = 'password'; showhide.value='Show Password'; }else{ password.type = 'text'; showhide.value='Hide Password'; } return false;"/>
                                                <p class="error password_error"></p>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                            <label>New Password</label>
                                            <input class="form-control" type="password" placeholder="New Password" id="new_password"  name="new_password">
                                            <p class="error new_password_error"></p>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                            <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                                            <input class="form-control" type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password"></div>
                                            <p class="error confirm_password_error"></p>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col d-flex justify-content-end">
                                        <button class="btn btn-primary" id="update_profile" name="update_profile" type="submit">Update Profile</button>
                                    </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>

						<?php echo form_close(); ?>
                    </div>
                    </div>
                </div>
                </div>
                </div>
              </div>
            </div>
    </div>
</div>
<!-- END PAGE CONTENT-->
