<?php
$roleText = $this->session->userdata('roleText');
$id = '';
$leave_title = '';
$leave_from_date = '';
$leave_to_date ='';
$leave_description ='';
$leave_document ='';


if(!empty($getLeaveRequestdata))
{
    foreach ($getLeaveRequestdata as $rf => $value)
    {

        $id = $value['id'] ;
        $leave_title = $value['leave_title'];
        $leave_from_date = $value['leave_from_date'];
        $leave_to_date = $value['leave_to_date'];
        $leave_description = $value['leave_description'];
        $leave_document = $value['leave_document'];
    }
}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-content fade-in-up col-md-8">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Edit Leave Request</div>
            </div>
            <div class="ibox-body">
                <?php
                        $attributes = array("name"=>"update_leave_request_form","id"=>"update_leave_request_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);
                        
                    ?>
                <!-- <form role="form" id="enquiry_form"> -->
                    <div class="row">
                        <!-- <div class="col-md-12"> -->
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <!-- <div class="box-header">
                                    <h3 class="box-title">Edit Enquiry</h3>
                                </div> -->
                                <input class="form-control" autocomplete="off" autocomplete="off"  type="hidden" id="leave_id" value="<?php echo $id; ?>" name="leave_id">

                                <div class="box-body">
                                    <div class="row col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                        <div class="form-group">
                                            <label style="text-align: left;"  for="leave_title">Leave Title<span class="required">*</span>
                                            </label>
                                            <div>
                                                <input class="form-control" autocomplete="off" autocomplete="off"  type="text" id="leave_title" value="<?php echo $leave_title; ?>" name="leave_title" Placeholder="Leave Title">
                                                <p class="error leave_title_error"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="text-align: left;"  for="leave_from_date">Leave From Date<span class="required">*</span>
                                            </label>
                                            <div>
                                                <input class="form-control datepicker" autocomplete="off" autocomplete="off"  type="text" id="leave_from_date" value="<?php echo $leave_from_date; ?>" name="leave_from_date" Placeholder="Leave From Date">
                                                <p class="error leave_from_date_error"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="text-align: left;"  for="leave_to_date">Leave To Date<span class="required">*</span>
                                            </label>
                                            <div>
                                                <input class="form-control datepicker" autocomplete="off" autocomplete="off"  type="text" id="leave_to_date" value="<?php echo $leave_to_date; ?>" name="leave_to_date" Placeholder="Leave To Date">
                                                <p class="error leave_to_date_error"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="text-align: left;"  for="leave_description">Leave Description<span class="required">*</span>
                                            </label>
                                            <div >
                                            <textarea class="form-control" id="leave_description" name="leave_description" rows="5" Placeholder="Leave Description"><?php echo $leave_description; ?></textarea>                                        
                                            <p class="error leave_description_error"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="text-align: left;"  for="leave_document">Leave Document
                                            </label>
                                            <div>
                                                <input name="file" id="fileInput" type="file" class="demoInputBox form-control" required/>
                                                <p class="error leave_document_error"></p>
                                            </div>
                                            <div>
                                             <label style="text-align: left;"  for="uploaded_file">Uploaded File</label>
                                                <div>
                                                  <a href="<?php echo $leave_document; ?>" target="_blank"><?php echo $leave_document; ?></a>
                                                </div>
                                            </div>
                                        </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <!-- ENTER BUTTON HERE -->
                                <input type="button" id="update_leaverequest" class="btn btn-primary" value="UPDATE" />
                                <input type="button" onclick="location.href='<?php echo base_url().'leaverequest'?>'"
                                    class="btn btn-default" value="BACK" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>