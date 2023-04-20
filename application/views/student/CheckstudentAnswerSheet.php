<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">

        
                <div class="ibox-head">
                    <div class="ibox-title">Question Paper Management ( <B>Course Name :</B><?=$examination_info[0]->course_name;?> )
                </div>

                <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/examcheckingList';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                </button>
            </div>


            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Examination Tilte : </b><?=$examination_info[0]->exam_title;?></p>
                </div>

                <input type="hidden"  id="course_id" name="course_id" value="<?=$course_id?>">
                <input type="hidden"  id="exam_id" name="exam_id" value="<?=$exam_id?>">

                <div class="panel-body table-responsive ">
                    <table id="view_Staudent_result_list" class="table table-bordered">
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
