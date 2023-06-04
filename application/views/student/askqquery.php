<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
$roleText = $this->session->userdata('roleText');
?>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                    <?php if($roleText=='Student'){ ?>
                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addnewquery">
                     <i class="fa fa-plus"></i> Add New Query
                   </button>
                   <?php }?>
                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url();?>dashboard" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>

                <div class="ibox-title"> Ask A Query</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_ask_query" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Query</th>
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
    <div class="modal fade" id="addnewquery" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="addnewqueryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Query</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"addnewquery_form","id"=>"addnewquery_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">
                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label style="text-align: left;"  for="course_name">Course Name<span class="required">*</span>
                                    </label>
                                    <div >
                                        <select class="form-control" id="course_name" name="course_name">
                                            <option value="">Select Certificate Type</option>
                                            <?php foreach ($course_List as $key => $value) {?>
                                               <option value="<?php echo $value['courseId']; ?>"><?php echo $value['course_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <p class="error course_name_error"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align: left;"  for="query">Query<span class="required">*</span>
                                    </label>
                                    <div >
                                      <textarea class="form-control" id="query" name="query" rows="5"></textarea>                                        <p class="error query_error"></p>
                                    </div>
                                    <p class="error query_error"></p>
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="addnewquerydata" class="btn btn-primary addnewquerydata">Save</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>