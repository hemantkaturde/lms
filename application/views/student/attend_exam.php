<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);

?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Examination ( <B>Course Name :</B><?=$exam_detail[0]['course_name'];?> )</div>

                <div></div>
                <div></div>
            
            </div>

            
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Examination Tilte : </b><?=$exam_detail[0]['exam_title'];?></p>
                    <p><b>Examination Time : </b><?=$exam_detail[0]['exam_time'].' Min';?></p>
                     <hr/>
                     <p><b>Exam Instructions:</b><p>
                    <p>(Please read instructions carefully before starting exam)</p>
                    <p>1. Exam contains MULTIPLE CHOICE QUESTIONS (MCQ) and LONG ANSWER QUESTIONS.</p>
                    <p>2. If you submit the exam early or the timer runs out before you have answered enough questions correctly, you will not pass and will not be able to resume from where you left off.</p>
                    <p>3. Please answers in appropriate manner and read the questions properly before answering.</p>
                    <p>4. Exam result, mark sheet and provisional certificate after passing will be generated and available on your student portal.<p>
                    <p>5. Check your internet connection before starting the exam.</p>
                    <p>6. For any queries do contact IICTN Administrator.</p>


                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Subject</th>
                        <th scope="col">Mark Grade</th>
                        <th scope="col">Grade Point</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Qualitative value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>90 & Above</td>
                            <td>A+</td>
                            <td>10</td>
                            <td>Pass</td>
                            <td>Outstanding</td>
                        </tr>
                        <tr>
                            <td>80 to 89</td>
                            <td>A</td>
                            <td>9</td>
                            <td>Pass</td>
                            <td>Excellent</td>
                        </tr>
                        <tr>
                            <td>70 to 79</td>
                            <td>B+</td>
                            <td>8</td>
                            <td>Pass</td>
                            <td>Very Good</td>
                        </tr>
                        <tr>
                            <td>60 to 69</td>
                            <td>B</td>
                            <td>7</td>
                            <td>Pass</td>
                            <td>Good</td>
                        </tr>
                        <tr>
                            <td>50 to 59</td>
                            <td>C</td>
                            <td>6</td>
                            <td>Pass</td>
                            <td>Above Average</td>
                        </tr>
                        <tr>
                            <td>45 to 49</td>
                            <td>D</td>
                            <td>5</td>
                            <td>Pass</td>
                            <td>Average</td>
                        </tr>
                        <tr>
                            <td>40 to 44</td>
                            <td>E</td>
                            <td>4</td>
                            <td>Pass</td>
                            <td>Poor</td>
                        </tr>
                        <tr>
                            <td>Below 40</td>
                            <td>F</td>
                            <td>0</td>
                            <td>Fail</td>
                            <td>Fail</td>
                        </tr>
                        <tr>
                            <td>Absent</td>
                            <td>F</td>
                            <td>0</td>
                            <td>Absent</td>
                            <td>Fail</td>
                        </tr>
                    </tbody>
                    </table>

                     


                    <!-- <p><b>Exam Total Marks : </b><?=$exam_detail[0]['exam_title'];?></p> -->
                    <div><a href="<?php echo base_url();?>start_exam/<?=$exam_detail[0]['id']?>">Start Exam</a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
