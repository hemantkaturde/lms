<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-10">
        <div class="ibox">
            <div class="ibox-head">

                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseAttchment">
                        <i class="fa fa-plus"></i> Add Course Attachment
                    </button>

                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/courselisting';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                     </button>
                </div>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                <table id="view_topic_attchemant" class="table table-bordered">
                    <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Document Type</th>
                                    <th>Doctor / Non-Doctor</th>
                                    <th>Remark</th>
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