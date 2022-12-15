<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/event.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/colorbox.css" />

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">

        <div class="col-lg-8 col-md-8">
        <h5><b> Class Details</b></h5>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Course Name</th>
                <th scope="col">Topic Name</th>
                <th scope="col">Date</th>
                <th scope="col">Link</th>
                </tr>
            </thead>
            <tbody>

             <?php $i=1; foreach ($upcoming_class_links as $key => $value) {
                # code...
               ?>
                <tr>
                    <th scope="row"><?=$i++ ?></th>
                    <td><?=$value['topic_name'] ?></td>
                    <td><?=$value['timings'] ?></td>
                    <td><?=$value['link_url'] ?></td>
                    <td><?=$value['link_url'] ?></td>
                </tr>
             <?php }  ?>   
            </tbody>
            </table>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
