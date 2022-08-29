<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-10">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Attachments - <?=ucfirst($type);?> - <?=$course_topic_info[0]->topic_name;?>
                    <small>( <?=$course_topic_info[0]->course_name?> )</small></div>
                <!-- <div class="ibox-tools"> -->
                <!-- <a class="btn btn-primary text-white" onclick="enquiry(0)" ><i class="fa fa-plus"></i> Add Enquiry</a> -->
                <!-- <a class="ibox-collapse"><i class="fa fa-minus"></i></a> -->
                <!-- </div> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtopicattachment">
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





    <!-- Add New Course Modal -->
    <div class="modal fade" id="addtopicattachment" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-labelledby="addtopicattachmentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#d2ae6d">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <body>
                    <div class="container">
                        <br />
                        <h3 align="center">Ajax File Upload Progress Bar using PHP JQuery</h3>
                        <br />
                        <div class="panel panel-default">
                            <div class="panel-heading"><b>Ajax File Upload Progress Bar using PHP JQuery</b></div>
                            <div class="panel-body">
                                <form id="uploadImage" action="<?php echo base_url('course/uploadSubmit');?>" method="post">
                                    <div class="form-group">
                                        <label>File Upload</label>
                                        <input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png" />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="uploadSubmit" value="Upload" class="btn btn-info" />
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <div id="targetLayer" style="display:none;"></div>
                                </form>
                                <div id="loader-icon" style="display:none;"><img src="loader.gif" /></div>
                            </div>
                        </div>
                    </div>
                </body>
            </div>
        </div>
    </div>


    <script>
$(document).ready(function(){
 $('#uploadImage').submit(function(event){
  if($('#uploadFile').val())
  {
   event.preventDefault();
   $('#loader-icon').show();
   $('#targetLayer').hide();
   $(this).ajaxSubmit({
    target: '#targetLayer',
    beforeSubmit:function(){
     $('.progress-bar').width('50%');
    },
    uploadProgress: function(event, position, total, percentageComplete)
    {
     $('.progress-bar').animate({
      width: percentageComplete + '%'
     }, {
      duration: 1000
     });
    },
    success:function(){
     $('#loader-icon').hide();
     $('#targetLayer').show();
    },
    resetForm: true
   });
  }
  return false;
 });
});
</script>