<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">

                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseAttchment">
                        <i class="fa fa-plus"></i> Add Topic / Chapter
                    </button>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/courselisting';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>

                <div class="ibox-title">Course Topic / Chapter List - <?=$getCourseinfo[0]->course_name;?> <small>(
                        <?=$getCourseinfo[0]->course_name?> )</small></div>
                <input type="hidden" id="course_id" name="course_id" value="<?=$getCourseinfo[0]->courseId;?>">
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <table id="view_coursetopicsattAchmentList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Topic / Chapter Name</th>
                                <!-- <th>Remark</th> -->
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

    <!-- Add New User Modal -->
    <div class="modal fade" id="addCourseAttchment" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-labelledby="addCourseAttchmentLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"addCourseAttchment_form","id"=>"addCourseAttchment_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data", "autocomplete"=>"off"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="topic_name">Topic / Chapter Name<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input type="text" id="topic_name" name="topic_name"
                                            placeholder="Enter Topic / Chapter Name" autocomplete="off"
                                            class="form-control col-md-12 col-xs-12">
                                        <input type="hidden" id="course_id_post" name="course_id_post"
                                            value="<?=$getCourseinfo[0]->courseId;?>">
                                        <p class="error topic_name_error"></p>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                     <label style="text-align: left;" for="remark">Remark
                     </label>
                     <div >
                         <textarea class="form-control" id="remark" placeholder="Enter Remark" name="remark" rows="5"></textarea>
                        <p class="error remark_error"></p>
                     </div>
                  </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="save_course_topic" class="btn btn-primary save_course_topic">Save</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>



    <!-- Add New User Modal -->
    <div class="modal fade" id="editCourseAttchment" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-labelledby="editCourseAttchmentLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Edit Topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"editCourseAttchment_form","id"=>"editCourseAttchment_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data", "autocomplete"=>"off"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="topic_name_1">Topic / Chapter Name<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input maxlength="25" type="text" id="topic_name_1" name="topic_name_1"
                                            placeholder="Enter Topic / Chapter Name" autocomplete="off"
                                            class="form-control col-md-12 col-xs-12">
                                        <input type="hidden" id="course_id_1_post" name="course_id_1_post"
                                            value="<?=$getCourseinfo[0]->courseId;?>">
                                        <input type="hidden" id="topic_id" name="topic_id">
                                        <p class="error topic_name_1_error"></p>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                     <label style="text-align: left;" for="remark_1">Remark
                     </label>
                     <div >
                         <textarea class="form-control" id="remark_1"  placeholder="Enter Remark" name="remark_1" rows="5"></textarea>
                        <p class="error remark_1_error"></p>
                     </div>
                  </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="update_course_topic"
                        class="btn btn-primary update_course_topic">Update</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>