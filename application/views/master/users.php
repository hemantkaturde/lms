
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
                <div class="ibox-title">Users Listing</div>
                    <!-- <a class="btn btn-primary text-white" onclick="users(0)"><i class="fa fa-plus"></i> Add User</a> -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUsers">
                        <i class="fa fa-plus"></i> Add User
                    </button>
            </div>
            <div class="ibox-body">
                 <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
              <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>
                                </div>
              <?php } ?>
              <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
              <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
                        </div>
              <?php } ?>
              <div class="panel-body table-responsive">
                <table width="100%" class="table table-bordered" id="userList">
                  <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone number</th>
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
<div class="modal fade" id="addUsers" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addUsersLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"user_form","id"=>"user_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
      <div class="modal-body">
            <div class="container">
            <div class="row col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="name">Name<span class="required">*</span>
                     </label>
                     <div>
                        <input type="hidden" name="user_flag" id="user_flag" value="user">
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="name" name="name"  placeholder="Enter Full Name Here" class="form-control col-md-12 col-xs-12">
                        <p class="error name_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="email">Email<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="email" id="email" name="email"  placeholder="Enter Email" class="form-control col-md-12 col-xs-12">
                        <p class="error email_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="password">Password
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="password" id="password"  placeholder="Enter Password" name="password" class="form-control col-md-12 col-xs-12">
                        <p class="error password_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="confirm_password">Confirm Password
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="password" id="confirm_password"  placeholder="Enter Confirm Password" name="confirm_password" class="form-control col-md-12 col-xs-12">
                        <p class="error confirm_password_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="mobile">Telephone No<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="mobile" name="mobile" placeholder="Enter 10 Digit Mobile Number" class="form-control col-md-12 col-xs-12">
                        <p class="error mobile_error"></p>
                     </div>
                   </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="role">Role<span class="required">*</span>
                     </label>
                         <select class="form-control" id="role" name="role">
                           <option value="">Select Role</option>
                           <?php foreach ($role as $key => $value) { ?>
                           <option value="<?php echo $value->roleId; ?>"><?php echo ucwords($value->role); ?></option>
                           <?php } ?>
                        </select>
                        <p class="error role_error"></p>
                  </div>

              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="save_user" class="btn btn-primary save_user">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Update User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addUsersLabel" aria-hidden="true">
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
                     <label style="text-align: left;"  for="name1">Name<span class="required">*</span>
                     </label>
                     <div>
                        <input type="hidden" name="user_flag1" id="user_flag1" value="user">
                        <input type="hidden" name="userId" id="userId">
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="name1" name="name1"  placeholder="Enter Full Name Here" class="form-control col-md-12 col-xs-12">
                        <p class="error name1_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="email1">Email<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="email" id="email1" name="email1"  placeholder="Enter Email" class="form-control col-md-12 col-xs-12">
                        <p class="error email1_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="password1">Password
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="password" id="password1"  placeholder="Enter Password" name="password1" class="form-control col-md-12 col-xs-12">
                        <p class="error password1_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="confirm_password1">Confirm Password
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="password" id="confirm_password1"  placeholder="Enter Confirm Password" name="confirm_password1" class="form-control col-md-12 col-xs-12">
                        <p class="error confirm_password1_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="mobile1">Telephone No<span class="required">*</span>
                     </label>
                     <div >
                        <input autocomplete="off" autocomplete="off" maxlength="20" type="text" id="mobile1" name="mobile1" placeholder="Enter 10 Digit Mobile Number" class="form-control col-md-12 col-xs-12">
                        <p class="error mobile1_error"></p>
                     </div>
                   </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="role1">Role<span class="required">*</span>
                     </label>
                         <select class="form-control" id="role1" name="role1">
                           <option value="">Select Role</option>
                           <?php foreach ($role as $key => $value) { ?>
                           <option value="<?php echo $value->roleId; ?>"><?php echo ucwords($value->role); ?></option>
                           <?php } ?>
                        </select>
                        <p class="error role_error"></p>
                  </div>

              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="update_user" class="btn btn-primary update_user">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>