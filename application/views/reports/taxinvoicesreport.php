<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Tax Invoices Report</div>
            </div>
            <div class="ibox-body">
            <div class="row" style="margin-left:4px">
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
                                <label style="margin-left: -13px;!important" class="col-sm-12 col-form-label"><b>Search By Payment Mode</b></label>
                                    <select class="form-control select2 search_by_payment_mode" id="search_by_payment_mode" name="search_by_payment_mode">
                                            <option value="">Select Payment Mode</option>
                                            <option value="NEFT">NEFT</option>
                                            <option value="IMPS">IMPS</option>
                                            <option value="RTGS">RTGS</option>
                                            <option value="Payment Geteway">Payment Geteway</option>
                                            <option value="Swipe">Swipe</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Fee">Fee</option>
                                            <option value="Loan">Loan</option>
                                    </select>
                                    <p class="error search_by_payment_mode_error"></p>
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

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> 