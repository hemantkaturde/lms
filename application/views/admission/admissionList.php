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