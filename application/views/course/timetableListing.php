<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
?>
<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Time Table Management</div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addYear">
                    <i class="fa fa-plus"></i> Add Year
                </button>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <table id="view_time_table_list" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Year List</th>
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