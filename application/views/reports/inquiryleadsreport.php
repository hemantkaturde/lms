<?php $roleText = $this->session->userdata('roleText');?>
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
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <!-- <div class="ibox-tools"> -->
                    <!-- <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a> -->
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <div class="ibox-title">Inquiry Leads Report</div>
            </div>
            <div class="ibox-body">

                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                          One of three columns
                        </div>
                        <div class="col-sm">
                          One of three columns
                        </div>
                        <div class="col-sm">
                          One of three columns
                        </div>
                    </div>
                </div>

              <div class="panel-body table-responsive">
                <table id="view_enquirylist_report" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Inquiry No.</th>
                            <th>Inquiry Date</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Courses</th>
                            <th>Counsellor</th>
                            <th>Status</th>
                            <!-- <th>Fees</th> -->
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