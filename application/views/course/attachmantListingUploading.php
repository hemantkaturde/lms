<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-10">
        <div class="ibox">
            <div class="ibox-head">
            <div class="ibox-title">Attachments - <?=ucfirst($type);?> -  <?=$course_topic_info[0]->topic_name;?> <small>( <?=$course_topic_info[0]->course_name?> )</small></div>
                <!-- <div class="ibox-tools"> -->
                    <!-- <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a> -->
                    <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseAttchment">
                    <i class="fa fa-plus"></i> Add New File
                </button>
            </div>
            <div class="ibox-body">
              <div class="panel-body table-responsive">
                <table id="" class="table table-bordered">
                    <thead>
                                <tr>
                                    <th>Topic / Chapter Name</th>
                                    <th>File Name</th>
                                    <th>Link</th>
                                    <th>Downlaod</th>
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

