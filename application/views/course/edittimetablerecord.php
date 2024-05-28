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
                <div class="ibox-title">     
                   Date : <?=$getTopicinfo[0]->date?>
                  <b>Course Name : </b> <?=$getCourseinfo[0]->course_name;?> 
                | <b>Topic Name : </b> <?=$getTopicinfo[0]->topic;?> | Edit Backup Trainer</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <?php
                        $attributes = array("name"=>"updatetimetable_from","id"=>"updatetimetable_from","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);                       
                    ?>
                    <div class="col-sm-4">
                            <input name="course_id_form" id="course_id_form" type="hidden" value="<?php echo $course_id; ?>" />
                            <input name="time_table_id" id="time_table_id" type="hidden" value="<?php echo $time_table_id; ?>" />
                            <input name="time_table_transection_id" id="time_table_transection_id" type="hidden" value="<?php echo $time_table_transection_id; ?>" />
                      
                        <div class="form-group">
                            <label style="text-align: left;" for="date">Date <span class="required">*</span></label>
                              <input name="date" id="date" type="text" class="form-control"  value="<?=$getTopicinfo[0]->date?>"  required readonly/>
                            <p class="error date_error"></p>  
                        </div>


                        <div class="form-group">
                            <label style="text-align: left;" for="timing">Timing<span class="required">*</span></label>
                            <input name="timing" id="timing" type="text" class="form-control"  value="<?=$getTopicinfo[0]->timings?>" required />
                            <p class="error timing_error"></p>  
                        </div>


                        <div class="form-group">
                            <label style="text-align: left;" for="topic">Topic <span class="required">*</span></label>
                            <input name="topic" id="topic" type="text" class="form-control"  value="<?=$getTopicinfo[0]->topic?>" required />
                            <p class="error topic_error"></p>  
                        </div>


                        <div class="form-group">
                            <label style="text-align: left;" for="trainer">Trainer <span class="required">*</span></label>
                                <div>
                                    <select class="form-control" id="trainer" name="trainer" placeholder="Select Trainer">
                                    <option value="">Select Trainer Name</option>    
                                        <?php foreach ($getAlltrainerinfo as $key => $value) { ?>   
                                            <option value="<?=$value->userId;?>"  <?php if($value->userId==$getTopicinfo[0]->trainer_id){ echo 'selected';} ?> ><?=$value->name .'- '.$value->mobile ;?></option>
                                        <?php } ?>
                                    </select>                         
                                </div>
                            <p class="error trainer_error"></p>  
                        </div>

                        <div class="form-group">
                            <label style="text-align: left;" for="backup_trainer">Backup Trainer</label>
                                <div>
                                    <select class="form-control" id="backup_trainer" name="backup_trainer" placeholder="Select Backup Trainer">
                                    <option value="">Select Backup Trainer Name</option>    
                                        <?php foreach ($gettrainerinfo as $key => $value) { ?>   
                                            <option value="<?=$value->userId;?>"   <?php if($value->userId==$getTopicinfo[0]->backup_trainer){ echo 'selected';} ?> ><?=$value->name .'- '.$value->mobile ;?></option>
                                        <?php } ?>
                                    </select>                         
                                </div>
                            <p class="error backup_trainer_error"></p>  
                        </div>

                        <button type="button" id="updatetimetablerecord" class="btn btn-primary updatetimetablerecord">Update</button>
                        <a href="<?php echo base_url().'viewtimetablelisting?time_table_id='.$time_table_id.'&course_id='.$course_id;?>" style="color: black !important"><button type="button" id="" class="btn btn-primary">Close</button></a>
                    </div>
                <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
