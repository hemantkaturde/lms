<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <!-- <div class="ibox-tools"> -->
                    <!-- <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a> -->
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <div>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEnquiry">
                     <i class="fa fa-plus"></i> Add Inquiry
                  </button>

                  <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>

                </div>
              
                <div class="ibox-title">Admission Listing / Inquiry Listing</div>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                <table id="view_enquirylist_student" class="table table-bordered">
                    <thead>
                                <tr>
                                    <th>Inquiry No.</th>
                                    <th>Inquiry Date</th>
                                    <th>Name</th>
                                    <th>Mobile No</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <!-- <th>Fees</th> -->
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

