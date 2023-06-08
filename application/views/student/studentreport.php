<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>
                <div class="ibox-title">Student Report</div>
            </div>
            <div class="ibox-body">
            

                <div class="container">
                    <div class="row" style="margin-left: -53px; !important">
                        <div class="col-sm">
                            <label style="text-align: left;" for="student_name"><b>Student Name</b></label>
                            <div>
                                <select class="form-control" id="student_name" name="role" placeholder="Select Student Name">
                                   <option value="">Select Student Name</option>   
                                   <?php foreach ($getallstudentlist as $key => $value) { ?>   
                                        <option st-id="" value="<?php echo $value['userId'] ?>"><?php echo $value['name'].' - '.$value['mobile']  ?></option>
                                    <?php } ?>
                                </select>                         
                            </div>
                            <p class="error student_name_error"></p>  
                        </div>
                    
                        <?php  $form_date= date('Y-m-01');?> 

                        <div class="col-sm">
                            <label style="text-align: left;" for="from_date"><b>From Date</b></label>
                            <div>
                            <input type="text" class="form-control datepicker" placeholder="Enter From Date"  value="<?=$form_date?>" id="from_date" name="from_date">
                            </div>
                            <p class="error from_date_error"></p>
                        </div>


                        <?php  $to_date= date('Y-m-t');?>

                        <div class="col-sm">
                            <label style="text-align: left;" for="to_date"><b>To Date</b></label>
                            <div>
                               <input type="text" class="form-control datepicker"  placeholder="Enter To Date" value="<?=$to_date?>" id="to_date" name="challan_date">
                            </div>
                            <p class="error to_date_error"></p>   
                        </div>

                        <div class="col-sm">
                            <label style="text-align: left;" for="course_name"><b>Course Name</b></label>
                            <div>
                                 <select class="form-control" id="course_name" name="role" placeholder="Select Course Name">
                                   <option value="">Select Course Name</option>   
                                   <?php foreach ($getCourseList as $key => $value) { ?>   
                                        <option st-id="" value="<?php echo $value['courseId'] ?>"><?php echo $value['course_name']; ?></option>
                                    <?php } ?>
                                </select>     
                            </div>
                            <p class="error course_name_error"></p>  
                        </div>

                        <div class="col-sm">
                            <label style="text-align: left;" for="download_report"><b>Downlaod  Report</b></label>
                            <div>
                               <button type="submit" id="export_to_excel" class="btn btn-primary add_new_meeting_link">Export To Excel</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel-body table-responsive">
                    <table class="table table-bordered" id="studentreportList">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile / Roll Number</th>
                                <th>E mail</th>
                                <th>Course</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->    