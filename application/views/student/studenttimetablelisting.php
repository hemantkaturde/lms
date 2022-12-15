<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">

                <div>
                  <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/studentcourses';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                  </button>
                </div>
            
                <div class="ibox-title">Time Table Management - <?=$getCourseinfo[0]->course_name;?> <small>( <?=$getCourseinfo[0]->course_name?> )</small></div>

                <input name="course_id_form" id="course_id_form" type="hidden" value="<?php echo $course_id; ?>" />
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_student_time_table_list" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Month Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->
