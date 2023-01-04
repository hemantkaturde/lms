<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                   <a class="btn btn-primary text-white" href="<?php echo base_url(); ?>addRole"><i class="fa fa-plus"></i> Add Page Access</a>

                   <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/dashboard';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                  </button>

                </div>

                <div class="ibox-title">Page Access Management</div>
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseType"> -->
                    <!-- <i class="fa fa-plus"></i> Add Role -->
                <!-- </button> -->
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_roleList" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Page Access</th>
                                <th>Description</th>
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