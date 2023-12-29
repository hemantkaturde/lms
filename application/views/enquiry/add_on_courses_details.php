<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div>
            <button type="button" class="btn btn-primary">
              <a href="<?php echo base_url().'/enquirylisting';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
            </button>
            </div>
                <div class="ibox-title">Add On Courses Details - Enquiry Number <?=$followDataenquiry[0]->enq_number;?>
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
                            <th>Active Course</th>
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
                                    ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEnquiry">
                            <i class="fa fa-plus"></i> Add Add-on Course
                        </button>
                    </div>
                    <table id="" class="table table-bordered" style="margin-top: 20px;">
                        <tr style="background: #d2ae6d;">
                            <th>Course Name</th>
                            <th>Status</th>
                            <th style="width:30px">Action</th>
                        </tr>

                        <?php  foreach ($getAddoncourseList as $key => $value) {
                            if($value['active_status']==1){

                                $status = 'Inactive';
                            }else{
                                $status = 'Active';
                            }
                            ?>
                            <tr>
                                <td><?=$value['course_name'] ?></td>
                                <td><?=$status?></td>
                                <td>
                                    <a style='cursor: pointer;' class='delete_add_on_course' data-id='<?=$value['id']?>'><img width='20' src="<?=ICONPATH;?>/delete.png" alt='Delete Add On Course' title='Delete Add On Course'></a>
                                    <a style='cursor: pointer;' class='change_active_inactive_status' course_id='<?=$value['courseId']?>' data-id='<?=$value['id']?>'><img width='20' src="<?=ICONPATH;?>/edit.png" alt='Active Inactive Status' title='Active Inactive Status'></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
  

    <!-- Add New Enquiry Modal -->
    <div class="modal fade" id="addEnquiry" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addEnquiryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#d2ae6d">
            <h5 class="modal-title" id="modlatitleLabel" style="color:#000">Add New Course</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <?php
                $attributes = array("name"=>"add_on_courses","id"=>"add_on_courses_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                echo form_open("", $attributes);
            ?>

            <div class="modal-body">
                    <div class="container">
                    <div class="row col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" value="<?=$enquiry_id;?>" id="enquiry_id" name="enquiry_id"/>
                        <div class="form-group">
                            <label style="text-align: left;" for="course">Course Name<span class="required">*</span>
                            </label>
                            <div class="form-group">
                                <!-- <select class="form-control course" id="course" name="course" multiple> -->
                                <select class="form-control" id="course" name="course"  placeholder="Select Courses"  required="" style="width: 320px; margin-left: -15px;">
                                <option value="">Select Course Name</option>   
                                    <?php foreach ($course_List as $key => $value) {?>
                                    <option value="<?php echo $value['courseId']; ?>"><?php echo $value['course_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <p class="error course_error"></p>
                            </div>
                        </div>
                    </div>
                
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        
                <button type="submit" id="save_add_on_course" class="btn btn-primary save_add_on_course">Save</button>
            </div>
            <?php echo form_close(); ?>
            </div>
    </div>
    </div>



    <!-- Change Status Active / Inactive here -->
    <div class="modal fade" id="changeactiveinactive" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="changeactiveinactiveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#d2ae6d">
            <h5 class="modal-title" id="modlatitleLabel" style="color:#000">Change Course Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <?php
                $attributes = array("name"=>"changeactiveinactive_form","id"=>"changeactiveinactive_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                echo form_open("", $attributes);
            ?>
                <div class="modal-body">
                    <div class="container">
                    <div class="row col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" value="<?=$enquiry_id;?>" id="enquiry_id" name="enquiry_id"/>
                    <input type="hidden" id="course_id" name="course_id"/>
                    <input type="hidden" id="main_id" name="main_id"/>

                        <div class="form-group">
                            <label style="text-align: left;" for="course_status">Course Status<span class="required">*</span>
                            </label>
                            <div class="form-group">
                                <select class="form-control" id="course_status" name="course_status"  placeholder="Select Courses"  required="" style="width: 320px; margin-left: -15px;">
                                    <option value="">Select Course Name</option>   
                                    <option value="1">Active</option>
                                    <option value="0">In-Active</option>
                                </select>
                                <p class="error course_status_error"></p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        
                <button type="submit" id="save_changeactiveinactive" class="btn btn-primary save_changeactiveinactive">Save</button>
            </div>
            <?php echo form_close(); ?>
            </div>
    </div>
    </div>