<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'dashboard';?>" style="color: black !important"><i
                                class="fa fa-arrow-left"></i> Back</a>
                    </button>
                </div>

                <div class="ibox-title">Examination Details ( CourseWise )</div>
            </div>
            <div class="ibox-body">
                <div class="panel-body table-responsive">
                    <body>
                        <div class="container1">
                            <div class="row">

                            <?php foreach ($getstudentexaminationdata as $key => $value) { 
                                
                                if($value['peecentage']==100){
                                ?>

                                <div class="col-md-6 col-lg-4">
                                    <!-- Copy the content below until next comment -->
                                    <div class="card card-custom bg-white border-white border-0">

                                        <!--                                    
                                        <div class="card-custom-img" style="background-image: url(http://res.cloudinary.com/d3/image/upload/c_scale,q_auto:good,w_1110/trianglify-v1-cs85g_cc5d2i.jpg);">
                                        </div> -->

                                        <!-- <div class="card-custom-img" style="background-image: url(http://res.cloudinary.com/d3/image/upload/c_scale,q_auto:good,w_1110/trianglify-v1-cs85g_cc5d2i.jpg);">
                                        </div>
                                        
                                        <div class="card-custom-avatar">
                                            <img class="img-fluid" src="<?php echo base_url('assets/img/logos/iictn_lms.png'); ?>" alt="Avatar" />
                                        </div> -->

                                        <div class="">
                                            <img class="img-fluid" style=" display: block;margin-left: auto;margin-right: auto;width:50%;" src="<?php echo base_url('assets/img/logos/iictn_lms.png'); ?>" alt="Avatar" />
                                        </div> 

                                        <div class="card-body" style="overflow-y: auto;text-align: center;">
                                            <h4 class="card-title"><b>Examination</b></h4>
                                            <h3> <p class="card-text"> <?=$value['course_name'];?></p></h3>
                                              </hr>
                                            <!-- <h4 class="card-title"><b>Examination Title</b></h4>
                                            <p class="card-text"> <?=$value['exam_title'];?></p> -->

                                            <!-- <h4 class="card-title"><b>Examination Title</b></h4>
                                            <p class="card-text"> <?=$value['exam_title'];?></p> -->
                                        </div>
                                        <div class="card-footer" style="background: inherit; border-color: inherit;text-align: center;">
                                            <a href="<?php echo base_url().'studentexamination/'.$value['courseId'];?>" class="btn btn-primary">Go to Examination Page</a>
                                            <!-- <a href="#" class="btn btn-outline-primary">Other option</a> -->
                                        </div>
                                    </div>
                                </div>

                                <?php }else{ ?>

                                    
                               <?php }
                            } ?>
                            </div>
                        </div>
                    </body>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->

    <style>

html {
                        font-size: 14px;
                    }

                    .container1 {
                        font-size: 14px;
                        color: #666666;
                        font-family: "Open Sans";
                    }

    .card-custom {
        overflow: hidden;
        min-height: 450px;
        box-shadow: 0 0 15px rgba(10, 10, 10, 0.3);
    }

    .card-custom-img {
        height: 200px;
        min-height: 200px;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border-color: inherit;
    }

    /* First border-left-width setting is a fallback */
    .card-custom-img::after {
        position: absolute;
        content: '';
        top: 161px;
        left: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-top-width: 40px;
        border-right-width: 0;
        border-bottom-width: 0;
        border-left-width: 545px;
        border-left-width: calc(575px - 5vw);
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: inherit;
    }

    .card-custom-avatar img {
        border-radius: 50%;
        box-shadow: 0 0 15px rgba(10, 10, 10, 0.3);
        position: absolute;
        top: 100px;
        left: 1.25rem;
        width: 100px;
        height: 100px;
    }
    </style>