
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Email Template Management</div>

                <!-- <div class="ibox-tools"> -->
                    <a class="btn btn-primary text-white" onclick="email_template(0)" ><i class="fa fa-plus"></i> Add Template</a>
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
                                
                                <th>Template Name</th>
                                <th>Description</th>
                                <th>Template Module</th>
                                <th>Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($template))
                    {
                        foreach($template as $record)
                        {
                           
                    ?>
                                <tr id="<?php echo $record->etempId; ?>">
                                    
                                    <td>
                                        <?php echo $record->etemp_name ?>
                                    </td>
                                    <td>
                                        <?php echo $record->etemp_desc ?>
                                    </td>
                                    <td>
                                        <?php echo $record->etemp_module ?>
                                    </td>
                                  
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success text-white" onclick="email_template(<?php echo $record->etempId; ?>)" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteTemplate" href="#" data-etempId="<?php echo $record->etempId; ?>" title="Delete">
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