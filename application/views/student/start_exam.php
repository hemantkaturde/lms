<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<style>
 table, th, td {border:1px solid black;}
 .center {
  margin-left: auto;
  margin-right: auto;
}
</style>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Question Paper Management ( <B>Course Name :</B><?=$exam_detail[0]['course_name'];?> )</div>
                <div style="margin-left: 400px;">Timer (mins): </div>
                <h1 id="countdown" class="countdown"></h1>

            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Examination Tilte : </b><?=$exam_detail[0]['exam_title'];?></p>
                    <!-- <p><b>Examination Time : </b><?=$exam_detail[0]['exam_time'].' Mins';?></p> -->

                    <h4>Exam Date: <?=date("Y-m-d");?>  | Exam Time: <?=$exam_detail[0]['exam_time'].' Mins';?> | Marks : 100 Marks </h4>

                    <table style="width:100%;padding: 10px;">
                       
                        <tr>
                            <td><b>Enrolment No.: </b></td>
                            <td>xxxxxxxxxxx</td>
                            <td><b>Applicant Full Name: </b></td>
                            <td>xxxxxxxxxxx</td>
                        </tr>

                        <tr>
                            <td><b>Mobile No. :</b></td>
                            <td>xxxxxxxxxxxx</td>
                            <td><b>Email Id:</b></td>
                            <td>xxxxxxxxxxx</td>
                        </tr>
                    </table>

                    <div style="margin: auto;width: 40%;padding: 10px;">


                      <h4>APPLICANTS UNDERTAKING </h4>

                      </div>

                      <p>The applicant hereby affirms and agrees that all the information provided in this assessment form is true and authentic, as per the requirements of the institute or university. Additionally, the applicant consents to utilize their best knowledge and the studies they have undertaken in relation to the course(s) or subjects during the exam. They commit to answering all questions truthfully and pledge not to engage in cheating, copying, or pasting answers from any online or offline platform.</p>
                    

                    


                    <?php
                        $attributes = array("name"=>"submit_examination","id"=>"submit_examination","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
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
                                            <label class="radio"> <input type="radio" name="<?=$value->id ?>" id="<?=$value->option_1;?>" onclick="toggleCheckbox('chkAns1');"  data-id="<?=$value->id ?>" value="<?=$value->option_1;?>" >
                                                <span> <?= $value->option_1;?></span>
                                            </label>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio" name="<?=$value->id ?>" id="<?=$value->option_2;?>" onclick="toggleCheckbox('chkAns2');" data-id="<?=$value->id ?>" value="<?= $value->option_2;?>">
                                            <span> <?= $value->option_2;?></span>
                                            </label>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio"  name="<?=$value->id ?>" id="<?=$value->option_3;?>" onclick="toggleCheckbox('chkAns3');" data-id="<?=$value->id ?>" value="<?= $value->option_3;?>"> 
                                            <span> <?= $value->option_3;?></span>
                                            </label>
                                        </div>
                                        <div class="ans ml-2">
                                            <label class="radio"> <input type="radio"  name="<?=$value->id ?>" id="<?=$value->option_4;?>" onclick="toggleCheckbox('chkAns4');" data-id="<?=$value->id ?>" value="<?= $value->option_4;?>">
                                            <span> <?= $value->option_4;?></span>
                                            </label>
                                        </div>

                                        <div class="ans ml-2">
                                            <div class="options_answers" style="color: red;">
                                                <div class="options_answers">
                                                <label for="options_answers">Answer</label>
                                                </div>
                                                <div class="options_answers_text">
                                                    <input type="text" style="width: 85%;background: yellow;" id="options_answers_<?=$value->id ?>" name="options_answers_<?=$value->id ?>" style="width: 85%;" require readonly></input>
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
                                    <h2 class="error"><p></p></h2>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">
                                            <a href="<?php echo base_url().'attendexamination/'.$exam_detail[0]['id'];?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                                    </button>
                                        
                                        <!-- <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>         -->
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
    <script src="https://code.jquery.com/jquery-2.2.4.min.js">
    </script>

    <script type="text/javascript">

        $("input[type='radio']").change(function() {
        // Your code for any radio button change event
                var elemF = $(this);
                var val = elemF.attr('id');
                var data_id = elemF.attr('data-id');

                $("#options_answers_"+data_id).val(val);
        })
       
    </script>

<script>
        
        var timer2 = "<?=$exam_detail[0]['exam_time'];?>:00";
        //var timer2 = "2:00";
        var interval = setInterval(function() {


        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $('.countdown').html(minutes + ':' + seconds);
        timer2 = minutes + ':' + seconds;
        }, 1000);
        // <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    </script>