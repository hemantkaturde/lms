<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url().'/timetableListing/'.$course_id;?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>

                <!-- <div class="ibox-title">Time Table Management</div> -->
                <div class="ibox-title">Time Table List - <?=$getCourseinfo[0]->course_name;?> <small>( <?=$getCourseinfo[0]->course_name?> )</small> - <?=$getTimetableInfo[0]->month_name?> ( From Date : <?=date('d-m-Y', strtotime($getTimetableInfo[0]->from_date));?> To Date : <?=date('d-m-Y', strtotime($getTimetableInfo[0]->to_date));?> )</div>
                <!-- <div><a href="<?php base_url().'/templates/Time_Table_Template.xlsx'?>" target="_blank">Download TimeTable Tempalte</a></div> -->
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewtimetable">
                    <i class="fa fa-plus"></i> Add New Time Table
                </button> -->
                <input name="course_id_form" id="course_id_form" type="hidden" value="<?php echo $course_id; ?>" />
                <input name="time_table_id" id="time_table_id" type="hidden" value="<?php echo $time_table_id; ?>" />

            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_time_table_topics_listing" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Timings</th>
                                <th>Topics</th>
                                <th>Trainer</th>
                                <th>Back up Trainer</th>
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
