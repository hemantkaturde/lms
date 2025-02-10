<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">


                <button type="button" class="btn btn-primary">
                    <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i
                            class="fa fa-arrow-left"></i> Back</a>
                </button>
                <div class="ibox-title">Admission Listing</div>
                <!-- <a class="btn btn-primary text-white" onclick="users(0)"><i class="fa fa-plus"></i> Add User</a> -->
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUsers">
                        <i class="fa fa-plus"></i> Add User
                    </button> -->
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <table width="100%" class="table table-bordered" id="admissionList">
                        <thead>
                            <tr>
                                <th>Enquiry Id</th>
                                <th>Mobile No/Roll No</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Courses</th>
                                <th>Admission Status</th>
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


    <div class="modal fade" id="updatecancleModal" tabindex="-1" role="dialog" aria-labelledby="updatecancleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="updatecancleModalLabel" style="color: black;!important">Admission Cancel</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <!-- Registration form -->
            <form id="cancel_admissiom_form" name="cancel_admissiom_form">

            <input type="hidden" id="selected_record_id" name="selected_record_id">
                <div class="form-group">
                    <label class="col-sm-4 col-form-label" style="margin-left: -13px;!important"><b>Select Reason</b><span class="required">*</span></label>
                        <select class="form-control" name="cancle_status" id="cancle_status">
                            <option  value="">Select Reason</option>
                            <option  value="Change Of course">Change of course </option>
                            <option  value="Exchange of services & products">Exchange of services & products </option>
                            <option  value="Cancel for Refund">Cancel for Refund </option>
                            <option  value="Transfer your course">Transfer your course </option>
                        </select>
                        <p class="error assign_team_error"></p>
                </div>

                <?php $current_date = date('d-m-Y');  ?>

                <div class="form-group">
                    <label style="margin-left: -13px;!important" class="col-sm-4 col-form-label"><b>Date</b> <span class="required">*</span></label>
                    <input  style="" type="text" class="form-control datepicker" value="<?=$current_date;?>" id="assign_date" name="assign_date">
                    <p class="error assign_team_error"></p>
                </div>

                <div class="form-group">
                    <label style="margin-left: -13px;!important" class="col-sm-4 col-form-label"><b>Remark</b></label>
                        <textarea type="text" class="form-control"  id="remark"  name="remark"></textarea>
                </div>
                
                <button type="button" class="btn btn-primary" id="submit_admissiom_form">Update</button>
                <button type="button" class="btn btn-secondary" id="close_admissiom_form" data-dismiss="modal">Close</button>
            </form>
            </div>
        </div>
        </div>
    </div>
