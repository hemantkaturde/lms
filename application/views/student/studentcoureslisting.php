<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                  <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                  </button>
                </div> 
            
                <div class="ibox-title">Course List</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_students_courselist" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Course Type</th>
                                <th>Course Fees</th>
                                <th>Course Mode</th>
                                <th>Course Books</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->
