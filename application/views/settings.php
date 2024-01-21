<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS (Optional: You can include Popper.js if needed) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                <div class="ibox-title">Settings</div>
            </div>
            <div class="ibox-body">
            
            <div class="container mt-5">
                <ul class="nav nav-tabs" id="myTabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home">Whatsapp API configuration</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact">Contact</a>
                    </li> -->
                </ul>

                <div class="tab-content mt-2">
                    <div class="tab-pane fade show active" id="home">
                        <!-- <b>Whatsapp API Credentials</b> -->
                        <div class="row col-md-12 col-sm-12 col-xs-12">

                            <?php
                                $attributes = array("name"=>"save_whtapsapp_config_tab","id"=>"save_whtapsapp_config_tab","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                                echo form_open("", $attributes);
                            ?>
                         
                           <div class="col-md-6 col-sm-6 col-xs-12">

                                <input autocomplete="off" autocomplete="off" type="hidden" id="whatsapp_config_id" name="whatsapp_config_id" value="<?=$get_whatsappconfig_setting['id']?>" class="form-control col-md-12 col-xs-12">

                                <div class="form-group">
                                    <label style="text-align: left;"  for="instance_id">INSTANCE_ID<span class="required">*</span>
                                    </label>
                                    <div >
                                        <input autocomplete="off" autocomplete="off" type="text" id="instance_id" name="instance_id" placeholder="Enter INSTANCE ID" value="<?=$get_whatsappconfig_setting['INSTANCE_ID']?>" class="form-control col-md-12 col-xs-12">
                                        <p class="error instance_id_error"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;"  for="access_token">ACCESS_TOKEN<span class="required">*</span>
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="text" id="access_token" name="access_token"  placeholder="Enter ACCESS_TOKEN" value="<?=$get_whatsappconfig_setting['ACCESS_TOKEN']?>" class="form-control col-md-12 col-xs-12">
                                        <p class="error access_token_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                   <button type="submit" id="save_whtapsapp_config" class="btn btn-primary save_whtapsapp_config">Save</button>
                                   <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    </div>

                    <!-- <div class="tab-pane fade" id="profile">
                        <h4>Profile Content</h4>
                        <p>This is the content of the Profile tab.</p>
                    </div>

                    <div class="tab-pane fade" id="contact">
                        <h4>Contact Content</h4>
                        <p>This is the content of the Contact tab.</p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
  