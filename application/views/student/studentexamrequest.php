<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

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
                <div class="ibox-title">Student Exam Request</div>
            </div>

            <?php
                $attributes = array("name"=>"click_to_allow_request_form","id"=>"click_to_allow_request_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                echo form_open("", $attributes);        
            ?>
            <div class="ibox-body">
                <div class="container">
                    <div class="row" style="margin-left: -53px; !important">
                        <div class="col-sm">
                            <label style="text-align: left;" for="student_name"><b>Student Name</b></label><span class="required">*</span>
                            <div>
                                <select class="form-control" id="student_name" name="student_name" placeholder="Select Student Name">
                                   <option value="" >Select Student Name</option>   
                                   <?php foreach ($getallstudentlist as $key => $value) { ?>   
                                        <option st-id="" value="<?php echo $value['userId'] ?>"><?php echo $value['name'].' - '.$value['mobile']  ?></option>
                                    <?php } ?>
                                </select>                         
                            </div>
                            <p class="error student_name_error"></p>  
                        </div>

                        <div class="col-sm">
                            <label style="text-align: left;" for="course_name"><b>Course Name</b></label><span class="required">*</span>
                            <div>
                                <select class="form-control myselect" id="course_name" name="course_name" placeholder="Select Course Name">
                                   <option value="">Select Course Name</option>   
                                </select>                         
                            </div>
                            <p class="error course_name_error"></p>  
                        </div>
                    
                        <div class="col-sm">
                            <label style="text-align: left;" for="download_report"><b> &nbsp</b></label>
                            <div>
                               <button type="submit" id="click_to_allow_request" class="btn btn-primary click_to_allow_request">Click To Allow</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox-body">
                    <div class="panel-body table-responsive ">
                        <table id="view_studentexamrequestdata" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Course Name</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
               </div>
            </div>

            <?php echo form_close(); ?>

        </div>
    </div>
    <!-- END PAGE CONTENT-->    

    <script type="text/javascript">
      $(".myselect").select2();
</script>