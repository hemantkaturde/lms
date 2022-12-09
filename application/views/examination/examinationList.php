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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewExamination">
                        <i class="fa fa-plus"></i> Create New Examination
                    </button>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                  </button>
                </div>



                <div class="ibox-title">Examination Management</div>
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="btn btn-primary addcourse"><i class="fa fa-plus"></i> Add Course</a> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->

                <!-- <div><a href="<?php echo TEMPALTE_PATH;?>/Examination.xlsx">Download Excel Template</a></div> -->

            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_examinationlist" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Examination Title</th>
                                <th>Time</th>
                                <th>Status</th>
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


<!-- Add Examination Modal -->
<div class="modal fade" id="addNewExamination" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
    aria-labelledby="addNewExaminationLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#d2ae6d">
                <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Create New Examination</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $attributes = array("name"=>"examination_form","id"=>"examination_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group">
                        <label style="text-align: left;" for="course_name">Select Course Course<span
                                class="required">*</span></label>
                        <select class="form-control" id="course_name" name="course_name">
                            <option value="">Select Course Type</option>
                            <?php foreach ($course_name as $key => $value) { ?>
                            <option value="<?php echo $value->courseId; ?>"><?php echo ucwords($value->course_name); ?>
                            </option>
                            <?php } ?>
                        </select>
                        <p class="error course_name_error"></p>
                    </div>

                    <div>
                        <label style="text-align: left;" for="examination_title">Examination Title<span
                                class="required">*</span></label>
                        <div>
                            <input autocomplete="off" autocomplete="off" type="text" id="examination_title"
                                name="examination_title" placeholder="Enter Examination Name"
                                class="form-control col-md-12 col-xs-12">
                            <p class="error examination_title_error"></p>
                        </div>
                    </div>

                    <div>
                        <label style="text-align: left;" for="examination_time">Examination Time (In Minutes)<span
                                class="required">*</span></label>
                        <div>
                            <input autocomplete="off" autocomplete="off" type="number" id="examination_time"
                                name="examination_time" placeholder="Enter Examination Time"
                                class="form-control col-md-12 col-xs-12">
                            <p class="error examination_time_error"></p>
                        </div>
                    </div>

                    <div>
                        <label style="text-align: left;" for="examination_status">Status<span
                                class="required">*</span></label>
                        <div>
                            <select class="form-control" id="examination_status" name="examination_status">
                                <option value="">Select Course Type</option>
                                <option value="1">Active</option>
                                <option value="0">In-Active</option>
                            </select>
                            <p class="error examination_status_error"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button> <button
                    type="submit" id="save_examination" class="btn btn-primary save_examination">Save</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>



<!-- Edit Examination Modal -->
<div class="modal fade" id="editExamination" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
    aria-labelledby="editExaminationLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#d2ae6d">
                <h5 class="modal-title" id="exampleModalLabel" style="color:#000"> Edit Examination</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $attributes = array("name"=>"editexamination_form","id"=>"editexamination_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group">
                        <label style="text-align: left;" for="course_name">Select Course Course<span
                                class="required">*</span></label>
                        <select class="form-control" id="course_name1" name="course_name">
                            <option value="">Select Course Type</option>
                            <?php foreach ($course_name as $key => $value) { ?>
                            <option value="<?php echo $value->courseId; ?>"><?php echo ucwords($value->course_name); ?>
                            </option>
                            <?php } ?>
                        </select>
                        <p class="error course_name_error"></p>
                    </div>

                    <div>
                        <label style="text-align: left;" for="examination_title">Examination Title<span
                                class="required">*</span></label>
                        <div>
                            <input autocomplete="off" autocomplete="off" type="text" id="examination_title1"
                                name="examination_title" placeholder="Enter Examination Name"
                                class="form-control col-md-12 col-xs-12">
                            <input type="hidden" id="exam_id1" name="exam_id1">
                            <p class="error examination_title_error"></p>
                        </div>
                    </div>

                    <div>
                        <label style="text-align: left;" for="examination_time">Examination Time (In Mins)<span
                                class="required">*</span></label>
                        <div>
                            <input autocomplete="off" autocomplete="off" type="number" id="examination_time1"
                                name="examination_time" placeholder="Enter Examination Time"
                                class="form-control col-md-12 col-xs-12">
                            <p class="error examination_time_error"></p>
                        </div>
                    </div>

                    <div>
                        <label style="text-align: left;" for="examination_status">Status<span
                                class="required">*</span></label>
                        <div>
                            <select class="form-control" id="examination_status1" name="examination_status">
                                <option value="">Select Course Type</option>
                                <option value="1">Active</option>
                                <option value="0">In-Active</option>
                            </select>
                            <p class="error examination_status_error"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="update_examination" class="btn btn-primary update_examination">Save</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>