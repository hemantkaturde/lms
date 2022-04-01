
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
                <div class="ibox-title">Users Listing</div>

                <!-- <div class="ibox-tools"> -->
                    <!-- <a class="btn btn-primary text-white" href="<?php echo base_url(); ?>addNewUser"><i class="fa fa-plus"></i> Add User</a> -->
                    <a class="btn btn-primary text-white" onclick="add_update_user_master(0)"><i class="fa fa-plus"></i> Add User</a>
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
            </div>
            <div class="ibox-body">
                 <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
              <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>
                                </div>
              <?php } ?>
              <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
              <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
                        </div>
              <?php } ?>
              <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="example-table">
                  <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone number</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                            if($record->user_flag == "user"){
                    ?>
                                <tr>
                                    <td>
                                        <?php echo $record->name ?>
                                    </td>
                                    <td>
                                        <?php echo $record->email ?>
                                    </td>
                                    <td>
                                        <?php echo $record->mobile ?>
                                    </td>
                                    <td>
                                        <?php echo $record->role ?>
                                    </td>
                                    <td class="text-center">
                                       <!--  <a class="btn btn-xs btn-primary" href="<?= base_url().'log-history/'.$record->userId; ?>" title="Log Records">
                                            <i class="fa fa-history"></i>
                                        </a>  -->
                                        <!-- <a class="btn btn-xs btn-info" href="<?= base_url().'editOld/'.$record->userId; ?>" title="Edit"> -->
                                        <a class="btn btn-xs btn-info" onclick="add_update_user_master(<?php echo $record->userId; ?>)" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteUser" href="#" data-userid="<?php echo $record->userId; ?>" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
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