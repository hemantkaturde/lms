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

                    <!-- <p><b>Exam Total Marks : </b><?=$exam_detail[0]['exam_title'];?></p> -->
                    <div><a href="<?php echo base_url();?>start_exam/<?=$exam_detail[0]['id']?>">Start Exam</a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
