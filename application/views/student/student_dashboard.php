<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/event.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/colorbox.css" />


<style>
	/* body{
    margin-top:20px;
    background:#f3f3f3;
} */

.card.user-card {
    border-top: none;
    -webkit-box-shadow: 0 0 1px 2px rgba(0,0,0,0.05), 0 -2px 1px -2px rgba(0,0,0,0.04), 0 0 0 -1px rgba(0,0,0,0.05);
    box-shadow: 0 0 1px 2px rgba(0,0,0,0.05), 0 -2px 1px -2px rgba(0,0,0,0.04), 0 0 0 -1px rgba(0,0,0,0.05);
    -webkit-transition: all 150ms linear;
    transition: all 150ms linear;
}

.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.card .card-header {
    background-color: transparent;
    border-bottom: none;
    padding: 25px;
}

.card .card-header h5 {
    margin-bottom: 0;
    color: #222;
    font-size: 14px;
    font-weight: 600;
    display: inline-block;
    margin-right: 10px;
    line-height: 1.4;
}

.card .card-header+.card-block, .card .card-header+.card-block-big {
    padding-top: 0;
}

.user-card .card-block {
    text-align: center;
}

.card .card-block {
    padding: 25px;
}

.user-card .card-block .user-image {
    position: relative;
    margin: 0 auto;
    display: inline-block;
    padding: 5px;
    width: 110px;
    height: 110px;
}

.user-card .card-block .user-image img {
    z-index: 20;
    position: absolute;
    top: 5px;
    left: 5px;
        width: 100px;
    height: 100px;
}

.img-radius {
    border-radius: 50%;
}

.f-w-600 {
    font-weight: 600;
}

.m-b-10 {
    margin-bottom: 10px;
}

.m-t-25 {
    margin-top: 25px;
}

.m-t-15 {
    margin-top: 15px;
}

.card .card-block p {
    line-height: 1.4;
}

.text-muted {
    color: #919aa3!important;
}

.user-card .card-block .activity-leval li.active {
    background-color: #2ed8b6;
}

.user-card .card-block .activity-leval li {
    display: inline-block;
    width: 15%;
    height: 4px;
    margin: 0 3px;
    background-color: #ccc;
}

.user-card .card-block .counter-block {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}

.m-t-10 {
    margin-top: 10px;
}

.p-20 {
    padding: 20px;
}

.user-card .card-block .user-social-link i {
    font-size: 30px;
}

.text-facebook {
    color: #3B5997;
}

.text-twitter {
    color: #42C0FB;
}

.text-dribbble {
    color: #EC4A89;
}

.user-card .card-block .user-image:before {
    bottom: 0;
    border-bottom-left-radius: 50px;
    border-bottom-right-radius: 50px;
}

.user-card .card-block .user-image:after, .user-card .card-block .user-image:before {
    content: "";
    width: 100%;
    height: 48%;
    border: 2px solid #4099ff;
    position: absolute;
    left: 0;
    z-index: 10;
}

.user-card .card-block .user-image:after {
    top: 0;
    border-top-left-radius: 50px;
    border-top-right-radius: 50px;
}

.user-card .card-block .user-image:after, .user-card .card-block .user-image:before {
    content: "";
    width: 100%;
    height: 48%;
    border: 2px solid #4099ff;
    position: absolute;
    left: 0;
    z-index: 10;
}
</style>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
	

	<div class="box-body">
        <div class="row col-md-12 col-sm-12 col-xs-12">

		<div class="col-3 mx-auto">
			<div class="card card-body card-buttons" style="text-align: center;">
				<div>
					<h4 style="color: #d2ae6d;">
						<b><?='₹ '.$followDataenquiry[0]->final_amount;?></b></h4>
					Total Fees
				</div>

			</div>
		</div>

			<?php 
				if(!empty($gettotalpaidEnquirypaymentInfo[0]->totalpaidAmount)){
					$totalpaidAmount =  $gettotalpaidEnquirypaymentInfo[0]->totalpaidAmount;
				}else{
					$totalpaidAmount = 0;  
				}  
			?>

			<div class="col-3 mx-auto">
				<div class="card card-body card-buttons payment_box"
					style="text-align: center;">
					<div>
						<h4 style="color: #d2ae6d;">
							<b><?='₹ '.$totalpaidAmount;?></b></h4>
						Total Fees Received
					</div>
				</div>
			</div>

			<div class="col-3 mx-auto">
				<div class="card card-body card-buttons payment_box"
					style="text-align: center;">
					<div>
						<h4 style="color: #d2ae6d;">
							<b><?='₹ '.$followDataenquiry[0]->final_amount -  $totalpaidAmount;?></b></h4>
						Pending Fees
					</div>
				</div>
			</div>
		</div>
	</div>



    <div class="col-lg-12 col-md-12" style="margin-top:35px">
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
                             <button id="join_link" style="width: 70%;" class="join_link" user-id="<?=$value['userid']?>" topic-id="<?=$value['topicid']?>" course-id="<?=$value['courseId']?>" meeting_id="<?=$value['meeting_id']?>"  meeting_link="<?=$value['link_url']?>" >JOIN</button>
                       <?php } else{ ?>
                             <button id="attend_manually" class="attend_manually" user-id="<?=$value['userid']?>" topic-id="<?=$value['topicid']?>" course-id="<?=$value['courseId']?>" meeting_id="<?=$value['meeting_id']?>">Click To Attend</button>
                       <?php }?>
					 <?php } ?> 
					 <button id="print_id_card" class="print_id_card" user-id="<?=$value['userid']?>" topic-id="<?=$value['topicid']?>" course-id="<?=$value['courseId']?>" meeting_id="<?=$value['meeting_id']?>">Print Id Card</button>

                    </td>
                </tr>
             <?php }  ?>   
            </tbody>
            </table>
    

			<div class="modal fade" id="idcarddata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					<div class="modal-header" style="background:#d2ae6d">
						<h5 class="modal-title" id="exampleModalLabel" style="color:black;">Print Student Id Card</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					  <div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="card user-card">
									<div class="card-header">
										<!-- <h5>Profile</h5> -->
									</div>
									<div class="card-block">
										<div class="user-image">
											<img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="img-radius" alt="User-Profile-Image">
										</div>
										<h6 class="f-w-600 m-t-25 m-b-10">Alessa Robert</h6>
										<p class="text-muted">Active | Male | Born 23.05.1992</p>
										<hr>
										<p class="text-muted m-t-15">Activity Level: 87%</p>
										<ul class="list-unstyled activity-leval">
											<li class="active"></li>
											<li class="active"></li>
											<li class="active"></li>
											<li></li>
											<li></li>
										</ul>
										<div class="bg-c-blue counter-block m-t-10 p-20">
											<div class="row">
												<div class="col-4">
													<i class="fa fa-comment"></i>
													<p>1256</p>
												</div>
												<div class="col-4">
													<i class="fa fa-user"></i>
													<p>8562</p>
												</div>
												<div class="col-4">
													<i class="fa fa-suitcase"></i>
													<p>189</p>
												</div>
											</div>
										</div>
										<p class="m-t-15 text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										<hr>
										<!-- <div class="row justify-content-center user-social-link">
											<div class="col-auto"><a href="#!"><i class="fa fa-facebook text-facebook"></i></a></div>
											<div class="col-auto"><a href="#!"><i class="fa fa-twitter text-twitter"></i></a></div>
											<div class="col-auto"><a href="#!"><i class="fa fa-dribbble text-dribbble"></i></a></div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
	                </div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary print_card" id="print_card">Print Card</button>
					</div>
					</div>
				</div>
			</div>

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
		<div id="chartContainer" style="height: 370px; width: 100%;">
		</div>
	</body>
</html>    
</div>


    <!-- END PAGE CONTENT-->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


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

$(".print_id_card").click(function(){

	var user_id = $(this).attr("user-id");
    var topic_id = $(this).attr("topic-id");
    var course_id = $(this).attr("course-id");
    var meeting_id = $(this).attr("meeting_id");
    var meeting_link = $(this).attr("meeting_link");


	               $.ajax({
						url : "<?php echo base_url();?>fetchallstudentdataforprintidcard",
						type: "POST",
                        data : 'user_id='+user_id+'&topic_id='+topic_id+'&course_id='+course_id+'&meeting_id='+meeting_id+'&meeting_link='+meeting_link,
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
								$("#idcarddata").modal("show");

								//  swal({
								// 	title: "Attendance Successfully Done",
								//     text: "",
								//  	icon: "success",
								//  	button: "Ok",
								//  	},function(){ 
								// 		$("#popup_modal_md").hide();
                                //         //window.location.href = meeting_link;
                                //         //window.open(meeting_link, '_blank');

								// 		window.location.href = "<?php echo base_url().'dashboard'?>";
								// });						
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							//$(".loader_ajax").hide();
						}
					});
				return false;

    
});

</script>