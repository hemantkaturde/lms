
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
                <div class="ibox-title">Course Management</div>

                <!-- <div class="ibox-tools"> -->
                    <a class="btn btn-primary text-white" onclick="student(0)" ><i class="fa fa-plus"></i> Add Student</a>
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
                                
                                <th>Student Name</th>
                                <th>Mobile No</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Addresss</th>
                                <!-- <th>Courses</th> -->
                                <th>Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($student))
                    {
                        foreach($student as $record)
                        {
                           
                    ?>
                                <tr id="<?php echo $record->studentId; ?>">
                                    
                                    <td>
                                        <?php echo $record->student_fname.' '.$record->student_lname ?>
                                    </td>
                                    <td>
                                        <?php echo $record->student_mobile ?>
                                    </td>
                                    <td>
                                        <?php echo $record->student_gender ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($record->student_dob)) ?>
                                    </td>
                                    <td>
                                        <?php echo $record->student_address ?>
                                    </td>
                                    <!-- <td>
                                        <?php echo $record->student_course ?>
                                    </td> -->
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-success text-white" onclick="student(<?php echo $record->studentId; ?>)" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteStudent" href="#" data-studentId="<?php echo $record->studentId; ?>" title="Delete">
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