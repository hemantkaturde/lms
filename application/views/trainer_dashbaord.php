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
        <div class="row">
            <div class="col-lg-4" style="display:<?=$display?>">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">
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
                            <h2 class="s_date" style="font-size: 1.5rem !important;">Today Class Schedule
                                <?php echo "$day $month $year";?></h2>
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
                                                    echo '<div class="info1"><h4>'.$e['time'].'<img src="'.base_url().'css/images/delete.png" class="delete" alt="" title="delete this event" day="'.$day.'" val="'.$e['id'].'" />  <img src="'.base_url().'css/images/edit.png" class="edit" alt="" title="edit this event" day="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'    [ Trainer => '.$e['trainer'].']   [ Backup Trainer => '.$backup_trainername.'] </p></div>';
                                                }else{
                                                    echo '<div class="info2"><h4>'.$e['time'].'<img src="'.base_url().'css/images/delete.png" class="delete" alt="" title="delete this event" day="'.$day.'" val="'.$e['id'].'" />  <img src="'.base_url().'css/images/edit.png" class="edit" alt="" title="edit this event" day="'.$day.'" val="'.$e['id'].'" /></h4><p>'.$e['event'].'    [ Trainer => '.$e['trainer'].']   [ Backup Trainer => '.$backup_trainername.'] </p></div>';
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

            <div class="col-md-4 col-sm-4 col-xs-4">
                <h3 class=" textcenter mrgb0 borderr1"
                    style="background: #55acee;padding: 15px;font-size: 1.5rem !important;"><span class="color3">Student
                        Query, Please Answer</span></h3>
                <div style="border: 5px solid #55acee;padding: 12px;min-height: 300px;" class="borderr2">
                    <!-- <marquee width="100%" direction="up"  height="210px"> -->

                    <?php foreach ($getstudentqueryforttopicwisetriner as $key => $value) { ?>
                    <div class="testimonial pt-10 borderb" style="border-bottom: 1px solid rebeccapurple;">
                        <a href='<?php echo ADMIN_PATH."viewqueryanswer/".$value['queryid']?>'>
                            <div class="thumb pull-left mb-0 mr-0 pr-12">
                                <i class="fa fa-question-circle" style="font-size: xxx-large"></i>
                            </div>
                            <div class="ml-30 fs17fwb">
                                <p><b>Course : </b><?=$value['course_name']?></p>
                                <p><b>Topic : </b><?=$value['topic_name']?></p>
                                <p><b>Query : </b><?=$value['query']?> </p>
                                <p><b>Student Name : </b><?=$value['name']?> - <?=$value['datequery']?></p>
                            </div>
                        </a>
                    </div>
                    <?php  } ?>

                    <!-- </marquee> -->
                </div>

            </div>

            <div class="col-md-8 col-sm-8 col-xs-8">
                <h3 class=" textcenter mrgb0 borderr1"
                    style="background: #55acee;padding: 15px;font-size: 1.5rem !important;"><span class="color3">Student Answer Sheet for Checking</span></h3>
                    <div style="border: 5px solid #55acee;padding: 12px;min-height: 300px;" class="borderr2">
                        <table id="view_Staudent_result_list" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Mobile Number</th>
                                    <th>Course Name</th>
                                    <th>Exam Status</th>
                                    <th>Answer Sheet Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php 
                             if($getdataforexamchecking){
                                foreach ($getdataforexamchecking as $key_exam => $value_exam) {?>
                                    <tr>
                                        <td><?=$value_exam['name']?></td>
                                        <td><?=$value_exam['mobile']?></td>
                                        <td><?=$value_exam['course_name']?></td>
                                        <td><?=$value_exam['exam_status']?></td>
                                        <td><?=$value_exam['ans_sheet_status']?></td>
                                        <td><?=$value_exam['action']?></td>
                                    </tr>
                                 <?php } 
                             }else{ ?>
                                    <tr>
                                       <td> No Records Found</td>
                                    </tr>
                             <?php } ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
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

                    if (value.backup_trainername == null) {
                        var backup_trainername = '';
                    } else {
                        var backup_trainername = value.backup_trainername;
                    }

                    if (i % 2 == 0) {
                        html = html + '<div class="info1"><h4>' + value.time +
                            '<img src="" class="delete" alt="" title="delete this event" day="' +
                            day + '" val="' + value.id + '" /></h4><p>' + value.event +
                            ' [ Trainer => ' + value.trainer + ']' +
                            ' [ Backup Trainer => ' + backup_trainername + ']' +
                            '</p></div>';
                    } else {
                        html = html + '<div class="info2"><h4>' + value.time +
                            '<img src="" class="delete" alt="" title="delete this event" day="' +
                            day + '" val="' + value.id + '" /></h4><p>' + value.event +
                            ' [ Trainer => ' + value.trainer + ']' +
                            ' [ Backup Trainer => ' + backup_trainername + ']' +
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
    var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "light",
        "dataProvider": chartData,
        "valueAxes": [{
            "gridColor": "#FFFFFF",
            "gridAlpha": 0.2,
            "dashLength": 0
        }],
        "gridAboveGraphs": true,
        "startDuration": 1,
        "graphs": [{
            "balloonText": "[[category]]: <b>[[value]]</b>",
            "fillAlphas": 0.8,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "count"
        }],
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
    });
} catch (e) {
    console.log(e);
}
</script>