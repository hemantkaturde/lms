<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
$roleText = $this->session->userdata('roleText');

?>
<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
            <input name="query_id_main" id="query_id_main" type="hidden" value="<?php echo $query_id; ?>" />

                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url().'askqquery'?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>

                    <?php if($roleText=='Trainer'){ ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addanswer">
                        <i class="fa fa-plus"></i> Add Answer
                    </button>
                   <?php }?>

            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Course Name : </b><?php echo $getquerydatabyid['0']['course_name']; ?></p> 
                    <p><b>Student Name : </b><?php echo $getquerydatabyid['0']['name']; ?></p> 
                    <p><b>Query : </b><?php echo $getquerydatabyid['0']['query']; ?></p> 

                    <table id="view_query_answer" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Answer</th>
                                <?php if($roleText =='Trainer'){ ?>
                                <th>Action</th>
                                <?php } ?>
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



    <!-- Add New Course Modal -->
    <div class="modal fade" id="addanswer" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="addanswerLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Answer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            $attributes = array("name"=>"addanswer_form","id"=>"addanswer_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
            echo form_open("", $attributes);
         ?>
                <div class="modal-body">

                    <input name="userId" id="userId" type="hidden" value="<?php echo $userId; ?>" />
                    <input name="query_id" id="query_id" type="hidden" value="<?php echo $query_id; ?>" />

                    <div class="container">
                        <div class="row col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="query_answer">Query Answer </label><span  class="required">*</span>
                                                   <textarea name="query_answer" id="query_answer" cols="120" rows="10"></textarea>
                                                <p class="error query_answer_error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="add_query_answer" class="btn btn-primary add_query_answer">Save</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>