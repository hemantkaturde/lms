<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <!-- <div class="ibox-title">Time Table Management</div> -->
                <div class="ibox-title">Time Table Management - <?=$getCourseinfo[0]->course_name;?> <small>( <?=$getCourseinfo[0]->course_name?> )</small></div>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewtimetable">
                    <i class="fa fa-plus"></i> Add New Time Table
                </button>
                <input name="course_id_form" id="course_id_form" type="hidden" value="<?php echo $course_id; ?>" />
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_time_table_list" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Month Name</th>
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


<!-- Add New User Modal -->
<div class="modal fade" id="addNewtimetable" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="addNewtimetableLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#d2ae6d">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#000">Add New Time Table</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php
            $attributes = array("name"=>"addNewtimetable_form","id"=>"addNewtimetable_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data", "autocomplete"=>"off"); 
            echo form_open("", $attributes);
         ?>
        <div class="modal-body">
            <div class="container">
            <div class="row col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="form-group">
                     <label style="text-align: left;"  for="form_date">From Date<span class="required">*</span>
                     </label>
                     <div>
                        <input  maxlength="25" type="text" id="form_date" name="form_date"  placeholder="Enter From Date" autocomplete="off" class="form-control  datepicker col-md-12 col-xs-12">
                        <input type="hidden" id="course_id_post" name="course_id_post" value="<?=$getCourseinfo[0]->courseId;?>">
                        <p class="error form_date_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="to_name">To Date<span class="required">*</span>
                     </label>
                     <div>
                        <input  maxlength="25" type="text" id="to_name" name="to_name"  placeholder="Enter To Date" autocomplete="off" class="form-control datepicker col-md-12 col-xs-12">
                        <p class="error to_name_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="select_month">Month<span class="required">*</span>
                     </label>
                     <div>
                        <select placeholder="Select Month" class="form-control">
                            <option name="" value="" style="display:none;">Select Month</option>
                            <option name="January" value="January">January</option>
                            <option name="February" value="February">February</option>
                            <option name="March" value="March">March</option>
                            <option name="April" value="April">April</option>
                            <option name="May" value="May">May</option>
                            <option name="June" value="June">June</option>
                            <option name="July" value="July">July</option>
                            <option name="August" value="August">August</option>
                            <option name="September" value="September">September</option>
                            <option name="October" value="October">October</option>
                            <option name="November" value="November">November</option>
                            <option name="December" value="December">December</option>
                        </select>
                        <p class="error select_month_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="year">Year<span class="required">*</span>
                     </label>
                     <div>
                        <input  maxlength="25" type="text" id="year_name" name="year_name"  placeholder="Enter Year" autocomplete="off" class="form-control col-md-12 col-xs-12">
                       
                        <p class="error year_name_error"></p>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="text-align: left;"  for="topic_name"> Upload File <span class="required">*</span>
                     </label>
                     <div>
                         <input name="file" id="fileInput" type="file" class="demoInputBox form-control" required/>
                        <p class="error topic_name_error"></p>
                     </div>
                  </div>

              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="save_course_topic" class="btn btn-primary save_course_topic">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>