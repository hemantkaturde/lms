<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
$roleText = $this->session->userdata('roleText');
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>

                   <?php if($roleText=='Student'){ ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addnewleaverequest">
                        <i class="fa fa-plus"></i> Add New Leave Request
                        </button>
                   <?php }?>
                 

                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                
                <div class="ibox-title">Leave Request</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_leave_request" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Leave Title</th>
                                <th>Leave From Date</th>
                                <th>Leave To Date</th>
                                <th>Description</th>
                                <th>Link</th>
                                <?php if($roleText=='Student'){ ?>
                                <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->




    <!-- Add New Course Modal -->
    <div class="modal fade" id="addnewleaverequest" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="addnewleaverequestLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Leave Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"addnewleaverequest_form","id"=>"addnewleaverequest_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;"  for="leave_title">Leave Title<span class="required">*</span>
                                    </label>
                                    <div>
                                        <input class="form-control" autocomplete="off" autocomplete="off"  type="text" id="leave_title" name="leave_title" Placeholder="Leave Title">
                                        <p class="error leave_title_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;"  for="leave_from_date">Leave From Date<span class="required">*</span>
                                    </label>
                                    <div>
                                        <input class="form-control datepicker" autocomplete="off" autocomplete="off"  type="text" id="leave_from_date" name="leave_from_date" Placeholder="Leave From Date">
                                        <p class="error leave_from_date_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;"  for="leave_to_date">Leave To Date<span class="required">*</span>
                                    </label>
                                    <div>
                                        <input class="form-control datepicker" autocomplete="off" autocomplete="off"  type="text" id="leave_to_date" name="leave_to_date" Placeholder="Leave To Date">
                                        <p class="error leave_to_date_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;"  for="leave_description">Leave Description
                                    </label>
                                    <div >
                                      <textarea class="form-control" id="leave_description" name="leave_description" rows="5" Placeholder="Leave Description"></textarea>                                        
                                      <p class="error leave_description_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;"  for="leave_document">Leave Document
                                    </label>
                                    <div>
                                        <input name="file" id="fileInput" type="file" class="demoInputBox form-control" required/>
                                        <p class="error leave_document_error"></p>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="addnewleaverequestdata" class="btn btn-primary addnewleaverequestdata">Send</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>