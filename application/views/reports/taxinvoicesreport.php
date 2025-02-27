<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                <div class="ibox-title">Tax Invoices Report</div>
            </div>
            <div class="ibox-body">
            <div class="row" style="margin-left:4px">
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
                                <button type="button" style="margin-top:30px !important" class="btn btn-primary" class="excel_export_report_tax_invoice" id="excel_export_report_tax_invoice">Excel Export</button>
                            </div>
                        </div>
                    </div>

                    <table id="tax_invoices_report" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Receipt. No</th>
                                <th>Enquiry No</th>
                                <th>Receipt Date</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <!-- <th>Amount</th> -->
                                <th>Fees Amount Paid</th>
                                <!-- <th>Paid Before</th> -->
                                <th>Fees Paid Before</th>
                                <!-- <th>Total Amount</th> -->
                                <th>Total Fees</th>
                                <!-- <th>Amount Balance</th> -->
                                <th>Balance Fees</th>
                                <th>Mode</th>
                                <th>Invoice Type</th>
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