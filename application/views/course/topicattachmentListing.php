<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">


                  <button type="button" class="btn btn-primary">
                        <a href="<?php echo base_url().'/addchapters/'.$course_topic_info[0]->courseId;?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                  </button>

                <div class="ibox-title">Attachments- <?=$course_topic_info[0]->topic_name;?> <small>( <?=$course_topic_info[0]->course_name?> )</small></div>

                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseAttchment">
                    <i class="fa fa-plus"></i> Add Topic / Chapter
                </button> -->
            </div>
            <div class="ibox-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-margin">
                                <div class="card-header no-border">
                                    <h5 class="card-title"><i class="fa fa-file-text" aria-hidden="true"></i> NOTES</h5>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-success">
                                                <span class="widget-49-date-day"><?=$documents?></span>
                                                <!-- <span class="widget-49-date-month">apr</span> -->
                                            </div>
                                            <div class="widget-49-meeting-info">
                                                <span class="widget-49-pro-title"><?=$course_topic_info[0]->topic_name;?></span>
                                                <!-- <span class="widget-49-meeting-time">12:00 to 13.30 Hrs</span> -->
                                            </div>
                                        </div>
                                        <ol class="widget-49-meeting-points">
                                            <li class="widget-49-meeting-item"><span>All Types of Doc.</span>
                                            </li>
                                            <li class="widget-49-meeting-item"><span>Word,Pdf,Notepad,xml</span>
                                            </li>
                                            <!-- <li class="widget-49-meeting-item"><span>Session timeout increase to 30
                                                    minutes</span></li> -->
                                        </ol>
                                        <div class="widget-49-meeting-action">
                                            <a href="<?php echo ADMIN_PATH.'viewalltopicdocuments?type=documents&topic_id='.$_GET['topic_id'].'&course_id='.$_GET['course_id']; ?>" class="btn btn-sm btn-flash-border-primary">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-margin">
                                <div class="card-header no-border">
                                    <h5 class="card-title"><i class="fa fa-video-camera" aria-hidden="true"></i> VIDEOS</h5>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-success">
                                                <span class="widget-49-date-day"><?=$videos?></span>
                                                <!-- <span class="widget-49-date-month">apr</span> -->
                                            </div>
                                            <div class="widget-49-meeting-info">
                                                <span class="widget-49-pro-title"><?=$course_topic_info[0]->topic_name;?></span>
                                                <!-- <span class="widget-49-meeting-time">12:00 to 13.30 Hrs</span> -->
                                            </div>
                                        </div>
                                        <ol class="widget-49-meeting-points">
                                            <li class="widget-49-meeting-item"><span>All Types of Videos</span>
                                            </li>
                                            <li class="widget-49-meeting-item"><span>MP4</span></li>
                                            <!-- <li class="widget-49-meeting-item"><span>Client request to send
                                                    invoice</span></li> -->
                                        </ol>
                                        <div class="widget-49-meeting-action">
                                            <a href="<?php echo ADMIN_PATH.'viewalltopicdocuments?type=videos&topic_id='.$_GET['topic_id'].'&course_id='.$_GET['course_id']; ?>" class="btn btn-sm btn-flash-border-warning">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-lg-4">
                            <div class="card card-margin">
                                <div class="card-header no-border">
                                    <h5 class="card-title"><i class="fa fa-book" aria-hidden="true"></i> BOOKS</h5>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-success">
                                                <span class="widget-49-date-day"><?=$books?></span>
                                                <span class="widget-49-date-month">apr</span>
                                            </div>
                                            <div class="widget-49-meeting-info">
                                                <span class="widget-49-pro-title"><?=$course_topic_info[0]->topic_name;?></span>
                                              <span class="widget-49-meeting-time">12:00 to 13.30 Hrs</span> 
                                            </div>
                                        </div>
                                        <ol class="widget-49-meeting-points">
                                            <li class="widget-49-meeting-item"><span>All Types of Books</span>
                                            </li>
                                            <li class="widget-49-meeting-item"><span>Pdf,Word,PPT</span>
                                            </li> -->
                                            <!-- <li class="widget-49-meeting-item"><span>Received approval to start
                                                    wire-frame</span></li> -->
                                        <!-- </ol>
                                        <div class="widget-49-meeting-action">
                                            <a href="<?php echo ADMIN_PATH.'viewalltopicdocuments?type=books&topic_id='.$_GET['topic_id'].'&course_id='.$_GET['course_id']; ?>" class="btn btn-sm btn-flash-border-success">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>

    <style>
    body {
        background: #F4F7FD;
        /* margin-top: 20px; */
    }

    .card-margin {
        margin-bottom: 1.875rem;
    }

    .card {
        border: 0;
        box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #ffffff;
        background-clip: border-box;
        border: 1px solid #e6e4e9;
        border-radius: 8px;
    }

    .card .card-header.no-border {
        border: 0;
    }

    .card .card-header {
        background: none;
        padding: 0 0.9375rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        min-height: 50px;
        background-color :#d2ae6d;
    }

    .card-header:first-child {
        border-radius: calc(8px - 1px) calc(8px - 1px) 0 0;
    }

    .widget-49 .widget-49-title-wrapper {
        display: flex;
        align-items: center;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #edf1fc;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-day {
        color: #4e73e5;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
        color: #4e73e5;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #fcfcfd;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-day {
        color: #dde1e9;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-month {
        color: #dde1e9;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-success {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #e8faf8;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-day {
        color: #17d1bd;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-month {
        color: #17d1bd;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-info {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #ebf7ff;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-day {
        color: #36afff;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-month {
        color: #36afff;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-warning {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: floralwhite;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-day {
        color: #FFC868;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-month {
        color: #FFC868;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-danger {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #feeeef;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-day {
        color: #F95062;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-month {
        color: #F95062;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-light {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #fefeff;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-day {
        color: #f7f9fa;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-month {
        color: #f7f9fa;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-dark {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #ebedee;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-day {
        color: #394856;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-month {
        color: #394856;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-base {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #f0fafb;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-day {
        color: #68CBD7;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-month {
        color: #68CBD7;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-meeting-info {
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-pro-title {
        color: #3c4142;
        font-size: 14px;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-meeting-time {
        color: #B1BAC5;
        font-size: 13px;
    }

    .widget-49 .widget-49-meeting-points {
        font-weight: 400;
        font-size: 13px;
        margin-top: .5rem;
    }

    .widget-49 .widget-49-meeting-points .widget-49-meeting-item {
        display: list-item;
        color: #727686;
    }

    .widget-49 .widget-49-meeting-points .widget-49-meeting-item span {
        margin-left: .5rem;
    }

    .widget-49 .widget-49-meeting-action {
        text-align: right;
    }

    .widget-49 .widget-49-meeting-action a {
        text-transform: uppercase;
    }
    </style>