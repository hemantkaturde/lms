<?php

$userId = '';
$name = '';
$email = '';
$mobile = '';
$roleId = '';

if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId = $uf->userId;
        $name = $uf->name;
        $email = $uf->email;
        $mobile = $uf->mobile;
        $roleId = $uf->roleId;
    }
}
?>
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
        <div class="ibox col-md-8">
            <div class="ibox-head">
                <div class="ibox-title"><?php if(!empty($userInfo)){ echo "Update"; }else{ echo "Add New"; } ?> User</div>
            </div>
            <div class="ibox-body">
               <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->



                <div class="box box-primary">
                    <div class="box-header">
                        <h4 class="box-title">Enter user information</h4>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form id="addNewUser_form"  novalidate="novalidate">
                    <!-- <form role="form" id="addUser" action="<?php echo base_url() ?>addNewUser" method="post" role="form"> -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fname">Name</label>
                                        <input type="text" class="form-control required" value="<?php echo $name; ?>" id="fname" name="fname" maxlength="128" placeholder="Enter Full Name Here" required>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email ID</label>
                                        <input type="text" class="form-control required email" id="email" value="<?php echo $email; ?>" name="email"
                                            maxlength="128" placeholder="Eg. xyz@gmail.com" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control required" id="password" name="password"  placeholder="Enter Password" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">Confirm Password</label>
                                        <input type="password" class="form-control required equalTo" id="cpassword" name="cpassword"  placeholder="Confirm Your Password" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Telephone Number</label>
                                        <input type="text" class="form-control required digits" id="mobile" value="<?php echo $mobile; ?>" name="mobile" placeholder="Enter 10 Digit Mobile Number"
                                            maxlength="10" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control required" id="role" name="role" placeholder="Select Role" required="">
                                            <option value="0">Choose Role</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                <option value="<?php echo $rl->roleId ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>>
                                                    <?php echo $rl->role ?>
                                                </option>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <!-- <button class="btn btn-info" type="submit">Submit</button> -->
                            <button type="button" onclick="<?php if(!empty($userInfo)){ echo "add_update_users(".$userId.")"; }else{ echo "add_update_users(0)"; } ?>" class="btn btn-primary">SUBMIT</button>
                            <a href="<?php echo base_url(); ?>userListing" type="reset" class="btn btn-default" value="CANCEL">CANCEL</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                        </div>
                    </div>
            </div>
        </div>
            </div>
        </div>
    </div>
<!-- END PAGE CONTENT-->

