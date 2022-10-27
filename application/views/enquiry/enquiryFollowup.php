<div class="content-wrapper">
    <!-- <div class="page-heading">
        <h3 class="page-title">Users Listing</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html"><i class="la la-home font-20"></i></a>
            </li>
           <li class="breadcrumb-item">Users Listing</li> 
        </ol>
    </div> -->
    <!-- START PAGE CONTENT-->


    <div class="page-content fade-in-up col-md-8">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Enquiry Follow Up - <?=$followDataenquiry[0]->enq_number;?> <small>( <?=$followDataenquiry[0]->enq_fullname?> )</small></div>
                <!-- <div class="ibox-tools"> -->
                    <!-- <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a> -->
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFollowup">
                    <i class="fa fa-plus"></i> Add Follow Up
                </button>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                <table id="view_enquirylist" class="table table-bordered">
                    <thead>
                                <tr>
                                    <th>Enquiry No.</th>
                                    <th>Enquiry Date</th>
                                    <th>Remark</th>
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
<div class="modal fade" id="addFollowup" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addFollowupLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Follow Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"followup_form","id"=>"followup_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data", "autocomplete"=>"off"); 
            echo form_open("", $attributes);
         ?>
      <div class="modal-body">
            <div class="container">
            <div class="row col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                     <label style="text-align: left;"  for="enquiry_number">Enquiry Number<span class="required">*</span>
                     </label>
                     <div>
                        <input  maxlength="25" type="text" id="enquiry_number" name="enquiry_number" autocomplete="off" value="<?=$followDataenquiry[0]->enq_number;?>" class="form-control col-md-12 col-xs-12" readonly>
                        <p class="error enquiry_number_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;" for="follow_up_date">Follow Up Date</label><span class="required">*</span>
                     <div >
                          <input type="text" class="form-control datepicker" id="follow_up_date" value="<?php echo date('d-m-Y')?>" name="follow_up_date" placeholder="dd-mm-yyyy" autocomplete="off" required>
                     </div>
                     <p class="error enq_date_error"></p>
                  </div>
                  
                  <div class="form-group">
                     <label style="text-align: left;"  for="username">Remark<span class="required">*</span>
                     </label>
                     <div >
                         <textarea class="form-control" id="remark" name="remark" rows="5"></textarea>
                        <p class="error remark_error"></p>
                     </div>
                  </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>        
        <button type="submit" id="save_follow_up" class="btn btn-primary save_follow_up">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
