<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Question Paper Management ( <B>Course Name :</B><?=$exam_detail[0]['course_name'];?> )</div>
                <div>Timer : </div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Examination Tilte : </b><?=$exam_detail[0]['exam_title'];?></p>
                    <?php
                        $attributes = array("name"=>"submit_examination","id"=>"submit_examination","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);
                    ?>
                    <div class="container mt-1">
                        <div class="d-flex justify-content-center row">
                            <div class="col-md-10 col-lg-10">
                                <div class="border">
                                       
                                <input type="hidden" id="examination_id" name="examination_id" value="<?=$exam_detail[0]['id'] ?>"></input>
                                <input type="hidden" id="course_id" name="course_id" value="<?=$exam_detail[0]['course_id'] ?>"></input>
                                <input type="hidden" id="student_id" name="student_id" value="<?=$student_id; ?>"></input>
                                
                                    <div class="question bg-white p-3 border-bottom" style="color: red;">
                                        <div class="d-flex flex-row justify-content-between align-items-center mcq">
                                            <h4>MATCH THE FOLLOWING COLUMN</h4><span></span>
                                        </div>
                                    </div>


                                    <?php $i=1; foreach ($questionPaperListMATCHPAIR as $keyMATCHPAIR => $valueMATCHPAIR) { ?>
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
                                                <label for="mcq_answers_label"> MCQ Answers</label>
                                                </div>
                                                <div class="mcq_answers_text">
                                                    <textarea id="mcq_answers_<?=$valueMATCHPAIR->id?>" name="mcq_answers_<?=$valueMATCHPAIR->id?>" rows="4" cols="100" require></textarea>
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
                                                <label for="options_answers">Answer</label>
                                                </div>
                                                <div class="options_answers_text">
                                                    <input id="options_answers_<?=$value->id ?>" name="options_answers_<?=$value->id ?>" style="width: 85%;" require></input>
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

                                        <div class="ans ml-2">
                                            <textarea id="answer_written_test_<?= $valueWRITTEN->id; ?>" name="answer_written_test_<?= $valueWRITTEN->id;?>" rows="5" cols="100" placeholder='Answer'></textarea>
                                        </div>
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
                                    <div class="modal-footer">
                                        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        
                                        <button type="submit" id="submit_examination_anser" class="btn btn-primary submit_examination_anser">Submit Examination</button>
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
