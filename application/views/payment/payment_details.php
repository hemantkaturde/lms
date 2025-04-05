<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div>
            <button type="button" class="btn btn-primary">
              <a href="<?php echo base_url().'/enquirylisting';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
            </button>
            </div>
                <div class="ibox-title">Payment Details - Enquiry Number <?=$followDataenquiry[0]->enq_number;?>
                    <small>( <?=$followDataenquiry[0]->enq_fullname?> )</small>
                </div>

            
                <!-- <div class="ibox-title">Enquiry Follow Up - <?=$followDataenquiry[0]->enq_number;?> <small>( <?=$followDataenquiry[0]->enq_fullname?> )</small></div>    -->
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <table id="" class="table table-bordered">
                        <tr style="background: #d2ae6d;">
                            <th>Full Name</th>
                            <th>Mobile No</th>
                            <th>Email Id</th>
                            <th>Enquiry Source</th>
                            <th>Enquiry Date</th>
                            <th>Doctor / Non- Doctor</th>
                        </tr>
                        <tr>
                            <td><?=$followDataenquiry[0]->enq_fullname ?></td>
                            <td><?=$followDataenquiry[0]->enq_mobile ?></td>
                            <td><?=$followDataenquiry[0]->enq_email ?></td>
                            <td><?=$followDataenquiry[0]->enq_source ?></td>
                            <td><?=$followDataenquiry[0]->enq_date ?></td>
                            <td><?=$followDataenquiry[0]->doctor_non_doctor ?></td>
                        </tr>
                    </table>
                    <table id="" class="table table-bordered">
                        <tr style="background: #d2ae6d;">
                            <th>Selected Course</th>
                        </tr>
                        <tr>
                            <td><?php
                     $course_ids    =   explode(',', $followDataenquiry[0]->enq_course_id);
                     $total_fees = 0;
                     $course_name = '';
                     $i = 1;
                     foreach($course_ids as $id)
                     {
                         $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                         if($get_course_fees){
                             
                             $total_fees += $get_course_fees[0]->course_total_fees;
                             $course_name .= $i.') '.$get_course_fees[0]->course_name.'&nbsp&nbsp( Rs '.$get_course_fees[0]->course_total_fees. ') <br> <br> ';  
                             $i++;   
                     
                         }else{
                     
                             $total_fees = '';
                             $course_name = '';  
                             $i++;  
                         }
                         
                     }
                     $all_course_name = trim($course_name, ', '); 
                            
                     echo '<p>'.$all_course_name .'</p>'; 
                    //  echo '<p>'.'<b><H4 style="color: #d2ae6d;">Total Fees</b> :'.' ₹ '.$total_fees .'</H4></p>'; 
                     ?></td>
                        </tr>
                    </table>
                    <div>
                            <?php
                                $attributes = array("name"=>"update_enquiry_form","id"=>"update_enquiry_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                                echo form_open("", $attributes);
                            ?>
                        <div class="box-body">
                            <div class="row col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-12"
                                    style="padding: 15px;box-shadow: 10px 5px 5px #d2ae6d;border: 1px solid #d2ae6d;">
                                    <div class="form-group">
                                        <label style="text-align: left;" for="total_amount">Total Amount
                                        </label>
                                        <input autocomplete="off" autocomplete="off" maxlength="100" type="number"
                                            id="total_amount" name="total_amount"
                                            value="<?php echo $followDataenquiry[0]->total_payment; ?>"
                                            class="form-control col-md-12 col-xs-12" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;" for="discounted_amount">Discounted Amount
                                        </label>
                                        <input autocomplete="off" autocomplete="off" maxlength="100" type="number"
                                            id="discounted_amount" name="discounted_amount"
                                            value="<?php echo $followDataenquiry[0]->discount_amount; ?>"
                                            class="form-control col-md-12 col-xs-12">
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;" for="total_benifit">Total Benefit
                                        </label>
                                        <input autocomplete="off" autocomplete="off" maxlength="100" type="number"
                                            id="total_benifit" name="total_benifit"
                                            value="<?php echo $followDataenquiry[0]->total_benifit; ?>"
                                            class="form-control col-md-12 col-xs-12" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label style="text-align: left;" for="final_student_amount">Final Amount
                                        </label>
                                        <input autocomplete="off" autocomplete="off" maxlength="100" type="number"
                                            id="final_student_amount" name="final_student_amount"
                                            value="<?php echo $followDataenquiry[0]->final_amount; ?>"
                                            class="form-control col-md-12 col-xs-12" readonly>

                                        <input type="hidden" id="enquiry_id" name="enquiry_id"
                                            value="<?php echo $followDataenquiry[0]->enq_id ; ?>"
                                            class="form-control col-md-12 col-xs-12" readonly>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" id="update_discount"
                                            class="btn btn-primary update_discount">Update Discount</button>
                                            <button type="button" class="btn btn-primary">
                                                <a href="<?php echo base_url().'/enquirylisting';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                                            </button>
                                    </div>

                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-12">

                                    <div class="container-fluid">
                                        <div class="row mt-6 ">
                                            <div class="col-3 mx-auto">
                                                <div class="card card-body card-buttons" style="text-align: center;">
                                                    <div>
                                                        <h4 style="color: #d2ae6d;">
                                                            <b><?='₹ '.$followDataenquiry[0]->final_amount;?></b></h4>
                                                        Total Payment
                                                    </div>

                                                </div>
                                            </div>

                                            <?php 
                                                if(!empty($gettotalpaidEnquirypaymentInfo[0]->totalpaidAmount)){
                                                    $totalpaidAmount =  $gettotalpaidEnquirypaymentInfo[0]->totalpaidAmount;
                                                }else{
                                                    $totalpaidAmount = 0;  
                                                }  
                                            ?>

                                            <div class="col-3 mx-auto">
                                                <div class="card card-body card-buttons payment_box"
                                                    style="text-align: center;">
                                                    <div>
                                                        <h4 style="color: #d2ae6d;">
                                                            <b><?='₹ '.$totalpaidAmount;?></b></h4>
                                                        Total Received
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-3 mx-auto">
                                                <div class="card card-body card-buttons payment_box"
                                                    style="text-align: center;">
                                                    <div>
                                                        <h4 style="color: #d2ae6d;">
                                                            <b><?='₹ '.$followDataenquiry[0]->final_amount -  $totalpaidAmount;?></b></h4>
                                                        Pending Payment
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-3 mx-auto">
                                                <div class="card card-body card-buttons payment_box"
                                                    style="text-align: center;">
                                                    <?php 
                                                    $pending_amount = $followDataenquiry[0]->final_amount -  $totalpaidAmount;
                                                    if($pending_amount > 0){ ?>
                                                        
                                                        <a style='cursor: pointer;' class='send_payment_link' data-id=<?php echo $followDataenquiry[0]->enq_id;?>>
                                                            <div>
                                                                <h4 style="color: #d2ae6d;"><i class="fa fa-paper-plane-o"   aria-hidden="true"></i></h4>Payment Link
                                                            </div>
                                                        </a>
                                                    <?php }else{ ?>
                                                        <div>
                                                            <h4 style="color: #d2ae6d;"><i class="fa fa-wpforms"   aria-hidden="true"></i></a></h4>All Payment Done
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-6 ">
                                        <div class="col-12 mx-auto">
                                            <div >
                                                 <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <label for="" style="margin-top:15px;color: #d2ae6d"> <h4><b>All Transaction List</b><h4></label>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="text-align: end;" >
                                                       
                                                    <?php if(!empty($gettotalpaidEnquirypaymentInfo[0]->totalpaidAmount)){ ?>

                                                        <button type="button"  style="margin-top:10px" data-id="<?php echo $followDataenquiry[0]->enq_id ; ?>" class="btn btn-primary send_manual_admission_link" >
                                                           <i class="fa fa-money"></i> Send Admission Link
                                                        </button>

                                                     <?php }else{ ?>
                                                        <button type="button"  style="margin-top:10px" data-id="<?php echo $followDataenquiry[0]->enq_id ; ?>" class="btn btn-primary send_manual_admission_link" disabled>
                                                           <i class="fa fa-money"></i> Send Admission Link
                                                        </button>

                                                     <?php } ?>


                                                    <?php $pending_amount = $followDataenquiry[0]->final_amount -  $totalpaidAmount;
                                                      if($pending_amount > 0){ ?>
                                                        <button type="button"  style="margin-top:10px"  class="btn btn-primary" data-toggle="modal" data-target="#add_payment" >
                                                           <i class="fa fa-money"></i> Add Payment
                                                        </button>
                                                    <?php }else{ ?>
                                                        <button type="button"  style="margin-top:10px"  class="btn btn-primary" data-toggle="modal" data-target="#add_payment" disabled>
                                                           <i class="fa fa-money"></i> Add Payment
                                                        </button>
                                                    <?php } ?> 
                                                    </div>
                                                </div>
                                            </div>

                                            <table id="" class="table table-striped ">
                                                <tr style="">
                                                    <th>Payment Date</th>
                                                    <th>Transaction Id</th>
                                                    <th>Amount</th>
                                                    <th>Payment Mode</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                               
                                                <?php  foreach ($getEnquirypaymentInfo as $paymentkey => $paymentvalue) { 
                                                    if($paymentvalue->payment_status=='1'){
                                                        $status='Completed';
                                                    }

                                                    if($paymentvalue->razorpay_payment_id!=NULL){
                                                        $transaction_id = $paymentvalue->razorpay_payment_id;
                                                        $payment_date = $paymentvalue->datetime;
                                                    }else{
                                                        $transaction_id = 'Manual-Transaction';
                                                        $payment_date = $paymentvalue->payment_date;
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?=$payment_date?></td>
                                                        <td><?=$transaction_id?></td>
                                                        <td><?='₹ '.$paymentvalue->totalAmount?></td>
                                                        <td><?=$paymentvalue->payment_mode?></td>
                                                        <td><?=$status?></td>
                                                        <td>
                                                            <a style='cursor: pointer;' class='view_enquiry_tarnsaction' data-toggle="modal" data-target="#view_enquiry_tarnsaction"   data-id="<?php echo $paymentvalue->id ?>"><img width='20' src="<?php echo ICONPATH."/view_doc.png";?>" alt='View Transaction' title='View Transaction'></a>
                                                            <a style='cursor: pointer;'  href='<?php echo base_url();?>tax_invoice/index.php?enq_id=<?=$enquiry_id;?>&paymentid=<?php echo $paymentvalue->id ?>' target='_blank'  class='print_tax_invoices' data-id=""><img width='20' src="<?php echo ICONPATH; ?>/print.png" alt='Print Invoice' title='Print Invoice'></a>
                                                            <a style='cursor: pointer;' class='delete_enquiry_tarnsaction' data-id="<?php echo $paymentvalue->id ?>"><img width='20' src="<?php echo ICONPATH."/delete.png"; ?>" alt='Delete Transaction' title='Delete Transaction'></a> 
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>


            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <table id="" class="table table-bordered">
                        <tr style="background: #d2ae6d;">
                            <th>Add On Course</th>
                        </tr>
                    </table>

                    <table id="" class="table table-bordered">
                        <tr style="background: #d3d5c3;">
                            <th>Course Name</th>
                            <th>Course Added DateTime</tthd>
                            <th>Course Amount</th>
                            <th>Discount</th>
                            <th>Final Amount</th>
                            <th>Total Paid Amount</th>
                            <th>Total Pending Amount</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($getadditionalInfo as $getadditionalInfokey => $getadditionalInfokeyvalue) { ?>
                            <tr>
                                <td><?=$getadditionalInfokeyvalue['course_name'] ?></td>
                                <td><?=$getadditionalInfokeyvalue['addoncoursedatetime'] ?></td>
                                <td> ₹ <?=$getadditionalInfokeyvalue['course_total_fees'] ?></td>
                                <td> ₹ <?=$getadditionalInfokeyvalue['discount'] ?></td>
                                <?php 
                                    $total_amount_after_discount = $getadditionalInfokeyvalue['course_total_fees']-$getadditionalInfokeyvalue['discount'];
                                    // $total_paid = 0;
                                    $CI =& get_instance();
                                    $CI->load->model('enquiry_model');
                                    $result_of_total_paid = $CI->enquiry_model->gettotalpaidamountof_add_on_course(trim($getadditionalInfokeyvalue['addoncourse_id']),trim($getadditionalInfokeyvalue['enquiry_id']));
                                    $total_paid = $result_of_total_paid[0]->totalpaidamount;
                                    $total_pending_amount = $total_amount_after_discount - $total_paid;
                                ?>
                                <td> ₹ <?=$total_amount_after_discount;?></td>


                                <td> ₹ <?=$total_paid ?></td>
                                <td> ₹ <?=$total_pending_amount?></td>
                                <td>
                                    <a style='cursor: pointer;' class='add_discount_tarnsaction' id='add_discount_tarnsaction' data-toggle="modal" data-target="#add_discount_tarnsaction"   course-name="<?php echo $getadditionalInfokeyvalue['course_name'] ?>"  data-id="<?php echo $getadditionalInfokeyvalue['addoncourse_id']?>"><img width='20' src="<?php echo ICONPATH."/discount.png";?>" alt='View Transaction' title='View Transaction'></a>
                                    <a style='cursor: pointer;'  href='<?php echo base_url();?>viewaddoncoursepaymentdetails/<?=$getadditionalInfokeyvalue['addoncourse_id']?>' class='add_on_course_payment_details' data-id=""><img width='20' src="<?php echo ICONPATH; ?>/payment.png" alt='Add On Course Payment Details' title='Add On Course Payment Details'></a>
                                </td>
                            </tr>
                        <?php }  ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->



    <!-- Add New Course Modal -->
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
                                            name="enquiry_number" value="<?php echo $followDataenquiry[0]->enq_number;?>"
                                            class="form-control col-md-12 col-xs-12" readonly>

                                            <input autocomplete="off" autocomplete="off" type="hidden" id="enquiry_id"
                                            name="enquiry_id" value="<?php echo $followDataenquiry[0]->enq_id;?>"
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
                                                <option value="Payment Geteway">Payment Gateway</option>
                                                <option value="Swipe">Swipe</option>
                                                <option value="Cheque">Cheque</option>
                                                <!-- <option value="Cash">Cash</option> -->
                                                <option value="Fee">Fee</option>
                                                <option value="Loan">Loan</option>
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


    <!-- Add New Course Modal -->
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

      <!-- Add New Course Modal -->
    <div class="modal fade" id="add_discount_tarnsactionmodal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="add_discount_tarnsactionmodal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add Discount - <span id="course_name"></span>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                        <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="discount_amount">Discount Amount<span
                                            class="required">*</span>
                                    </label>
                                        <input autocomplete="off" autocomplete="off" type="hidden" id="add_discount_tarnsaction_id" name="add_discount_tarnsaction_id" class="form-control col-md-12 col-xs-12">
                                        <input autocomplete="off" autocomplete="off" type="number" id="discount_amount" name="discount_amount" class="form-control col-md-12 col-xs-12">
                                        <p class="error discount_amount_error"></p>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="add_addon_discount_payment_submit" class="btn btn-primary add_addon_discount_payment_submit">Add Discount</button>
                </div>
            </div>
        </div>
    </div>



    