<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Email SMTP Management</div>
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="btn btn-primary text-white" onclick="email_smtp(0)"><i class="fa fa-plus"></i> Add SMTP</a> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmailSMTP">
                    <i class="fa fa-plus"></i> Add Course Type
                </button>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="smtpsettingList">
                        <thead>
                            <tr>
                                <th>SMTP Host</th>
                                <th>SMTP Port</th>
                                <th>SMTP Protocol</th>
                                <th>SMTP Username</th>
                                <th>SMTP Password</th>
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

<!-- Add New SMTP Setting Modal -->
<div class="modal fade" id="addEmailSMTP" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addEmailSMTPLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New SMTP Configuration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"email_smtp_form","id"=>"email_smtp_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
        <div class="modal-body">
                <div class="container">
                    <div class="row col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label style="text-align: left;"  for="smtp_host">SMTP Host<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="smtp_host" name="smtp_host"  placeholder="Enter SMTP Host" class="form-control col-md-12 col-xs-12">
                                    <p class="error smtp_host_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="smtp_port">SMTP Port<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="smtp_port" name="smtp_port"  placeholder="Enter SMTP Port" class="form-control col-md-12 col-xs-12">
                                    <p class="error smtp_port_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="protocol">Authentication / Protocal (TLS/SSL)<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="protocol" name="protocol"  placeholder="Enter Protocol" class="form-control col-md-12 col-xs-12">
                                    <p class="error protocol_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="smtp_username">SMTP Username<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="smtp_username" name="smtp_username"  placeholder="Enter SMTP Username" class="form-control col-md-12 col-xs-12">
                                    <p class="error smtp_username_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="smtp_password">SMTP Password<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="smtp_password" name="smtp_password"  placeholder="Enter SMTP Host" class="form-control col-md-12 col-xs-12">
                                    <p class="error smtp_password_error"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label style="text-align: left;"  for="from_name">Set From Name<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="from_name" name="from_name"  placeholder="Enter From Name" class="form-control col-md-12 col-xs-12">
                                    <p class="error from_name_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="email_name">Email Name<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="email_name" name="email_name"  placeholder="Enter Email Name" class="form-control col-md-12 col-xs-12">
                                    <p class="error email_name_error"></p>
                                </div>
                            </div> 
                            
                            <div class="form-group">
                                <label style="text-align: left;"  for="cc_email">CC Email
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="cc_email" name="cc_email"  placeholder="Enter CC Email" class="form-control col-md-12 col-xs-12">
                                    <p class="error cc_email_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="bcc_email">BCC Email
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="bcc_email" name="bcc_email"  placeholder="Enter BCC Email" class="form-control col-md-12 col-xs-12">
                                    <p class="error bcc_email_error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>            <button type="submit" id="save_smtp_setting" class="btn btn-primary save_smtp_setting">Save</button>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>


<!-- Edit SMTP Setting Modal -->
<div class="modal fade" id="editEmailSMTP" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="editEmailSMTPLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Edit SMTP Configuration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"edit_email_smtp_form","id"=>"edit_email_smtp_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
        <div class="modal-body">
                <div class="container">
                    <div class="row col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label style="text-align: left;"  for="smtp_host">SMTP Host<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="hidden" id="smtpId" name="smtpId">
                                    <input autocomplete="off" autocomplete="off"  type="text" id="smtp_host1" name="smtp_host"  placeholder="Enter SMTP Host" class="form-control col-md-12 col-xs-12">
                                    <p class="error smtp_host_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="smtp_port">SMTP Port<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="smtp_port1" name="smtp_port"  placeholder="Enter SMTP Port" class="form-control col-md-12 col-xs-12">
                                    <p class="error smtp_port_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="protocol">Authentication / Protocal (TLS/SSL)<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="protocol1" name="protocol"  placeholder="Enter Protocol" class="form-control col-md-12 col-xs-12">
                                    <p class="error protocol_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="smtp_username">SMTP Username<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="smtp_username1" name="smtp_username"  placeholder="Enter SMTP Username" class="form-control col-md-12 col-xs-12">
                                    <p class="error smtp_username_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="smtp_password">SMTP Password<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="smtp_password1" name="smtp_password"  placeholder="Enter SMTP Host" class="form-control col-md-12 col-xs-12">
                                    <p class="error smtp_password_error"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label style="text-align: left;"  for="from_name">Set From Name<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="from_name1" name="from_name"  placeholder="Enter From Name" class="form-control col-md-12 col-xs-12">
                                    <p class="error from_name_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="email_name">Email Name<span class="required">*</span>
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="email_name1" name="email_name"  placeholder="Enter Email Name" class="form-control col-md-12 col-xs-12">
                                    <p class="error email_name_error"></p>
                                </div>
                            </div> 
                            
                            <div class="form-group">
                                <label style="text-align: left;"  for="cc_email">CC Email
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="cc_email1" name="cc_email"  placeholder="Enter CC Email" class="form-control col-md-12 col-xs-12">
                                    <p class="error cc_email_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;"  for="bcc_email">BCC Email
                                </label>
                                <div >
                                    <input autocomplete="off" autocomplete="off"  type="text" id="bcc_email1" name="bcc_email"  placeholder="Enter BCC Email" class="form-control col-md-12 col-xs-12">
                                    <p class="error bcc_email_error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>            <button type="submit" id="update_smtp_setting" class="btn btn-primary update_smtp_setting">Save</button>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

