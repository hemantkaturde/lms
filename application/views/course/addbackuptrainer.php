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
                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url().'viewtimetablelisting?time_table_id='.$time_table_id.'&course_id='.$course_id;?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                <div class="ibox-title">     <b>Course Name : </b> <?=$getCourseinfo[0]->course_name;?> 
                | <b>Topic Name : </b> <?=$getTopicinfo[0]->topic;?> | Add Backup Trainer</div>
                
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <?php
                        $attributes = array("name"=>"updateBackupTrainerToTopic_from","id"=>"updateBackupTrainerToTopic_from","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);                       
                    ?>
                    <div class="col-sm-4">

                    <input name="course_id_form" id="course_id_form" type="hidden" value="<?php echo $course_id; ?>" />
                    <input name="time_table_id" id="time_table_id" type="hidden" value="<?php echo $time_table_id; ?>" />
                    <input name="time_table_transection_id" id="time_table_transection_id" type="hidden" value="<?php echo $time_table_transection_id; ?>" />

                        <div class="form-group">
                            <label style="text-align: left;" for="backup_trainer"><b>Backup Trainer</b></label>
                                <div>
                                    <select class="form-control" id="backup_trainer" name="backup_trainer" placeholder="Select Backup Trainer">
                                    <option value="">Select Backup Trainer Name</option>    
                                        <?php foreach ($gettrainerinfo as $key => $value) { ?>   
                                            <option value="<?=$value->userId;?>"><?=$value->name .'- '.$value->mobile ;?></option>
                                        <?php } ?>
                                    </select>                         
                                </div>
                            <p class="error backup_trainer_error"></p>  
                        </div>
                        <button type="button" id="updateBackupTrainerToTopic" class="btn btn-primary updateBackupTrainerToTopic">Update Backup Trainer</button>
                    </div>
                <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
