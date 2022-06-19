
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
                <div class="ibox-title">Enquiry Management</div>

                <!-- <div class="ibox-tools"> -->
                    <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a>
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
            </div>
            <div class="ibox-body">
                 <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                ?>
          
              <div class="panel-body table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover" id="example-table">
                  <thead>
                            <tr>
                                
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Email</th>
                                <th>Enquiry Date</th>
                                <th>Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($enquiry))
                    {
                        foreach($enquiry as $record)
                        {
                           
                    ?>
                                <tr id="<?php echo $record->enq_id; ?>">
                                    
                                    <td>
                                        <?php echo $record->enq_fullname ?>
                                    </td>
                                    <td>
                                        <?php echo $record->enq_mobile ?>
                                    </td>
                                    <td>
                                        <?php echo $record->enq_email ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($record->enq_date)) ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success text-white" onclick="enquiry(<?php echo $record->enq_id; ?>)" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteEnquiry" href="#" data-enq_id="<?php echo $record->enq_id; ?>" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            
                        }
                    }
                    ?>
                  </tbody>
                        </table>
              </div>
            </div>
        </div>
    </div>
<!-- END PAGE CONTENT-->