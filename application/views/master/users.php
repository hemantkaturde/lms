<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">

                <div>
                    <!-- <a class="btn btn-primary text-white" onclick="users(0)"><i class="fa fa-plus"></i> Add User</a> -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUsers">
                        <i class="fa fa-plus"></i> Add User
                    </button>

                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                
                <div class="ibox-title">Users Listing</div>

            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <table class="table table-bordered" id="userList">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Mobile No</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->

    <!-- Add New User Modal -->
    <div class="modal fade" id="addUsers" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="addUsersLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"user_form","id"=>"user_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data", "autocomplete"=>"off"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="name">Name<span class="required">*</span>
                                    </label>
                                    <div>
                                        <input type="hidden" name="user_flag" id="user_flag" value="user">
                                        <input type="text" id="name" name="name" autocomplete="off"
                                            placeholder="Enter Full Name Here" class="form-control col-md-12 col-xs-12">
                                        <p class="error name_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="email">Email<span class="required">*</span>
                                    </label>
                                    <div>
                                        <input maxlength="100" type="email" id="email" name="email" autocomplete="off"
                                            placeholder="Enter Email" class="form-control col-md-12 col-xs-12">
                                        <p class="error email_error"></p>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label style="text-align: left;" for="username">Username<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input maxlength="100" type="username" id="username" autocomplete="off"
                                            placeholder="Enter Username" name="username"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error username_error"></p>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label style="text-align: left;" for="password">Password<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input maxlength="100" type="password" id="password" autocomplete="off"
                                            placeholder="Enter Password" name="password"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error password_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="confirm_password">Confirm Password<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input maxlength="100" type="password" id="confirm_password" autocomplete="off"
                                            placeholder="Enter Confirm Password" name="confirm_password"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error confirm_password_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="mobile">Mobile No<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input maxlength="10" type="text" id="mobile" name="mobile" autocomplete="off"
                                            placeholder="Enter 10 Digit Mobile Number"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error mobile_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="role">Role<span class="required">*</span>
                                    </label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="">Select Role</option>
                                        <?php foreach ($role as $key => $value) { ?>
                                        <option value="<?php echo $value->roleId; ?>">
                                            <?php echo ucwords($value->role); ?></option>
                                        <?php } ?>
                                    </select>
                                    <p class="error role_error"></p>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="profile_photo">Profile Pic</label>
                                    <input type="file" id="profile_photo" name="profile_photo" class="form-control"
                                        ccept="image/*" onchange="loadFile(event)">
                                    <small class="text-default">( Upload photo as Show on Admin Panel)</small>
                                    <p><img id="output" width="200" /></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="save_user" class="btn btn-primary save_user">Save</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Update User Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="addUsersLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"update_user_form","id"=>"update_user_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="name1">Name<span class="required">*</span>
                                    </label>
                                    <div>
                                        <input type="hidden" name="user_flag1" id="user_flag1" value="user">
                                        <input type="hidden" name="userId" id="userId">
                                        <input autocomplete="off" autocomplete="off" type="text" id="name1" name="name1"
                                            placeholder="Enter Full Name Here" class="form-control col-md-12 col-xs-12">
                                        <p class="error name1_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="email1">Email<span class="required">*</span>
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" maxlength="100" type="email"
                                            id="email1" name="email1" placeholder="Enter Email"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error email1_error"></p>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label style="text-align: left;" for="username1">Username<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input maxlength="100" type="username1" id="username1" autocomplete="off"
                                            placeholder="Enter Username" name="username1"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error username_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="password1">Password<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" maxlength="100" type="text"
                                            id="password1" placeholder="Enter Password" name="password1"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error password1_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="confirm_password1">Confirm Password<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" maxlength="100" type="text"
                                            id="confirm_password1" placeholder="Enter Confirm Password"
                                            name="confirm_password1" class="form-control col-md-12 col-xs-12">
                                        <p class="error confirm_password1_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="mobile1">Mobile No<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" maxlength="10" type="text"
                                            id="mobile1" name="mobile1" placeholder="Enter 10 Digit Mobile Number"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error mobile1_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="role1">Role<span class="required">*</span>
                                    </label>
                                    <select class="form-control" id="role1" name="role1">
                                        <option value="">Select Role</option>
                                        <?php foreach ($role as $key => $value) { ?>
                                        <option value="<?php echo $value->roleId; ?>">
                                            <?php echo ucwords($value->role); ?></option>
                                        <?php } ?>
                                    </select>
                                    <p class="error role_error"></p>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="profile_photo1">Profile Pic</label>
                                    <input type="file" id="profile_photo1" name="profile_photo1" class="form-control"
                                        ccept="image/*" onchange="loadFile(event)">
                                    <small class="text-default">( Upload photo as Show on Admin Panel)</small>
                                    <input type="hidden" id="existing_img" name="existing_img">
                                    <p><img id="output1" name="exsting_img" width="80" height="80" /></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="update_user" class="btn btn-primary update_user">Update</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>