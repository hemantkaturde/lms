
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
                <div class="ibox-title">Course - <?php echo $courseName; ?> </div>

                <!-- <div class="ibox-tools"> -->
                    <a class="btn btn-primary text-white" onclick="courseLink(0, <?php echo $id ?>)" ><i class="fa fa-plus"></i> Add Link</a>
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
                                
                                <th>Link Name</th>
                                <th>Link URL</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($courselink))
                    {
                        foreach($courselink as $record)
                        {
                           
                    ?>
                                <tr id="<?php echo $record->link_id; ?>">
                                    
                                    <td>
                                        <?php echo $record->link_name ?>
                                    </td>
                                    <td>
                                        <?php echo $record->link_url ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($record->link_sdate)) ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($record->link_ldate)) ?>
                                    </td>
                                  
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success text-white" onclick="courseLink(<?php echo $record->link_id .','. $id; ?>)" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteCourseLink" href="#" data-link_id="<?php echo $record->link_id; ?>" title="Delete">
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