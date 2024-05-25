<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/event.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/colorbox.css" />


<style>
	/* body{
    margin-top:20px;
    background:#f3f3f3;
} */


.user-card .card-block .iictn_logo_img {
	position: relative;
    /* margin: 0 auto; */
    /* display: inline-block; */
    /* padding: 5px; */
    width: 110px;
    /* height: 110px; */
    margin-left: -51px;
    margin-top: -18px
}


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

.borderb {
    background: linear-gradient(rgba(250,250,250,250),rgba(250,250,250,250));
    box-shadow: 0 5px 15px #ccc;
    padding: 10px;
    margin-bottom: 6px;
}
</style>

<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
	<div class="box-body">
        <div class="row col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-4 mb-4">
            <!-- Billing card 1-->
            <div class="card h-100 border-start-lg border-start-primary">
                <div class="card-body">
				    <div class="h4"><i class="fa fa-money" aria-hidden="true"></i> Amount Total</div>
                    <div class="text-muted"><b><?='₹ '.$followDataenquiry[0]->final_amount;?></b></div>
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
        <div class="col-lg-4 mb-4">
            <!-- Billing card 2-->
            <div class="card h-100 border-start-lg border-start-secondary">
                <div class="card-body">
			    	<div class="h4"><i class="fa fa-cc" aria-hidden="true"></i>  Amount Paid By You</div>
                    <div class="text-muted"><b><?='₹ '.$totalpaidAmount;?></b></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <!-- Billing card 3-->
            <div class="card h-100 border-start-lg border-start-success">
                <div class="card-body">
				   <div class="h4"><i class="fa fa-inr" aria-hidden="true"></i>  Pending Amount By You</div>
                    <div class="text-muted"><b><?='₹ '.$followDataenquiry[0]->final_amount -  $totalpaidAmount;?></b></div>
                </div>
            </div>
        </div>
		</div>
	</div>


			<div class="col-lg-12 col-md-12" style="margin-top:35px">
				<h5><b> Add on Course Payment Details</b></h5>

                    <table id="" class="table table-bordered">
                        <tr style="background: #d3d5c3;">
                            <th>Course Name</th>
                            <th>Course Added DateTime</tthd>
                            <th>Course Amount</th>
                            <th>Discount</th>
                            <th>Final Amount</th>
                            <th>Total Paid Amount</th>
                            <th>Total Pending Amount</th>
                        </tr>
                        <?php foreach ($getadditionalcourseInfostudent as $getadditionalInfokey => $getadditionalInfokeyvalue) { ?>
                            <tr>
                                <td><?=$getadditionalInfokeyvalue['course_name'] ?></td>
                                <td><?=$getadditionalInfokeyvalue['addoncoursedatetime'] ?></td>
                                <td> ₹ <?=$getadditionalInfokeyvalue['course_total_fees'] ?></td>
                                <td> ₹ <?=$getadditionalInfokeyvalue['discount'] ?></td>
                                <?php 
                                    $total_amount_after_discount = $getadditionalInfokeyvalue['course_total_fees']-$getadditionalInfokeyvalue['discount'];
                                    // $total_paid = 0;
                                    $CI =& get_instance();
                                    $CI->load->model('enquiry_model');
                                    $result_of_total_paid = $CI->enquiry_model->gettotalpaidamountof_add_on_course(trim($getadditionalInfokeyvalue['addoncourse_id']),trim($getadditionalInfokeyvalue['enquiry_id']));
                                    $total_paid = $result_of_total_paid[0]->totalpaidamount;
                                    $total_pending_amount = $total_amount_after_discount - $total_paid;
                                ?>
                                <td> ₹ <?=$total_amount_after_discount;?></td>


                                <td> ₹ <?=$total_paid ?></td>
                                <td> ₹ <?=$total_pending_amount?></td>
                                <!-- <td>
                                    <a style='cursor: pointer;'  href='<?php echo base_url();?>viewaddoncoursepaymentdetails/<?=$getadditionalInfokeyvalue['addoncourse_id']?>' class='add_on_course_payment_details' data-id=""><img width='20' src="<?php echo ICONPATH; ?>/payment.png" alt='Add On Course Payment Details' title='Add On Course Payment Details'></a>
                                </td> -->
                            </tr>
                        <?php }  ?>
                    </table>
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

					<?php  if($value['iscancle']!=1){ ?>

					 <?php if($value['attendance_alreday_exits']!='1'){ ?>
						<?php if($value['link_url']){ ?>
							<button id="join_link" class="join_link" user-id="<?=$value['userid']?>" topic-id="<?=$value['topicid']?>" course-id="<?=$value['courseId']?>" meeting_id="<?=$value['meeting_id']?>"  meeting_link="<?=$value['link_url']?>" >JOIN</button>
						<?php } ?>
								<button id="attend_manually" class="attend_manually" user-id="<?=$value['userid']?>" topic-id="<?=$value['topicid']?>" course-id="<?=$value['courseId']?>" meeting_id="<?=$value['meeting_id']?>">Click To Attend</button>
							    <button id="print_id_card" class="print_id_card" user-id="<?=$value['userid']?>" topic-id="<?=$value['topicid']?>" course-id="<?=$value['courseId']?>" meeting_id="<?=$value['meeting_id']?>">Print Id Card</button>
                       <?php }else {?>
						<b>Attended</b>
                     <?php } }else{ ?>
						<b>Cancelled</b>
					 <?php } ?>

                    </td>
                </tr>
             <?php }  ?>   
            </tbody>
            </table>

			<div id="printThis">
				<div class="modal fade" id="idcarddata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false"  aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header headersection" style="background:#d2ae6d">
							<h5 class="modal-title" id="exampleModalLabel" style="color:black;">Print Student Id Card</h5>
							<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span> -->
							</button>
						</div>
						<div class="modal-body" id="printarea" style="margin-left:30px;margin-right: 30px;">
						<div class="container">
							<div class="row" style="border: 3px solid #d2ae6d;">
								<div class="col-md-12">
									<div class="card user-card">
										<div class="card-block">
										    <div class="iictn_logo_img"	>
											   <img src="<?php echo base_url('assets/img/logos/iictn_lms.png'); ?>" alt="" height="50">
 											</div>

											<div class="user-image">
												<img src="" id="student_profile_pic" name="student_profile_pic" class="img-radius" alt="User-Profile-Image">
											</div>

											<h5 class="f-w-600 m-t-25 m-b-10" id="student_name" style="color:black"></h5>

											<h6 class="f-w-600 m-t-25 m-b-10" id="student_mobile_number" style="color:black"></h6>
											
										</div>
									</div>
									       

											<p class="text-muted"><b style="color:black">Course Name : </b> <text id="course_name" name="course_name" style="color:black"></text></p>
												<hr>

											<p class="text-muted"><b style="color:black">Topic Name : </b> <text id="topic_name" name="topic_name" style="color:black"></text></p>
												<hr>

											<p class="text-muted"><b style="color:black">Class Time : </b> <text id="class_time" name="class_time" style="color:black"></text></p>
												<hr>

											<p class="text-muted"><b style="color:black">Class Time : </b> <text id="class_date" name="class_date" style="color:black"></text></p>
												<hr>

											<p class="text-muted"><b style="color:black">Website : </b> <text style="color:black">www.iictn.in</text></p>
					
								</div>
							</div>
						</div>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary print_id_card_close" >Close</button>
							<button type="button" class="btn btn-primary print_card_button" id="print_card_button">Print Card</button>
						</div>
						</div>
					</div>
				</div>
			</div>	

<?php
 
// $dataPoints = array(
// 	array("label"=> "WordPress", "y"=> 60.0),
// 	array("label"=> "Joomla", "y"=> 6.5),
// 	array("label"=> "Drupal", "y"=> 4.6),
// 	array("label"=> "Magento", "y"=> 2.4),
// 	array("label"=> "Blogger", "y"=> 1.9),
// 	array("label"=> "Shopify", "y"=> 1.8),
// 	array("label"=> "Bitrix", "y"=> 1.5),
// 	array("label"=> "Squarespace", "y"=> 1.5),
// 	array("label"=> "PrestaShop", "y"=> 1.3),
// 	array("label"=> "Wix", "y"=> 0.9),
// 	array("label"=> "OpenCart", "y"=> 0.8)
// );
	
?>

<div class="row col-md-12 col-sm-12 col-xs-12" style="margin-left: -31px;">
    <div class="col-md-6 col-sm-6 col-xs-12">
		<div id="chartContainer" style="height: 370px; width: 100%;">
		</div>
	</div>

	<div class="col-md-6 col-sm-6 col-xs-12">
	    <div class="row">
		  <div class="col-md-6 col-sm-6 col-xs-12">
              <h3 class=" textcenter mrgb0 borderr1" style="background: #55acee;padding: 15px;font-size: 1.5rem !important;"><span class="color3">Reply on your query</span></h3>
				<div style="border: 5px solid #55acee;padding: 12px;min-height: 305px;" class="borderr2">
						<marquee width="100%" direction="up"  height="210px">

							<?php foreach ($getaskaqueryRecord as $key => $value) { ?>
								<div class="testimonial pt-10 borderb">
								<a href='<?php echo ADMIN_PATH."viewqueryanswer/".$value['queryid']?>'>
									<div class="thumb pull-left mb-0 mr-0 pr-12">
									  <i class="fa fa-files-o" style="font-size: xxx-large"></i>
										</div>
										<div class="ml-30 fs17fwb">
										    <div class="ml-30 fs17fwb">
                                                <p><b>Course : </b><?=$value['course_name']?></p>
                                                <p><b>Topic  : </b><?=$value['topic_name']?></p>
                                                <p><b>Query  : </b><?=$value['query']?> - <?=$value['createdDtm']?> </small></p>
												<p><b>Ans    : </b><?=$value['query_answer']?></small></p>
                                            </div>
										</div>
									</a>
							</div>
						  <?php  } ?>
					    </marquee>
				</div>
		  </div>

		  <div class="col-md-6 col-sm-6 col-xs-12">
			<h3 class=" textcenter mrgb0 borderr1" style="background: #55acee;padding: 15px;font-size: 1.5rem !important;"><span class="color3">Exam notification</span></h3>
				<div style="border: 5px solid #55acee;padding: 12px;min-height: 305px;" class="borderr2">
						<!-- <marquee width="100%" direction="up"  height="210px"> -->
							<!-- <div class="testimonial pt-10 borderb">
								<a href="http://localhost/lms_2/studentadmissions">
									<div class="thumb pull-left mb-0 mr-0 pr-12">
									   <i class="fa fa-link color2"></i>
									</div>
									<div class="ml-30 fs17fwb">
									  <p>This is Test Notification</p>
									</div>
								</a>
					      </div> -->
					    <!-- </marquee> -->
				</div>
		  </div>
		</div>
	</div>
</div>
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
	 backgroundColor: "#fff685",
	 title: {
		 text: "Student Course Progress",
		 fontWeight: "normal",
	 },
	 axisY: {
		 suffix: "%",
		 scaleBreaks: {
			 autoCalculate: true
		 }
	 },
	 data: [{
		bevelEnabled: true,
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
					var join_link = 'YES';
                    $.ajax({
						url : "<?php echo base_url();?>attendClasses",
						type: "POST",
                        data : 'user_id='+user_id+'&topic_id='+topic_id+'&course_id='+course_id+'&meeting_id='+meeting_id+'&meeting_link='+meeting_link+'&join_link='+join_link,
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

					var print_card = 'YES';
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

								var profile_pic = fetchResponse.data.profile_pic;
								var student_profile_pic = "<?php echo base_url().'uploads/profile_pic/'?>"+profile_pic;
								var student_name = fetchResponse.data.name +' '+ fetchResponse.data.lastname
								var topic_name = fetchResponse.data.title;
								var course_name = fetchResponse.data.course_name;
								var classtime = fetchResponse.data.classtime;

								var date =  fetchResponse.data.date;

								var mobile =  fetchResponse.data.mobile;

								$('#student_profile_pic').attr("src", student_profile_pic);
								$("#student_name").append(student_name);
								$("#student_mobile_number").append(mobile);

							
								$("#topic_name").append(topic_name);
								$("#course_name").append(course_name);
								$("#class_time").append(classtime);
								$("#class_date").append(date);

								
								$.ajax({
									url : "<?php echo base_url();?>attendClasses",
									type: "POST",
									data : 'user_id='+user_id+'&topic_id='+topic_id+'&course_id='+course_id+'&meeting_id='+meeting_id+'&meeting_link='+meeting_link+'&print_card='+print_card,
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
													$("#idcarddata").modal("show");
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
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							//$(".loader_ajax").hide();
						}
					});
				return false;

    
});


document.getElementById("print_card_button").onclick = function () {
    printElement(document.getElementById("printarea"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}

// $(".print_card_button").click(function(){
// 	printData();
// });


// function printData()
// {
//    var divToPrint=document.getElementById("idcarddata");
//    newWin= window.open("");
//    newWin.document.write(divToPrint.outerHTML);
//    newWin.print();
//    newWin.close();
// }

$(".print_id_card_close").click(function(){
	location.reload();
});

</script>


<style>
@media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden;
	-webkit-print-color-adjust:exact !important;
    print-color-adjust:exact !important;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
  #printarea{
	margin-left: 0% !important;
	margin-right: -15% !important;
  }
}

</style>