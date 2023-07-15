
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
                <div class="ibox-title">Student Report</div>
            </div>
            <div class="ibox-body">
                <div class="container">
                    <div class="row" style="margin-left: -53px; !important">
                        <div class="col-sm">
                            <label style="text-align: left;" for="student_name"><b>Student Name</b></label><span class="required">*</span>
                            <div>
                                <select class="form-control myselect" id="student_name" name="student_name" placeholder="Select Student Name">
                                   <option value="">Select Student Name</option>   
                                   <?php foreach ($getallstudentlist as $key => $value) { ?>   
                                        <option st-id="" value="<?php echo $value['userId'] ?>"><?php echo $value['name'].' - '.$value['mobile']  ?></option>
                                    <?php } ?>
                                </select>                         
                            </div>
                            <p class="error student_name_error"></p>  
                        </div>
                    
                        <div class="col-sm">
                            <label style="text-align: left;" for="download_report"><b>Download Report</b></label>
                            <div>
                               <button type="submit" id="export_to_excel_student_report" class="btn btn-primary export_to_excel_student_report">Export To Pdf</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->    

    <script type="text/javascript">
      $(".myselect").select2();
</script>