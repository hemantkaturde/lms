<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/event.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/colorbox.css" />

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">

        <div class="col-lg-10 col-md-10">
        <h5><b> Class Details</b></h5>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">Course Name</th>
                <th scope="col">Topic Name</th>
                <th scope="col">Date</th>
                <th scope="col">Timings</th>
                <th scope="col">Link</th>
                </tr>
            </thead>
            <tbody>

             <?php foreach ($upcoming_class_links as $key => $value) {
               ?>
                <tr>
                    <td><?=$value['course_name'] ?></td>
                    <td><?=$value['title'] ?></td>
                    <td><?=$value['date'] ?></td>
                    <td><?=$value['timings'] ?></td>
                    <td><?=$value['link_url'] ?></td>
                </tr>
             <?php }  ?>   
            </tbody>
            </table>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
