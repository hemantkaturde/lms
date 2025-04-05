<?php 
$pageUrl =$this->uri->segment(1);
$access = $this->session->userdata('access');
$roleText = $this->session->userdata('roleText');



if($roleText=="Counsellor"){

    $display = "none";

}else{
    $display = "block";
}

?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/event.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/colorbox.css" />

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-3 col-md-6">
            <a class="dashbord-short-link totalcourses" href="<?php echo base_url().'courselisting'?>">
                <div class="ibox bg-success color-white widget-stat">
                    <div class="ibox-body banner-box">
                        <h2 class="m-b-5 font-strong"><?php echo $courses; ?></h2>
                        <div class="m-b-5">COURSES</div><i class="fa fa-book widget-stat-icon"></i>
                        <!-- <div><i class="fa fa-level-up m-r-5"></i><small>25% higher</small></div> -->
                        <div><i class="fa fa-level-up m-r-5"></i><small>Courses Uploaded</small></div>
                    </div>
                </div>
             </a>
            </div>
            <div class="col-lg-3 col-md-6">
            <a class="dashbord-short-link totalenquiries" href="<?php echo base_url().'enquirylisting'?>">
                <div class="ibox bg-info color-white widget-stat">
                    <div class="ibox-body banner-box">
                        <h2 class="m-b-5 font-strong"><?php echo $enquries; ?></h2>
                        <div class="m-b-5">ENQUIRIES</div><i class="fa fa-phone-square widget-stat-icon"></i>
                        <!-- <div><i class="fa fa-level-up m-r-5"></i><small>17% higher</small></div> -->
                        <div><i class="fa fa-level-up m-r-5"></i><small>Total Enquiries</small></div>
                    </div>
                </div>
            </a>    
            </div>
            <div class="col-lg-3 col-md-6">
              <a class="dashbord-short-link totaladmissions"  href="<?php echo base_url().'admissionListing'?>">
                <div class="ibox bg-warning color-white widget-stat">
                    <div class="ibox-body banner-box">
                        <h2 class="m-b-5 font-strong"><?php echo $admissions; ?></h2>
                        <div class="m-b-5">TOTAL ADMISSIONS</div><i class="fa fa-money widget-stat-icon"></i>
                        <!-- <div><i class="fa fa-level-up m-r-5"></i><small>22% higher</small></div> -->
                        <div><i class="fa fa-level-up m-r-5"></i><small>Total Admissions</small></div>

                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-6" style="display:<?=$display?>">
            <a class="dashbord-short-link totalusers"  href="<?php echo base_url().'userListing'?>">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body banner-box">
                        <h2 class="m-b-5 font-strong"><?php echo $users; ?></h2>
                        <div class="m-b-5">USERS</div><i class="fa fa-users widget-stat-icon"></i>
                        <!-- <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div> -->
                        <div><i class="fa fa-level-up m-r-5"></i><small>Staff Users</small></div>
                    </div>
                </div>
            </a>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="flexbox mb-4">
                            <div>
                                <h3 class="m-0">Statistics</h3>
                                <div>Your shop sales analytics</div>
                            </div>
                            <div class="d-inline-flex">
                                <div class="px-3" style="border-right: 1px solid rgba(0,0,0,.1);">
                                    <div class="text-muted">WEEKLY INCOME</div>
                                    <div>
                                        <span class="h2 m-0">$850</span>
                                        <span class="text-success ml-2"><i class="fa fa-level-up"></i> +25%</span>
                                    </div>
                                </div>
                                <div class="px-3">
                                    <div class="text-muted">WEEKLY SALES</div>
                                    <div>
                                        <span class="h2 m-0">240</span>
                                        <span class="text-warning ml-2"><i class="fa fa-level-down"></i> -12%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <canvas id="bar_chart" style="height:260px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Statistics</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <canvas id="doughnut_chart" style="height:160px;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <div class="m-b-20 text-success"><i class="fa fa-circle-o m-r-10"></i>Desktop 52%</div>
                                <div class="m-b-20 text-info"><i class="fa fa-circle-o m-r-10"></i>Tablet 27%</div>
                                <div class="m-b-20 text-warning"><i class="fa fa-circle-o m-r-10"></i>Mobile 21%</div>
                            </div>
                        </div>
                        <ul class="list-group list-group-divider list-group-full">
                            <li class="list-group-item">Chrome
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> 24%</span>
                            </li>
                            <li class="list-group-item">Firefox
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> 12%</span>
                            </li>
                            <li class="list-group-item">Opera
                                <span class="float-right text-danger"><i class="fa fa-caret-down"></i> 4%</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row" >
            <div class="col-lg-4" style="display:<?=$display?>">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title" >
                            <h2 style="font-size: 1.5rem !important;">Monthly Class Schedule </h2>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="row align-items-center" style="margin-left: 21px;">
                            <div class="calendar">
                                <?php echo $notes?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">
                            <h2 class="s_date" style="font-size: 1.5rem !important;">Today Class Schedule <?php echo "$day $month $year";?></h2>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="col-lg-12">
                            <div class="event_detail">
                                <!-- <h2 class="s_date">Detail Event <?php echo "$day $month $year";?></h2> -->
                                <div class="detail_event">
                                    <?php 
                                        if(isset($events)){
                                            $i = 1;
                                            foreach($events as $e){

                                                if($e['backup_trainername']){
                                                    $backup_trainername=$e['backup_trainername'];
                                                }else{
                                                    $backup_trainername='';
                                                }

                                            if($i % 2 == 0){
                                                    echo '<div class="info1"><h4>'.$e['time'].'<img src="'.base_url().'css/images/delete.png" class="delete" alt="" title="delete this event" day="'.$day.'" val="'.$e['id'].'" />  <img src="'.base_url().'css/images/edit.png" class="edit" alt="" title="edit this event" day="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'    [ Trainer => '.$e['trainer'].']   [ Backup Trainer => '.$backup_trainername.'] [ Class Link => <a href="'.$e['topic_link'].'" target="_blank">'.$e['topic_link'].'</a>]</p></div>';
                                                }else{
                                                    echo '<div class="info2"><h4>'.$e['time'].'<img src="'.base_url().'css/images/delete.png" class="delete" alt="" title="delete this event" day="'.$day.'" val="'.$e['id'].'" />  <img src="'.base_url().'css/images/edit.png" class="edit" alt="" title="edit this event" day="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'    [ Trainer => '.$e['trainer'].']   [ Backup Trainer => '.$backup_trainername.'] [ Class Link => <a href="'.$e['topic_link'].'" target="_blank">'.$e['topic_link'].'</a>]</p></div>';
                                                } 
                                                $i++;
                                            }
                                        }else{
                                            echo '<div class="message"><h4>No Class</h4><p>There\'s no class in this date</p></div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <!-- <div class="col-lg-8" style="display:<?=$display?>"> -->
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="flexbox mb-4">
                            <div>
                                <h3 class="m-0">Statistics</h3>
                                <div>Daily Admissions Count</div>
                            </div>
                            <div class="d-inline-flex">

                            <div class="px-3" style="border-right: 1px solid rgba(0,0,0,.1);">
                                    <div class="text-muted">Total Course Fees</div>
                                    <div>
                                        <span class="h2 m-0"><?='₹ '. $total_pending?></span>
                                        <!-- <span class="text-success ml-2"><i class="fa fa-level-up"></i> +25%</span> -->
                                    </div>
                                </div>

                                <div class="px-3" style="border-right: 1px solid rgba(0,0,0,.1);">
                                    <div class="text-muted">Total Revenue</div>
                                    <div>
                                        <span class="h2 m-0"><?='₹ '. $total_revenue?></span>
                                        <!-- <span class="text-success ml-2"><i class="fa fa-level-up"></i> +25%</span> -->
                                    </div>
                                </div>
                                <div class="px-3">
                                    <div class="text-muted">Fees Pending</div>
                                    <div>
                                        <span class="h2 m-0"><?='₹ '.$total_pending_amt?></span>
                                        <!-- <span class="text-warning ml-2"><i class="fa fa-level-down"></i> -12%</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <!-- <canvas id="bar_chart" style="height:260px;"></canvas> -->
                            <div class="row">
                                <div id="chartdiv" style="width: 900px; height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Add On Course Total Revenue</div>
                    </div>

                    <div class="ibox-body">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="m-b-20"><i class="fa fa-money m-r-10"></i>Total Course Fees <H3>₹ <?=$total_pending_add_on;?> </H3></div>
                                <div class="m-b-20"><i class="fa fa-money m-r-10"></i>Total Revenue <H3>₹ <?=$total_revenue_add_on;?> </H3></div>
                                <div class="m-b-20"><i class="fa fa-money m-r-10"></i>Total Pending Fees <H3>₹ <?=$total_pending_amt_add_on;?> </H3></div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox-head">
                        <div class="ibox-title">Statistics</div>
                    </div>

                    <div class="ibox-body">
                        <!-- <div class="row align-items-center">
                            <div class="col-md-6">
                                <canvas id="doughnut_chart" style="height:160px;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <div class="m-b-20 text-success"><i class="fa fa-circle-o m-r-10"></i>Desktop 52%</div>
                                <div class="m-b-20 text-info"><i class="fa fa-circle-o m-r-10"></i>Tablet 27%</div>
                                <div class="m-b-20 text-warning"><i class="fa fa-circle-o m-r-10"></i>Mobile 21%</div>
                            </div>
                        </div> -->
                        <ul class="list-group list-group-divider list-group-full">
                            <!-- <li class="list-group-item">Attendance List - 50
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> Click Here</span>
                            </li> -->

                            <li class="list-group-item">Enquiry List - <?php echo $enquries; ?>
                                <a class="dashbord-short-link totalenquiry"
                                    href="<?php echo base_url().'enquirylisting'?>"><span class="float-right text-success"><i class="fa fa-caret-up"></i> Click Here</span></a>
                            </li>

                            <li class="list-group-item">Admissions List - <?php echo $admissions; ?>
                                <a class="dashbord-short-link totaladmissions"
                                    href="<?php echo base_url().'admissionListing'?>"><span class="float-right text-success"><i class="fa fa-caret-up"></i> Click Here</span></a>
                            </li>
                            <li class="list-group-item">Total Invoice - <?=$total_invoices?>
                                <a class="dashbord-short-link totalusers"
                                    href="<?php echo base_url().'taxinvoices'?>"> <span class="float-right text-success"><i class="fa fa-caret-up"></i> Click Here</span></a>
                            </li>
                            <!-- <li class="list-group-item">Payment Pending - 50
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> Click Here</span>
                            </li> -->
                            <!-- <li class="list-group-item">Opera
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> Click Here</span>
                            </li>
                            <li class="list-group-item">Opera
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> Click Here</span>
                            </li>
                            <li class="list-group-item">Opera
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> Click Here</span>
                            </li>
                            <li class="list-group-item">Opera
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> Click Here</span>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- 
        <div class="row">
            <div id="evencal">
                <div class="calendar">
                    <?php echo $notes?>
                </div>
                <div class="event_detail">
                    <h2 class="s_date">Detail Event <?php echo "$day $month $year";?></h2>
                    <div class="detail_event">
                        <?php 
                            if(isset($events)){
                                $i = 1;
                                foreach($events as $e){
                                if($i % 2 == 0){
                                        echo '<div class="info1"><h4>'.$e['time'].'<img src="'.base_url().'css/images/delete.png" class="delete" alt="" title="delete this event" day="'.$day.'" val="'.$e['id'].'" />  <img src="'.base_url().'css/images/edit.png" class="edit" alt="" title="edit this event" day="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'</p></div>';
                                    }else{
                                        echo '<div class="info2"><h4>'.$e['time'].'<img src="'.base_url().'css/images/delete.png" class="delete" alt="" title="delete this event" day="'.$day.'" val="'.$e['id'].'" />  <img src="'.base_url().'css/images/edit.png" class="edit" alt="" title="edit this event" day="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'</p></div>';
                                    } 
                                    $i++;
                                }
                            }else{
                                echo '<div class="message"><h4>No Event</h4><p>There\'s no event in this date</p></div>';
                            }
                        ?>
                    </div>
                </div>
           </div>
        </div> -->
    </div>
    <!-- END PAGE CONTENT-->

    <script type="text/javascript" src=" https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js"></script>

    <script>
    $(".detail").live('click', function() {
        $(".s_date").html("Detail Event for " + $(this).attr('val') + " <?php echo "$month $year";?>");
        var day = $(this).attr('val');
        var add = '<input type="button" name="add" value="Add Event" val="' + day + '" class="add_event"/>';
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "<?php echo site_url("admin/detail_event");?>",
            data: {
                <?php echo "year: $year, mon: $mon";?>,
                day: day
            },
            success: function(data) {
                var html = '';
                if (data.status) {
                    var i = 1;
                    $.each(data.data, function(index, value) {

                        if(value.backup_trainername==null){
                           var backup_trainername ='';
                        }else{
                            var backup_trainername =value.backup_trainername;
                        }
                        if (i % 2 == 0) {
                            html = html + '<div class="info1"><h4>' + value.time +
                                '<img src="" class="delete" alt="" title="delete this event" day="' +
                                day + '" val="' + value.id + '" /></h4><p>' + value.event + ' [ Trainer => '+value.trainer+']'+ ' [ Backup Trainer => '+backup_trainername+']'+
                                '</p></div>';
                        } else {
                            html = html + '<div class="info2"><h4>' + value.time +
                                '<img src="" class="delete" alt="" title="delete this event" day="' +
                                day + '" val="' + value.id + '" /></h4><p>' + value.event + ' [ Trainer => '+value.trainer+']'+ ' [ Backup Trainer => '+backup_trainername+']'+
                                '</p></div>';
                        }
                        i++;
                    });
                } else {
                    html = '<div class="message"><h4>' + data.title_msg + '</h4><p>' + data.msg +
                        '</p></div>';
                }
                //html = html+add;
                $(".detail_event").fadeOut("slow").fadeIn("slow").html(html);
            }
        });
    });
    </script>


<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

<script>
    var chartData = JSON.parse(`<?php echo $chart_data; ?>`);
            try {
          var chart = AmCharts.makeChart( "chartdiv", {
          "type": "serial",
          "theme":"light",
          "dataProvider": chartData,
          "valueAxes": [ {
          "gridColor": "#FFFFFF",
          "gridAlpha": 0.2,
          "dashLength": 0
          } ],
          "gridAboveGraphs": true,
          "startDuration": 1,
          "graphs": [ {
          "balloonText": "[[category]]: <b>[[value]]</b>",
          "fillAlphas": 0.8,
          "lineAlpha": 0.2,
          "type": "column",
          "valueField": "count"
          } ],
          "chartScrollbar": {
          "graph": "g1",
          "scrollbarHeight": 60,
          "backgroundAlpha": 0,
          "selectedBackgroundAlpha": 0.1,
          "selectedBackgroundColor": "#888888",
          "graphFillAlpha": 0,
          "graphLineAlpha": 0.5,
          "selectedGraphFillAlpha": 0,
          "selectedGraphLineAlpha": 1,
          "autoGridCount": true,
          "color": "#AAAAAA",
          "oppositeAxis": false
                    },
          "chartCursor": {
          "categoryBalloonEnabled": false,
          "cursorAlpha": 0,
          "zoomable": false
          },
          "categoryField": "date",
          "categoryAxis": {
          "gridPosition": "start",
          "gridAlpha": 0,
          "tickPosition": "start",
          "tickLength": 20
          },
          "export": {
          "enabled": true
          }
        } );           
            }
            catch( e ) {
              console.log( e );
            }
    </script> 

    <style>
        .amcharts-chart-div a{
            display:none !important;
        } 
    </style>