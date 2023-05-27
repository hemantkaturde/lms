<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">

                
                <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/examinationlisting';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                </button>
                    
                Question Paper Management ( <B>Course Name :</B><?=$examination_info[0]->course_name;?> )
            
                </div>


                <!-- <div class="ibox-tools"> -->
                <!-- <a class="btn btn-primary addcourse"><i class="fa fa-plus"></i> Add Course</a> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <div><a href="<?php echo TEMPALTE_PATH;?>/Examination_Template.xlsx">Download Excel Template</a></div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addqestionapaper">
                    <i class="fa fa-plus"></i> Upload Question Paper
                </button>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Examination Tilte : </b><?=$examination_info[0]->exam_title;?></p>

                    <div class="container mt-1">
                        <div class="d-flex justify-content-center row">
                            <div class="col-md-10 col-lg-10">
                                <div class="border">
                                       
                                    
                                    <div class="question bg-white p-3 border-bottom" style="color: red;">
                                        <div class="d-flex flex-row justify-content-between align-items-center mcq">
                                            <h4>MATCH THE FOLLOWING COLUMN</h4><span></span>
                                        </div>
                                    </div>

                                    <?php $i=1; foreach ($questionPaperListMATCHPAIR as $keyMATCHPAIR => $valueMATCHPAIR) { ?>
                                    <div class="question bg-white p-3 border-bottom">
                                      
                                        <!-- <div class="d-flex flex-row align-items-center question-title">
                                            <h3 class="text-danger">Q. <?php echo $i++; ?></h3>
                                            <h5 class="mt-1 ml-2"><?= $valueMATCHPAIR->question; ?>
                                            </h5>
                                        </div> -->

                                        <!-- <div class="ans ml-2">
                                            <textarea id="answer_<?php echo $valueMATCHPAIR->id; ?>" name="w3review" rows="5" cols="100" placeholder='Answer'></textarea>
                                        </div> -->

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

                                        <div class="ans ml-2"  style="width: 85%;background: yellow;">
                                            <label class="radio"> Correct Answer : 
                                            <span> <?= $value->correct_ans;?></span>
                                            </label>
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
                                            <textarea id="answer_<?php echo $valueWRITTEN->id; ?>" name="w3review" rows="5" cols="100" placeholder='Answer'></textarea>
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
                                    <!-- <div class="d-flex flex-row justify-content-between align-items-center p-3 bg-white">
                                        <button class="btn btn-primary d-flex align-items-center btn-danger" type="button"><i class="fa fa-angle-left mt-1 mr-1"></i>&nbsp;previous</button>
                                        <button  class="btn btn-primary border-success align-items-center btn-success" type="button">Next<i class="fa fa-angle-right ml-2"></i></button></div>
                                    </div> -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->



    <!-- Add New Course Modal -->
    <div class="modal fade" id="addqestionapaper" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-labelledby="addqestionapaperLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Upload Question Paper</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"addqestionapaper_form","id"=>"addqestionapaper_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">

                            <div>
                                <label style="text-align: left;" for="course_name">Course Name<span
                                        class="required">*</span></label>
                                <div>
                                    <input autocomplete="off" autocomplete="off" type="hidden" id="examination_id"
                                        name="examination_id" value="<?=$examination_info[0]->id;?>"
                                        class="form-control col-md-12 col-xs-12" readonly>

                                    <input autocomplete="off" autocomplete="off" type="text" id="course_name"
                                        name="course_name" value="<?=$examination_info[0]->course_name;?>"
                                        class="form-control col-md-12 col-xs-12" readonly>

                                    <input autocomplete="off" autocomplete="off" type="hidden" id="course_id"
                                        name="course_id" value="<?=$examination_info[0]->course_id;?>">
                                    <p class="error course_name_error"></p>
                                </div>
                            </div>

                            <div>
                                <label style="text-align: left;" for="examination_title">Examination Title<span
                                        class="required">*</span></label>
                                <div>
                                    <input autocomplete="off" autocomplete="off" type="text" id="examination_title" name="examination_title" value="<?=$examination_info[0]->exam_title;?>" readonly class="form-control col-md-12 col-xs-12">
                                    <p class="error examination_title_error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="text-align: left;" for="questionpaper"> Upload File <span class="required">*</span>
                                </label>
                                <div>
                                    <input name="questionpaper" id="fileInput" type="file" class="demoInputBox form-control"  required />
                                    <p class="error questionpaper_error"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="error importing_error"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addqestionapaperexel" class="btn btn-primary addqestionapaperexel">Save</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>