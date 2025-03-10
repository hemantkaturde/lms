<?php $roleText = $this->session->userdata('roleText');?>
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
                <!-- <div class="ibox-tools"> -->
                    <!-- <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a> -->
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <div class="ibox-title">Inquiry Leads Report</div>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label style="margin-left: -13px;!important" class="col-sm-12 col-form-label"><b>Search By Student</b></label>
                                    <select class="form-control select2 search_by_student" id="search_by_student" name="search_by_student">
                                            <option value="">Select Student</option>
                                            <?php foreach ($getUserList as $key => $value) { ?>
                                            <option value="<?php echo $value->enq_id; ?>">
                                                <?php echo $value->enq_fullname.' - '.$value->enq_mobile; ?></option>
                                            <?php } ?>
                                    </select>
                                    <p class="error search_by_student_error"></p>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label style="margin-left: -13px;!important" class="col-sm-12 col-form-label"><b>Search By Counsellor</b></label>
                                    <select class="form-control select2" id="search_by_consellor" name="search_by_consellor">
                                            <option value="">Select Counsellor</option>
                                            <?php foreach ($getCounsellorList as $key => $value) { ?>
                                            <option value="<?php echo $value->userId; ?>">
                                                <?php echo $value->name.' - '.$value->mobile; ?></option>
                                            <?php } ?>
                                    </select>
                                <p class="error search_by_consellor_error"></p>
                            </div>
                        </div>


                        <div class="col-sm">
                           <div class="form-group">
                                <label style="margin-left: -13px;!important" class="col-sm-12 col-form-label"><b>From Date</b></label>
                                <input  style="" type="text" class="form-control datepicker" id="from_date" name="from_date">
                                <p class="error from_date_error"></p>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label style="margin-left: -13px;!important" class="col-sm-12 col-form-label"><b>To Date</b></label>
                                <input  style="" type="text" class="form-control datepicker" id="to_date" name="to_date">
                                <p class="error to_date_error"></p>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <button type="button" style="margin-top:30px !important" class="btn btn-primary" id="excel_export_report_enquiry_leads">Excel Export</button>
                            </div>
                        </div>
                    </div>
                 <table id="view_enquirylist_report" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Inquiry No.</th>
                            <th>Inquiry Date</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Courses</th>
                            <th>Counsellor</th>
                            <th>Status</th>
                            <!-- <th>Fees</th> -->
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

<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> 


<!-- <script>
    $('.select2').select2();
</script> -->