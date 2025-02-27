<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Admission Listing</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive">
                <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label style="margin-left: -13px;!important" class="col-sm-12 col-form-label"><b>Seacrh </b></label>
                                <input  style="" type="text" class="form-control"  id="search_by_any" name="search_by_any">
                                <p class="error search_by_any_error"></p>
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
                                <button type="button" style="margin-top:30px !important" class="btn btn-primary" id="excel_export_adminssion_report">Excel Export</button>
                            </div>
                        </div>
                    </div>
                    <table width="100%" class="table table-bordered" id="admissionreportList">
                        <thead>
                            <tr>
                                <th>Enquiry Id</th>
                                <th>Mobile No/Roll No</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Courses</th>
                                <th>Admission Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->