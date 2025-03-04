<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">View Attendance Report</div>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label style="margin-left: -13px;!important" class="col-sm-12 col-form-label"><b>Search By Student</b></label>
                                    <select class="form-control select2 search_by_student" id="search_by_student" name="search_by_student">
                                            <option value="">Select Student</option>
                                            <?php foreach ($getAdmissionUserList as $key => $value) { ?>
                                            <option value="<?php echo $value->enq_id; ?>">
                                                <?php echo $value->name.' - '.$value->email.' - '.$value->mobile; ?></option>
                                            <?php } ?>
                                    </select>
                                    <p class="error search_by_student_error"></p>
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
                                <button type="button" style="margin-top:30px !important" class="btn btn-primary" id="excel_export_attendance_report">Excel Export</button>
                            </div>
                        </div>
                    </div>

                <table id="view_attendance_report" class="table table-bordered">
                    <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Mobile No</th>
                                    <th>Email Address</th>
                                    <th>Course Name</th>
                                    <th>Topic Name</th>
                                    <th>Class Duration</th>
                                    <th>Class Attended Date</th>
                                    <th>Class Attended Time</th>
                                    <th>Attendance Status</th>
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



<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> 