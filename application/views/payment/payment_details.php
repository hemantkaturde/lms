<div class="content-wrapper">
<div class="page-content fade-in-up col-md-12">
   <div class="ibox">
      <div class="ibox-head">
         <!-- <div>
            <button type="button" class="btn btn-primary">
              <a href="<?php echo base_url().'/enquirylisting';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
            </button>
            </div> -->
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
                             $course_name .= $i.') '.$get_course_fees[0]->course_name.'&nbsp&nbsp( Rs '.$get_course_fees[0]->course_total_fees. ') <br> ';  
                             $i++;   
                     
                         }else{
                     
                             $total_fees = '';
                             $course_name = '';  
                             $i++;  
                         }
                         
                     }
                     $all_course_name = trim($course_name, ', '); 
                     
                     echo '<p>'.$all_course_name .'</p>'; 
                     echo '<p>'.'<b>Toal Fees</b> '.'₹ '.$total_fees .'</p>'; 
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
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                           <label style="text-align: left;" for="total_amount">Total Amount
                           </label>
                           <input autocomplete="off" autocomplete="off" maxlength="100"
                              type="number" id="total_amount" name="total_amount"
                              value="<?php echo $total_fees; ?>"
                              class="form-control col-md-12 col-xs-12" readonly>
                        </div>
                        <div class="form-group">
                           <label style="text-align: left;" for="discounted_amount">Discounted Amount
                           </label>
                           <input autocomplete="off" autocomplete="off" maxlength="100"
                              type="number" id="discounted_amount" name="discounted_amount"
                              value="0"
                              class="form-control col-md-12 col-xs-12">
                        </div>
                        <div class="form-group">
                           <label style="text-align: left;" for="total_benifit">Total Benifit
                           </label>
                           <input autocomplete="off" autocomplete="off" maxlength="100"
                              type="number" id="total_benifit" name="total_benifit"
                              value="0"
                              class="form-control col-md-12 col-xs-12">
                        </div>
                        <div class="form-group">
                           <label style="text-align: left;" for="final_student_amount">Final Amount
                           </label>
                           <input autocomplete="off" autocomplete="off" maxlength="100"
                              type="number" id="final_student_amount" name="final_student_amount"
                              value="<?php echo $total_fees; ?>"
                              class="form-control col-md-12 col-xs-12">
                        </div>
                     </div>
                     <div class="col-md-8 col-sm-8 col-xs-12">

                     <div class="container-fluid">
                            <div class="row mt-6 ">
                                    <div class="col-3 mx-auto">
                                        <div class="card card-body card-buttons">
                                             <div> <?=$total_fees;?><br> Total Payment </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="col-3 mx-auto">
                                        <div class="card card-body card-buttons">
                                             <div> Received </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-3 mx-auto">
                                        <div class="card card-body card-buttons">
                                            <div> Pending Payment </div>
                                        </div>
                                    </div>


                                    <div class="col-3 mx-auto">
                                        <div class="card card-body card-buttons">
                                           <div> Payment Link </div>
                                        </div>
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
   </div>
</div>
<!-- END PAGE CONTENT-->