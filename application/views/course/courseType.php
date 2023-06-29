<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseType">
                        <i class="fa fa-plus"></i> Add Certification
                    </button>

                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>

                <div class="ibox-title">Certifications Management</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_coursetypelist" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Certifications Name</th>
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
    <div class="modal fade" id="addCourseType" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="addCourseTypeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Certification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"course_type_form","id"=>"course_type_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="course_type_name">Certifications<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="text" id="course_type_name"
                                            name="course_type_name" placeholder="Enter Certificate Type"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error course_type_name_error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="save_course_type" class="btn btn-primary save_course_type">Save</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>


    <!-- Edit New Course Modal -->
    <div class="modal fade" id="editCourseType" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="editCourseTypeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Edit Certification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"edit_course_type_form","id"=>"edit_course_type_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;" for="course_type_name">Certifications<span
                                            class="required">*</span>
                                    </label>
                                    <div>
                                        <input autocomplete="off" autocomplete="off" type="text" id="course_type_name_1"
                                            name="course_type_name_1" placeholder="Enter Certificate Type"
                                            class="form-control col-md-12 col-xs-12">
                                        <p class="error course_type_name_1_error"></p>
                                        <input autocomplete="off" autocomplete="off" type="hidden" id="coursetype_id"
                                            name="coursetype_id" placeholder="Enter Certificate Type"
                                            class="form-control col-md-12 col-xs-12">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="update_course_type"
                        class="btn btn-primary update_course_type">Save</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>