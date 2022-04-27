
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Course Management</div>

                <!-- <div class="ibox-tools"> -->
                    <a class="btn btn-primary text-white" onclick="courses(0)" ><i class="fa fa-plus"></i> Add Course</a>
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
            </div>
            <div class="ibox-body">
                 <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                ?>
          
              <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="example-table">
                  <thead>
                            <tr>
                                
                                <th>Course Name</th>
                                <th>Description</th>
                                <th>Created Date</th>
                                <th width="12%">Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($course))
                    {
                        foreach($course as $record)
                        {
                           
                    ?>
                                <tr id="<?php echo $record->courseId; ?>">
                                    
                                    <td>
                                        <?php echo $record->course_name ?>
                                    </td>
                                    <td>
                                        <?php echo $record->course_desc ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($record->course_date)) ?>
                                    </td>
                                  
                                    <td class="text-center">
                                    <a href="#" class="btn btn-xs btn-info text-white">Send Link</a>
                                        <a href="<?php echo base_url().'courseLinks/'.$record->courseId ?>" class="btn btn-xs btn-info text-white"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                                        <a class="btn btn-xs btn-success text-white" onclick="courses(<?php echo $record->courseId; ?>)" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteCourse" href="#" data-courseId="<?php echo $record->courseId; ?>" title="Delete">
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