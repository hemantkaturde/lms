<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Question Paper Management ( <B>Course Name :</B> <?=$examination_info[0]->course_name;?> )</div>
                
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="btn btn-primary addcourse"><i class="fa fa-plus"></i> Add Course</a> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <div><a href="<?php echo TEMPALTE_PATH;?>/Examination.xlsx">Download Excel Template</a></div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addqestionapaper">
                    <i class="fa fa-plus"></i> Upload Question Paper
                </button>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Examination Tilte : </b><?=$examination_info[0]->exam_title;?></p>
                
                   
                    <div class="question_type_heading"><div><p><b>MCQ Question</b></p></div> <div class="marks" style="text-align: end">(20 Marks)</div></div>

                    <div class="questions_list">
                        <div class="question_set">
                            <div class="question"><p><b>Q No.1 What is Node JS?</b></p></div>
                            <div class="option_answers" style="margin-left: 38px;">
                                <p>1. Special type of JavaScript language</p>
                                <p>2. JavaScript runtime environment that executes JavaScript code</p>
                                <p>3. Different version of the normal JavaScript</p>
                                <p>4. All of the above</p>
                            </div>
                            <div class="correct_ans" style="margin-left: 38px;">
                                <p><b>Ans :</b> All of the above</p>
                            </div>
                        </div>    
                     </div> 

                     <div class="questions_list">
                        <div class="question_set">
                            <div class="question"><p><b>Q No.1 What is Node JS?</b></p></div>
                            <div class="option_answers" style="margin-left: 38px;">
                                <p>1. Special type of JavaScript language</p>
                                <p>2. JavaScript runtime environment that executes JavaScript code</p>
                                <p>3. Different version of the normal JavaScript</p>
                                <p>4. All of the above</p>
                            </div>
                            <div class="correct_ans" style="margin-left: 38px;">
                                <p><b>Ans :</b> All of the above</p>
                            </div>
                        </div>    
                     </div> 


                     <div class="questions_list">
                        <div class="question_set">
                            <div class="question"><p><b>Q No.1 What is Node JS?</b></p></div>
                            <div class="option_answers" style="margin-left: 38px;">
                                <p>1. Special type of JavaScript language</p>
                                <p>2. JavaScript runtime environment that executes JavaScript code</p>
                                <p>3. Different version of the normal JavaScript</p>
                                <p>4. All of the above</p>
                            </div>
                            <div class="correct_ans" style="margin-left: 38px;">
                                <p><b>Ans :</b> All of the above</p>
                            </div>
                        </div>    
                     </div> 


                     <div class="questions_list">
                        <div class="question_set">
                            <div class="question"><p><b>Q No.1 What is Node JS?</b></p></div>
                            <div class="option_answers" style="margin-left: 38px;">
                                <p>1. Special type of JavaScript language</p>
                                <p>2. JavaScript runtime environment that executes JavaScript code</p>
                                <p>3. Different version of the normal JavaScript</p>
                                <p>4. All of the above</p>
                            </div>
                            <div class="correct_ans" style="margin-left: 38px;">
                                <p><b>Ans :</b> All of the above</p>
                            </div>
                        </div>    
                     </div> 

                     <div class="questions_list">
                        <div class="question_set">
                            <div class="question"><p><b>Q No.1 What is Node JS?</b></p></div>
                            <div class="option_answers" style="margin-left: 38px;">
                                <p>1. Special type of JavaScript language</p>
                                <p>2. JavaScript runtime environment that executes JavaScript code</p>
                                <p>3. Different version of the normal JavaScript</p>
                                <p>4. All of the above</p>
                            </div>
                            <div class="correct_ans" style="margin-left: 38px;">
                                <p><b>Ans :</b> All of the above</p>
                            </div>
                        </div>    
                     </div> 

                    <div class="questions_list">
                        <div class="question_set">
                            <div class="question"><p><b>Q No.1 What is Node JS?</b></p></div>
                            <div class="option_answers" style="margin-left: 38px;">
                                <p>1. Special type of JavaScript language</p>
                                <p>2. JavaScript runtime environment that executes JavaScript code</p>
                                <p>3. Different version of the normal JavaScript</p>
                                <p>4. All of the above</p>
                            </div>
                            <div class="correct_ans" style="margin-left: 38px;">
                                <p><b>Ans :</b> All of the above</p>
                            </div>
                        </div>    
                     </div> 


                     <div class="questions_list">
                        <div class="question_set">
                            <div class="question"><p><b>Q No.1 What is Node JS?</b></p></div>
                            <div class="option_answers" style="margin-left: 38px;">
                                <p>1. Special type of JavaScript language</p>
                                <p>2. JavaScript runtime environment that executes JavaScript code</p>
                                <p>3. Different version of the normal JavaScript</p>
                                <p>4. All of the above</p>
                            </div>
                            <div class="correct_ans" style="margin-left: 38px;">
                                <p><b>Ans :</b> All of the above</p>
                            </div>
                        </div>    
                     </div> 

                </div>
            </div>
        </div>
    </div>

<!-- END PAGE CONTENT-->


<!-- Add New Course Modal -->
<div class="modal fade" id="addqestionapaper" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addqestionapaperLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Uplaod Question Paper</h5>
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
                      <label style="text-align: left;"  for="course_name">Course Name<span class="required">*</span></label>
                        <div >
                            <input autocomplete="off" autocomplete="off"  type="text" id="course_name" name="course_name"  value="<?=$examination_info[0]->course_name;?>" class="form-control col-md-12 col-xs-12" readonly>
                            <input autocomplete="off" autocomplete="off"  type="hidden" id="course_id" name="course_id"  value="<?=$examination_info[0]->course_id;?>">
                            <p class="error course_name_error"></p>
                        </div>
                    </div>

                    <div>
                      <label style="text-align: left;"  for="examination_title">Examination Title<span class="required">*</span></label>
                        <div >
                            <input autocomplete="off" autocomplete="off"  type="text" id="examination_title" name="examination_title"  value="<?=$examination_info[0]->exam_title;?>" readonly class="form-control col-md-12 col-xs-12">
                            <p class="error examination_title_error"></p>
                        </div>
                    </div>

                    <div class="form-group">
                     <label style="text-align: left;"  for="topic_name"> Upload File <span class="required">*</span>
                     </label>
                     <div>
                         <input name="timetable" id="fileInput" type="file" class="demoInputBox form-control" required/>
                        <p class="error topic_name_error"></p>
                     </div>
                    </div>
                  <div class="form-group">
                       <p class="error importing_error"></p>
                  </div>
                </div>    
          </div> 
      </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        <button type="submit" id="addqestionapaper" class="btn btn-primary addqestionapaper">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
