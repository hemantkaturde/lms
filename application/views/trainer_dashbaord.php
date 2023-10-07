<?php 
$pageUrl =$this->uri->segment(1);
$access = $this->session->userdata('access');
$roleText = $this->session->userdata('roleText');

?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/event.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/colorbox.css" />

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
      
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
                                            if($i % 2 == 0){
                                                    echo '<div class="info1"><h4>'.$e['time'].'<img src="'.base_url().'css/images/delete.png" class="delete" alt="" title="delete this event" day="'.$day.'" val="'.$e['id'].'" />  <img src="'.base_url().'css/images/edit.png" class="edit" alt="" title="edit this event" day="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'    [ Trainer => '.$e['trainer'].']   [ Backup Trainer => '.$e['backup_trainername'].'] </p></div>';
                                                }else{
                                                    echo '<div class="info2"><h4>'.$e['time'].'<img src="'.base_url().'css/images/delete.png" class="delete" alt="" title="delete this event" day="'.$day.'" val="'.$e['id'].'" />  <img src="'.base_url().'css/images/edit.png" class="edit" alt="" title="edit this event" day="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'    [ Trainer => '.$e['trainer'].']   [ Backup Trainer => '.$e['backup_trainername'].'] </p></div>';
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
                        if (i % 2 == 0) {
                            html = html + '<div class="info1"><h4>' + value.time +
                                '<img src="" class="delete" alt="" title="delete this event" day="' +
                                day + '" val="' + value.id + '" /></h4><p>' + value.event + ' [ Trainer => '+value.trainer+']'+ ' [ Backup Trainer => '+value.backup_trainername+']'+
                                '</p></div>';
                        } else {
                            html = html + '<div class="info2"><h4>' + value.time +
                                '<img src="" class="delete" alt="" title="delete this event" day="' +
                                day + '" val="' + value.id + '" /></h4><p>' + value.event + ' [ Trainer => '+value.trainer+']'+ ' [ Backup Trainer => '+value.backup_trainername+']'+
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