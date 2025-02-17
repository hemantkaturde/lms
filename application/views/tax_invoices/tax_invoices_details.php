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
                <div class="ibox-title">Tax Invoices</div>
            </div>




            <div class="ibox-body">

            <div class="row" style="margin-left:4px">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="email">Status</label>
                                        
                                        <p class="error status_error"></p>
                                    </div>
                                </div>

                             
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="email">Status</label>
                                        
                                        <p class="error status_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div style="margin-top:22px">
                                            <!-- <input type="button"  class="btn btn-primary" value="Search" id="search" name="search" /> -->
                                            <input type="button" class="btn btn-primary" value="Export To Excel" id="export_to_excel" name="export_to_excel">
                                        </div>
                                    </div>
                                </div>
                            </div>


                <div class="panel-body table-responsive">
                    <table id="tax_invoices" class="table table-bordered">
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
                                <th>Bill Download</th>
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