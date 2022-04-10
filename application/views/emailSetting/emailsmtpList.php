
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Email SMTP Management</div>

                <!-- <div class="ibox-tools"> -->
                    <a class="btn btn-primary text-white" onclick="email_smtp(0)" ><i class="fa fa-plus"></i> Add SMTP</a>
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
                                
                                <th>SMTP Host</th>
                                <th>SMTP Port</th>
                                <th>SMTP Protocol</th>
                                <th>SMTP Username</th>
                                <th>SMTP Password</th>
                                <th>Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($smtp))
                    {
                        foreach($smtp as $record)
                        {
                           
                    ?>
                                <tr id="<?php echo $record->smtpId; ?>">
                                    
                                    <td>
                                        <?php echo $record->smtp_host ?>
                                    </td>
                                    <td>
                                        <?php echo $record->smtp_port ?>
                                    </td>
                                    <td>
                                        <?php echo $record->smtp_protocol ?>
                                    </td>
                                    <td>
                                        <?php echo $record->smtp_username ?>
                                    </td>
                                    <td>
                                        <?php echo $record->smtp_password ?>
                                    </td>
                                  
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success text-white" onclick="email_smtp(<?php echo $record->smtpId; ?>)" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteSmtp" href="#" data-smtpId="<?php echo $record->smtpId; ?>" title="Delete">
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