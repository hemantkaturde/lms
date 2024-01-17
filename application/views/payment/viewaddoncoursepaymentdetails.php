<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_payment" >
                        <i class="fa fa-money"></i> Add Payment
                    </button>
                    <button type="button" class="btn btn-primary">
                        <a style='cursor: pointer;' class='send_payment_link_add_on_course' data-id=<?php echo $getaddoncoursedetails['enq_id'];?>  add-on-data-id=<?php echo $getaddoncoursedetails['add_on_course_id'];?> > Payment Link</a>    
                    </button>                          
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/payment_details/'.$getaddoncoursedetails['enq_id'];?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                <div class="ibox-title">Add on Course Payment Details - Enquiry Number <?=$getaddoncoursedetails['enq_number_enq'];?>
                    <small>( <?=$getaddoncoursedetails['course_name']?> )</small>
                </div>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                <table id="view_add_on_courses_payment" class="table table-bordered">
                    <thead>
                            <tr>
                                <th>Payment Date</th>
                                <th>Transaction Id</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
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



    <!-- Add New Manul Payment Details -->
    <div class="modal fade" id="add_payment" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="add_paymentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"add_paynent_form","id"=>"add_paynent_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="enquiry_number">Enquiry Number<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="text" id="enquiry_number"
                                            name="enquiry_number" value="<?php echo $getaddoncoursedetails['enq_number_enq'];?>"
                                            class="form-control col-md-12 col-xs-12" readonly>

                                            <input autocomplete="off" autocomplete="off" type="hidden" id="enquiry_id"
                                            name="enquiry_id" value="<?php echo $getaddoncoursedetails['enq_id'];?>"
                                            class="form-control col-md-12 col-xs-12" readonly>

                                            <input autocomplete="off" autocomplete="off" type="hidden" id="add_on_course_id"
                                            name="add_on_course_id" value="<?php echo $getaddoncoursedetails['add_on_course_id'];?>"
                                            class="form-control col-md-12 col-xs-12" readonly>

                                        <p class="error enquiry_number_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;"  for="payment_mode">Payment Mode<span class="required">*</span>
                                    </label>
                                        <select class="form-control" id="payment_mode" name="payment_mode">
                                                <option value="">Select Payment Mode</option>
                                                <!-- <option value="">Invoice</option> -->
                                                <option value="NEFT">NEFT</option>
                                                <option value="IMPS">IMPS</option>
                                                <option value="RTGS">RTGS</option>
                                                <option value="Payment Geteway">Payment Geteway</option>
                                                <option value="Swipe">Swipe</option>
                                                <option value="Cheque">Cheque</option>
                                                <!-- <option value="Cash">Cash</option> -->
                                                <option value="Fee">Fee</option>
                                        </select>
                                        <p class="error payment_mode_error"></p>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="manual_payment_amount">Amount<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="number" id="manual_payment_amount"
                                            name="manual_payment_amount"   placeholder="Enter Amount"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error manual_payment_amount_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="description">Description
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="text" id="description"
                                            name="description"  placeholder="Enter Description" maxlength="50"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error description_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="payment_date">Payment Date<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input type="datetime-local" class="form-control" id="payment_date" name="payment_date" placeholder="dd-mm-yyyy" autocomplete="off" required>

                                        <p class="error payment_date_error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label style="text-align: left;" for="cheuqe_number">Cheque Number
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="text" id="cheuqe_number"
                                            name="cheuqe_number" placeholder="Cheque Number"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error cheuqe_number_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="bank_name">Drawn on Bank
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="text" id="bank_name"
                                            name="bank_name"  placeholder="Enter Bank Name"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error bank_name_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="prepared_by">Prepared By
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="text" id="prepared_by"
                                            name="prepared_by"   placeholder="Prepared By"
                                            class="form-control col-md-12 col-xs-12"> 
                                        <p class="error prepared_by_error"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="add_manual_payment" class="btn btn-primary add_manual_payment">Add Payment</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>


    <!-- View Manual Payment -->
    <div class="modal fade" id="view_enquiry_tarnsaction" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="view_enquiry_tarnsactionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">View Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="enquiry_number">Enquiry Number
                                    </label>
                                           <input autocomplete="off" autocomplete="off" type="text" id="enquiry_number_detail"
                                            name="enquiry_number_detail" 
                                            class="form-control col-md-12 col-xs-12" readonly>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;"  for="payment_mode_detail">Payment Mode
                                    </label>
                                    <input autocomplete="off" autocomplete="off" type="text" id="payment_mode_detail"
                                            name="payment_mode_detail" 
                                            class="form-control col-md-12 col-xs-12" readonly>
                                </div>


                                <div class="form-group">
                                    <label style="text-align: left;" for="description">Description
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="text" id="description1"
                                            name="description1"  placeholder="Enter Description" maxlength="50"
                                            class="form-control col-md-12 col-xs-12" readonly>
                                        <p class="error description_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="manual_payment_amount_details">Amount
                                    </label>
                                    <input autocomplete="off" autocomplete="off" type="text" id="manual_payment_amount_details"
                                            name="manual_payment_amount_details" 
                                            class="form-control col-md-12 col-xs-12" readonly>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" for="payment_date_details">Payment Date
                                    </label>
                                    <input autocomplete="off" autocomplete="off" type="text" id="payment_date_details"
                                            name="payment_date_details" 
                                            class="form-control col-md-12 col-xs-12" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label style="text-align: left;" for="cheuqe_number_detials">Cheque Number
                                    </label>
                                    <input autocomplete="off" autocomplete="off" type="text" id="cheuqe_number_detials"
                                            name="cheuqe_number_detials" 
                                            class="form-control col-md-12 col-xs-12" readonly>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="bank_name_details">Drawn on Bank
                                    </label>
                                    <input autocomplete="off" autocomplete="off" type="text" id="bank_name_details"
                                            name="bank_name_details" 
                                            class="form-control col-md-12 col-xs-12" readonly>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="prepared_by_details">Prepared By
                                    </label>
                                    <input autocomplete="off" autocomplete="off" type="text" id="prepared_by_details"
                                            name="prepared_by_details" 
                                            class="form-control col-md-12 col-xs-12" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

