<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/event.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/colorbox.css" />

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">

        <div class="col-lg-12 col-md-12">
        <h5><b> Course Class Schedule</b></h5>
            <table class="table  table-condensed" style="background-color:#cec4de">
            <thead>
                <tr>
                <th scope="col">Course Name</th>
                <th scope="col">Topic Name</th>
                <th scope="col">Class Date</th>
                <th scope="col">Class Timings</th>
                <th scope="col"> Class link</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

             <?php foreach ($upcoming_class_links as $key => $value) {
               ?>
                <tr>
                    <td><?=$value['course_name'] ?></td>
                    <td><?=$value['title'] ?></td>
                    <td><?=$value['date'] ?></td>
                    <td><?=$value['classtime'] ?></td>
                    <td><?=$value['link_url'] ?></td>
                    <td>

					 <?php if($value['attendance_alreday_exits']!='1'){ ?>
                       <?php if($value['link_url']){?>
                             <button id="join_link" style="width: 51%;" class="join_link" user-id="<?=$value['userid']?>" topic-id="<?=$value['topicid']?>" course-id="<?=$value['courseId']?>" meeting_id="<?=$value['meeting_id']?>"  meeting_link="<?=$value['link_url']?>" >JOIN</button>
                       <?php } else{ ?>
                             <button id="attend_manually" class="attend_manually" user-id="<?=$value['userid']?>" topic-id="<?=$value['topicid']?>" course-id="<?=$value['courseId']?>" meeting_id="<?=$value['meeting_id']?>">Click To Attend</button>
                       <?php }?>
					 <?php } ?>  
                    </td>
                </tr>
             <?php }  ?>   
            </tbody>
            </table>
    



	<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<div class=" d-flex justify-container-left">
		<div class="row">
			<div class="col-md-12">
				<div id="piechart3d" style="width: 700px; height: 400px;"></div>
			</div>
		</div>
	</div> -->

<?php
 
$dataPoints = array(
	array("label"=> "WordPress", "y"=> 60.0),
	array("label"=> "Joomla", "y"=> 6.5),
	array("label"=> "Drupal", "y"=> 4.6),
	array("label"=> "Magento", "y"=> 2.4),
	array("label"=> "Blogger", "y"=> 1.9),
	array("label"=> "Shopify", "y"=> 1.8),
	array("label"=> "Bitrix", "y"=> 1.5),
	array("label"=> "Squarespace", "y"=> 1.5),
	array("label"=> "PrestaShop", "y"=> 1.3),
	array("label"=> "Wix", "y"=> 0.9),
	array("label"=> "OpenCart", "y"=> 0.8)
);
	
?>

<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
</body>
</html>    



</div>
    <!-- END PAGE CONTENT-->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script>

window.onload = function () {
 
 var chart = new CanvasJS.Chart("chartContainer", {
	 animationEnabled: true,
	 theme: "light2",
	 title: {
		 text: "Student Course Progress"
	 },
	 axisY: {
		 suffix: "%",
		 scaleBreaks: {
			 autoCalculate: true
		 }
	 },
	 data: [{
		 type: "column",
		 yValueFormatString: "#,##0\"%\"",
		 indexLabel: "{y}",
		 indexLabelPlacement: "inside",
		 indexLabelFontColor: "white",
		 dataPoints: <?php echo json_encode($getStudentscourseattetendancedetails, JSON_NUMERIC_CHECK); ?>
	 }]
 });
 chart.render();
  
 }

$(document).ready(function(){
    $(".join_link").click(function(){

                    var user_id = $(this).attr("user-id");
                    var topic_id = $(this).attr("topic-id");
                    var course_id = $(this).attr("course-id");
                    var meeting_id = $(this).attr("meeting_id");
                    var meeting_link = $(this).attr("meeting_link");
                    
                    $.ajax({
						url : "<?php echo base_url();?>attendClasses",
						type: "POST",
                        data : 'user_id='+user_id+'&topic_id='+topic_id+'&course_id='+course_id+'&meeting_id='+meeting_id+'&meeting_link='+meeting_link,
						// data : {'user_id':user_id,'topic_id':topic_id,'course_id':course_id,'meeting_id':meeting_id,'meeting_link':meeting_link},
						success: function(data, textStatus, jqXHR)
						{

							var fetchResponse = $.parseJSON(data);
							if(fetchResponse.status == "failure")
							{
								$.each(fetchResponse.error, function (i, v)
								{
									$('.'+i+'_error').html(v);
								});
							}
							else if(fetchResponse.status == 'success')
							{
								 swal({
									title: "Attendance Successfully Done",
								    text: "",
								 	icon: "success",
								 	button: "Ok",
								 	},function(){ 
										$("#popup_modal_md").hide();
                                        //window.location.href = meeting_link;
                                        window.open(meeting_link, '_blank');

										//window.location.href = "<?php echo base_url().'dashboard'?>";
								});						
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							//$(".loader_ajax").hide();
						}
					});
				return false;

    });
});

$(document).ready(function(){
    $(".attend_manually").click(function(){
                    var user_id = $(this).attr("user-id");
                    var topic_id = $(this).attr("topic-id");
                    var course_id = $(this).attr("course-id");
                    var meeting_id = $(this).attr("meeting_id");
                    var meeting_link = $(this).attr("meeting_link");
                    
                    $.ajax({
						url : "<?php echo base_url();?>attendClasses",
						type: "POST",
                        data : 'user_id='+user_id+'&topic_id='+topic_id+'&course_id='+course_id+'&meeting_id='+meeting_id+'&meeting_link='+meeting_link,
						// data : {'user_id':user_id,'topic_id':topic_id,'course_id':course_id,'meeting_id':meeting_id,'meeting_link':meeting_link},
						success: function(data, textStatus, jqXHR)
						{

							var fetchResponse = $.parseJSON(data);
							if(fetchResponse.status == "failure")
							{
								$.each(fetchResponse.error, function (i, v)
								{
									$('.'+i+'_error').html(v);
								});
							}
							else if(fetchResponse.status == 'success')
							{
								 swal({
									title: "Attendance Successfully Done",
								    text: "",
								 	icon: "success",
								 	button: "Ok",
								 	},function(){ 
										$("#popup_modal_md").hide();
                                        //window.location.href = meeting_link;
                                        //window.open(meeting_link, '_blank');

										window.location.href = "<?php echo base_url().'dashboard'?>";
								});						
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							//$(".loader_ajax").hide();
						}
					});
				return false;

    });
});
</script>