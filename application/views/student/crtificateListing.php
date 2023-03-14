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
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                
                <div class="ibox-title">Certificate</div>
            </div>
            <div class="ibox-body">
        
                <div class="panel-body table-responsive ">
                    <table id="view_Certificate" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Mobile No</th>
                                <th>Exam Status</th>
                                <th>Total Marks</th>
                                <th>Grade</th>
                                <th>Grade Point</th>
                                <th>Remark</th>
                                <th>Quntitave value</th>
                                <th>Answer Sheet Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->

<div id="modalRegister" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
                $attributes = array("name"=>"update_evbtr_numnber","id"=>"update_evbtr_numnber","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                echo form_open("", $attributes);
            ?>
              <form role="form" id="update_evbtr_numnber">
                        <div class="modal-header">
                            <h4 class="modal-title" style="color:black">
                                Add EVBTR Number
                            </h4>
                            <button type="button" class="close" data-dismiss="modal">
                                &times;</button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="certificate_id" class="certificate_id" name="certificate_id" ></input>
                            <div class="form-group">
                                <label style="text-align: left;" for="evbtrdate">Date<span class="required">*</span>
                                </label>
                                <div>
                                    <input autocomplete="off" autocomplete="off" type="text" id="evbtrdate" name="evbtrdate" placeholder="Enter Date" class="datepicker form-control col-md-12 col-xs-12">
                                    <p class="error evbtrdate_error"></p>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label style="text-align: left;" for="evbtr">Enter EVBTR Number<span class="required">*</span>
                                </label>
                                <div>
                                    <input autocomplete="off" autocomplete="off" type="text" id="evbtr" name="evbtr" placeholder="Enter EVBTR Number" class="form-control col-md-12 col-xs-12">
                                    <p class="error evbtr_error"></p>
                                </div>
                            </div>      
                            
                            <div class="form-group">
                                <label style="text-align: left;" for="remark">Remark
                                </label>
                                <div>
                                    <textarea class="form-control" id="remark"  name="remark" rows="3" placeholder="Enter Remark here..."></textarea>
                                    <p class="error remark_error"></p>
                                </div>
                            </div>    
                        </div>
                        <div class="modal-footer">
                            <input type="submit" id="submitEvbtr" name="submitEvbtr" class="btn btn-success" id="submit" style="background: #d2ae6d;border: #d2ae6d;color: black;">
                            <input type="button" id="btnClosePopup" value="Close" class="btn btn-danger" data-dismiss="modal" style=" background: #727b84;border: #727b84; color: black;" />
                        </div>
                    </form>    
            <?php echo form_close(); ?>

        </div>
    </div>
</div>