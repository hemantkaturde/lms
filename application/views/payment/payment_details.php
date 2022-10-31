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
                    <small>( <?=$followDataenquiry[0]->enq_fullname?> )</small></div>
                <!-- <div class="ibox-title">Enquiry Follow Up - <?=$followDataenquiry[0]->enq_number;?> <small>( <?=$followDataenquiry[0]->enq_fullname?> )</small></div>    -->
            </div>

            <div class="ibox-body">
                <div class="panel-body table-responsive">
                      <p style="color: blue"><b><u>Personal Information</u></b></p>
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="full_name"><b>Full Name</b>
                                    </label>
                                    <div>
                                        <p><?=$followDataenquiry[0]->enq_fullname ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="mobile_no"><b>Mobile No</b>
                                    </label>
                                    <div>
                                        <p><?=$followDataenquiry[0]->enq_mobile ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="enquiry_date"><b>Enquiry Date</b>
                                    </label>
                                    <div>
                                        <p><?=$followDataenquiry[0]->enq_date ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="mobile_no"><b>Enquiry Source</b>
                                    </label>
                                    <div>
                                        <p><?=$followDataenquiry[0]->enq_source ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="Doctor_Non_Doctor"><b>Doctor / Non- Doctor</b>
                                    </label>
                                    <div>
                                        <p><?=$followDataenquiry[0]->doctor_non_doctor ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;" for="mobile_no"><b>Email</b>
                                    </label>
                                    <div>
                                        <p><?=$followDataenquiry[0]->enq_email ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                       <p style="color: blue"><b><u>Course Information</u></b></p>
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="full_name"><b>Selected Course</b>
                                    </label>
                                    <div>
                                        <?php
                                                $course_ids    =   explode(',', $followDataenquiry[0]->enq_course_id);
                                                $total_fees = 0;
                                                $course_name = '';
                                                $i = 1;
                                                foreach($course_ids as $id)
                                                {
                                                    $get_course_fees =  $this->enquiry_model->getCourseInfo($id);
                                                    if($get_course_fees){
                                                        
                                                        $total_fees += $get_course_fees[0]->course_total_fees;
                                                        $course_name .= $i.'-'.$get_course_fees[0]->course_name.'&nbsp&nbsp<b>Rs</b> '.$get_course_fees[0]->course_total_fees. '<br>';  
                                                        $i++;  

                                                    }else{

                                                        $total_fees = '';
                                                        $course_name = '';  
                                                        $i++;  
                                                    }
                                                    
                                                }
                                                $all_course_name = trim($course_name, ', '); 

                                                echo '<p>'.$all_course_name .'</p>'; 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <p style="color: blue"><b><u>Payment</u></b></p>


                </div>
            </div>
        
        </div>
    </div>
    <!-- END PAGE CONTENT-->