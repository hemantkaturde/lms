<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewMeeting">
                        <i class="fa fa-plus"></i> Add Meeting Link
                    </button>

                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>

                </div>

                <input name="course_id_form" id="course_id_form" type="hidden" value="<?php echo $course_id; ?>" />
                <input name="time_table_id" id="time_table_id" type="hidden" value="<?php echo $time_table_id; ?>" />
                <input name="time_table_transection_id" id="time_table_transection_id" type="hidden"
                    value="<?php echo $time_table_transection_id; ?>" />

                Date : <?=$getTopicinfo[0]->date?>
                <div class="ibox-title">Course Name : <?=$getCourseinfo[0]->course_name;?> | Topic Name :
                    <?=$getTopicinfo[0]->topic;?> | Topic Meeting Link Management</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="fetchmeetinglink" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Topic Name</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->


    <!-- Add New Course Modal -->
    <div class="modal fade" id="addNewMeeting" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="addNewMeetingLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Meeting Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"new_meeting_link","id"=>"new_meeting_link","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input name="course_id_form_post" id="course_id_form_post" type="hidden" value="<?php echo $course_id; ?>" />
                                    <input name="time_table_id_post" id="time_table_id_post" type="hidden" value="<?php echo $time_table_id; ?>" />
                                    <input name="time_table_transection_id_post" id="time_table_transection_id_post" type="hidden" value="<?php echo $time_table_transection_id; ?>" />

                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="topic_name">Topic Name </label><span  class="required">*</span>
                                                <input name="topic_name" id="topic_name" type="text"  value="<?=$getCourseinfo[0]->course_name?>" class="form-control" readonly/>
                                                <p class="error topic_name_error"></p>
                                            </div>
                                        </div>

                                        <!-- <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="title">Title</label><span  class="required">*</span>
                                                <input name="title" id="title" type="text" class="form-control" placeholder="Enter Title" required  />
                                                <p class="error title_error"></p>
                                            </div>
                                        </div> -->

                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="timings">Timings</label><span  class="required">*</span>
                                                <input name="timings" id="timings" type="text" class="form-control"  value="<?=$getTopicinfo[0]->timings?>" placeholder="Enter Timings" required readonly />
                                                <p class="error timings_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="new_meeting_link">Add New Meeting Link</label><span  class="required">*</span>
                                                <input name="new_meeting_link" id="new_meeting_link" type="text"  placeholder="Enter Meeting Link" class="form-control" required />
                                                <p class="error new_meeting_link_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="add_new_meeting_link" class="btn btn-primary add_new_meeting_link">Save</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>