<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Question Paper Management ( <B>Course Name :</B><?=$examination_info[0]->course_name;?> )</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Examination Tilte : </b><?=$examination_info[0]->exam_title;?></p>
                </div>

                <div class="panel-body table-responsive ">
                    <table id="view_Staudent_result_list" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Mobile Number</th>
                                <th>Exam Status</th>
                                <th>Total Marks</th>
                                <th>Grade</th>
                                <th>Answer Sheet Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->