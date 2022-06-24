
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Course Type Management</div>

                <!-- <div class="ibox-tools"> -->
                    <a class="btn btn-primary text-white" onclick="course_type(0)" ><i class="fa fa-plus"></i> Add New</a>
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
            </div>
            <div class="ibox-body">
                 <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                ?>
          
              <div class="panel-body table-responsive ">
                <table width="100%" class="table table-striped table-bordered table-hover" id="example-table">
                  <thead>
                            <tr>
                                <th>Course Type Name</th>
                                <th width="12%">Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($course_type))
                    {
                        foreach($course_type as $record)
                        {
                           
                    ?>
                                <tr id="<?php echo $record->ct_id; ?>">
                                    <td>
                                        <?php echo $record->ct_name ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success text-white" onclick="course_type(<?php echo $record->ct_id; ?>)" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteCourseType" href="#" data-ct_id="<?php echo $record->ct_id; ?>" title="Delete">
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
