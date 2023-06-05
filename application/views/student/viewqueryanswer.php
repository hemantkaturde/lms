<?php 
$access = $this->session->userdata('access');
$jsonstringtoArray = json_decode($access, true);
$roleText = $this->session->userdata('roleText');

?>
<div class="content-wrapper">
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
            
                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url().'askqquery'?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>

                    <?php if($roleText=='Trainer'){ ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addanswer">
                        <i class="fa fa-plus"></i> Add Answer
                    </button>
                   <?php }?>

            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive ">
                    <p><b>Course Name : </b><?php echo $getquerydatabyid['0']['course_name']; ?></p> 
                    <p><b>Student Name : </b><?php echo $getquerydatabyid['0']['name']; ?></p> 
                    <p><b>Query : </b><?php echo $getquerydatabyid['0']['query']; ?></p> 

                    <table id="view_query_answer" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Answer</th>
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
