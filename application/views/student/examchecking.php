<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title"> Answer Sheet ( <B>Course Name :</B><?=$exam_detail[0]['course_name'];?> )</div>
                <!-- <div>Timer : </div> -->
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Examination Tilte : </b><?=$exam_detail[0]['exam_title'];?></p>
                    <p><b>Student Name : </b><?=$get_userdetails[0]['name'];?>  <?=$get_userdetails[0]['lastname'];?></p>
                    <p><b>Seat Number : </b><?=$get_userdetails[0]['mobile'];?></p>

                    <?php
                        $attributes = array("name"=>"submit_marks","id"=>"submit_marks","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);
                    ?>
                    <div class="container mt-1">
                        <div class="d-flex justify-content-center row">
                            <div class="col-md-10 col-lg-10">
                                <div class="border"></br>

                            
                                <input type="hidden" id="examination_id" name="examination_id" value="<?=$exam_detail[0]['id'] ?>"></input>
                                <input type="hidden" id="course_id" name="course_id" value="<?=$exam_detail[0]['course_id'] ?>"></input>
                                <input type="hidden" id="student_id" name="student_id" value="<?=$student_id; ?>"></input>
                                
                                    <div class="question bg-white p-3 border-bottom" style="color: red;">
                                        <div class="d-flex flex-row justify-content-between align-items-center mcq">
                                            <h4>MATCH THE FOLLOWING COLUMN</h4><span></span>
                                        </div>
                                    </div>

                                    


                                    <?php $i=1; foreach ($questionPaperListMATCHPAIR as $keyMATCHPAIR => $valueMATCHPAIR) {?>
                                    <div class="question bg-white p-3 border-bottom">

                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm">
                                                      <?php  $right_side = explode (",", $valueMATCHPAIR->option_1); 
                                                        
                                                         foreach ( $right_side as $key_right_side => $value_right_side) {
                                                             echo $value_right_side .'<br/>';
                                                         }
                                                      
                                                      ?>
                                                  
                                                    </div>
                                                    <div class="col-sm">
                                                            <?php   $left_side = explode (",", $valueMATCHPAIR->option_2); 
                                                            
                                                                foreach ( $left_side as $key_left_side => $value_left_side) {
                                                                    echo $value_left_side .'<br/>';
                                                                }
                                                            ?>
                                                   
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="ans ml-2">
                                            <div class="mcq_answers" style="color: red;">
                                                <div class="mcq_answers_label">
                                                   <label for="mcq_answers_label"> <b style="color:Green">Student MCQ Answers</b></label>
                                                   <p> <?= $valueMATCHPAIR->question_answer; ?></p>
                                                </div>

                                                
                                                <div class="add_marks">
                                                   <label for="add_marks">Add Marks</label>
                                                </div>

                                                <div class="add_marks_match">
                                                    <input id="add_marks_match_<?=$valueMATCHPAIR->id ?>" name="add_marks_match_<?=$valueMATCHPAIR->id ?>" style="width: 85%;" require></input>
                                                </div>
                                             
                                            </div>
                                    </div>
                                    </div>
                                    <?php } ?>


                                
                                    
                                    <div class="question bg-white p-3 border-bottom" style="color: red;">
                                        <div class="d-flex flex-row justify-content-between align-items-center mcq">
                                            <h4>MULTIPLE CHOICE QUESTIONS</h4><span></span>
                                        </div>
                                    </div>
                                    <?php $i=1; foreach ($questionPaperListMCQ as $key => $value) { ?>
                                    <div class="question bg-white p-3 border-bottom">
                                        <div class="d-flex flex-row align-items-center question-title">
                                            <h3 class="text-danger">Q. <?php echo $i++; ?></h3>
                                            <h5 class="mt-1 ml-2"><?= $value->question; ?>
                                            </h5>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio" name="brazil" value="brazil" disabled>
                                                <span> <?= $value->option_1;?></span>
                                            </label>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio" name="Germany" value="Germany" disabled>
                                            <span> <?= $value->option_2;?></span>
                                            </label>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio" name="Indonesia" value="Indonesia" disabled> 
                                            <span> <?= $value->option_3;?></span>
                                            </label>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio" name="Russia" value="Russia" disabled>
                                            <span> <?= $value->option_4;?></span>
                                            </label>
                                        </div>

                                        <div class="ans ml-2">
                                            <div class="options_answers" style="color: red;">
                                                <div class="options_answers">
                                                <label for="options_answers"><b style="color:Green">Student Answer</b> : <?= $value->question_answer; ?></label>
                                                </div>

                                                <div class="add_marks">
                                                   <label for="add_marks">Add Marks</label>
                                                </div>

                                                <div class="add_marks_option">
                                                    <input id="add_marks_option_<?=$value->id ?>" name="add_marks_option_<?=$value->id ?>" style="width: 85%;" require></input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>


                                    <div class="question bg-white p-3 border-bottom" style="color: red;">
                                        <div class="d-flex flex-row justify-content-between align-items-center mcq">
                                            <h4>LONG ANSWER QUESTIONS </h4><span></span>
                                        </div>
                                    </div>

                                    <?php $i=1; foreach ($questionPaperListWRITTEN as $keyWRITTEN => $valueWRITTEN) { ?>
                                    <div class="question bg-white p-3 border-bottom">
                                      
                                        <div class="d-flex flex-row align-items-center question-title">
                                            <h3 class="text-danger">Q. <?php echo $i++; ?></h3>
                                            <h5 class="mt-1 ml-2"><?= $valueWRITTEN->question; ?>
                                            </h5>
                                        </div>


                                        <div class="options_answers">
                                                <label for="options_answers"><b style="color:Green">Student Answer</b> : <?= $valueWRITTEN->question_answer; ?></label>
                                        </div>


                                        <div class="add_marks">
                                                   <label for="add_marks">Add Marks</label>
                                        </div>

                                        <div class="add_marks_wriitan">
                                                    <input id="add_marks_wriitan_<?=$valueWRITTEN->id ?>" name="add_marks_wriitan_<?=$valueWRITTEN->id ?>" style="width: 85%;" require></input>
                                        </div>

                                        <!-- <div class="ans ml-2">
                                            <textarea id="answer_written_test_<?= $valueWRITTEN->id; ?>" name="answer_written_test_<?= $valueWRITTEN->id;?>" rows="5" cols="100" placeholder='Answer'></textarea>
                                        </div> -->
                                    </div>
                                    <?php } ?>

                                    <!-- <div class="question bg-white p-3 border-bottom">
                                        <div class="d-flex flex-row align-items-center question-title">
                                            <h3 class="text-danger">Q. 1</h3>
                                            <h5 class="mt-1 ml-2">Which of the following country has largest population?
                                            </h5>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio" name="brazil" value="brazil" readonly>
                                                <span>Brazil</span>
                                            </label>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio" name="Germany" value="Germany" readonly>
                                                <span>Germany</span>
                                            </label>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio" name="Indonesia" value="Indonesia" readonly> <span>Indonesia</span>
                                            </label>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio" name="Russia" value="Russia" readonly>
                                                <span>Russia</span>
                                            </label>
                                        </div>
                                    </div> -->
                                    <h2 class="error"><p></p></h2>
                                    <div class="modal-footer">
                                        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        
                                        <button type="submit" id="submit_marks" class="btn btn-primary submit_marks">Submit Marks</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
