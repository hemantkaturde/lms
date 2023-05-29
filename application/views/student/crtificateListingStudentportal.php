<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Certificate</div>
            </div>
            <div class="ibox-body">
        
                <div class="panel-body table-responsive ">
                    <table id="view_student_Certificate" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Mobile Number</th>
                                <th>Exam Status</th>
                                <th>Total Marks</th>
                                <th>Grade</th>
                                <th>Grade Point</th>
                                <th>Remark</th>
                                <th>Quntitave value</th>
                                <th>Answer Sheet Status</th>
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
