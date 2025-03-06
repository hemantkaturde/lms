<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'studentListing';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                <div class="ibox-title">Student Book Issued</div>
            </div>
            <div class="ibox-body">

                 <h4>Student Course List (Student Name : <?=$getstudentdetails[0]->name; ?>  |  Roll No: <?=$getstudentdetails[0]->mobile; ?>    )</h4>
                <div class="panel-body table-responsive">

                    <?php
                        $attributes = array("name"=>"update_book_issued_form","id"=>"update_book_issued_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);
                    ?>
                  <input type="hidden" class="form-check-input" id="student_id" name="student_id" value="<?=$student_id?>"/>

                  <?php          
                       $i=0;
                       $course_ids =    explode(',' ,$enq_course_list[0]['enq_course_id']);
                        foreach($course_ids as $id)
                        {
                            $get_course_fees =  $this->enquiry_model->getCourseInfo($id); 
                             // print_r($get_course_fees);exit;
                            // print_r($student_id);
                            $book_issued_checked =    json_decode($enq_course_list[0]['book_issued']);
                             
                            if($book_issued_checked){
                                if (in_array($get_course_fees[0]->courseId, $book_issued_checked))
                                {
                                    $checked ='checked';
                                }else{
                                    $checked ='';
                                }
                            }else{
                                $checked ='';
                            }

                          
                            // if($book_issued_checked){

                            //     if($get_course_fees[0]->courseId==$book_issued_checked[$i]){
                            //         $selected ='selected';
                            //     }else{

                            //         $selected ='';
                            //     }
                            // }else{

                            //     $selected ='';
                            // }

                            ?>

                                <ul class="list-group">
                                    <li class="list-group-item rounded-0">
                                        <table>
                                            <tr>
                                                <div class="custom-control">
                                                    <input type="checkbox" class="form-check-input" id="course_check" name="course_check[]" value="<?=$get_course_fees[0]->courseId?>" <?php echo $checked; ?>>
                                                    <label class="cursor-pointer d-block custom-control-label" for="customCheck1"><?=$get_course_fees[0]->course_name?></label>
                                                </div>
                                            </tr>
                                            
                                            <tr>
                                                <div class="custom-control">
                                                    <input type="checkbox" class="form-check-input" id="restrict" name="restrict[]" value="<?=$get_course_fees[0]->courseId?>" <?php echo $checked; ?>>
                                                    <label class="cursor-pointer d-block custom-control-label" for="customCheck1">Course Restriction</label>
                                                </div>
                                            </tr>
                                        </table>
                                    </li>
                                </ul>
                
                       <?php $i++; }?>
                       <button type="submit" id="update_book_issued" class="btn btn-primary">Update</button>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->    