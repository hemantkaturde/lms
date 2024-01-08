<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'studentexaminationlist';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                    <P style="color:red"> *Please select 1 exam paper out of 3 exam paper and start the exam</p>
                </div>

                <input type="hidden" id="course_id" name="course_id" value="<?=$course_id;?>">
                <div class="ibox-title">View Examination</div>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                <table id="view_student_examination" class="table table-bordered">
                    <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Examination Title</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                    </thead>
                    <tbody>
                    </tbody>
                 </table>
              </div>
            </div>
        </div>
    </div>
<!-- END PAGE CONTENT-->

