<!-- Comman page javascript -->
<script type="text/javascript">

$(document).ready(function(){
	  $(".select2_demo_1").select2();
});
	
$(function() {
    $(".datepicker").datepicker({ 
		minDate: 0,
		todayHighlight: true,
        format: 'dd-mm-yyyy' ,
		startDate: new Date()
	});
});

$(document).on('click','.close',function(e){  
	history.go(0);
});

var myDrop = new drop({
    selector:  '#myMulti'
});

$(document).on('change','#country',function(e){  
	e.preventDefault();
	//$(".loader_ajax").show();
	var country_id = $('#country').val();
	$.ajax({
		url : "<?php echo ADMIN_PATH;?>getstates",
		type: "POST",
		data : {'country' : country_id},
		success: function(data, textStatus, jqXHR)
		{
			$(".loader_ajax").hide();
			if(data == "failure")
			{
				$('#state').html('<option value="">Select State</option>');
			}
			else
			{
				$('#state').html(data);
			}
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			$('#state').html('<option value="">Select State</option>');
			//$(".loader_ajax").hide();
		}
	});
	return false;
});

$(document).on('change','.state',function(e){
	e.preventDefault();
	// $(".loader_ajax").show();
	var state_id = $('#state').val();
	$.ajax({
		url : "<?php echo ADMIN_PATH;?>getcities",
		type: "POST",
		data : {'state_id' : state_id},
		success: function(data, textStatus, jqXHR)
		{
			$(".loader_ajax").hide();
			if(data == "failure") {
				$('#cityid').html('<option value="">Select City</option>');
			
			} else {
				$('#city').html(data);
			}
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			$('#city').html('<option value="">Select City</option>');
			//$(".loader_ajax").hide();
		}
	});
	return false;
});
</script>

<?php if($pageTitle=='Course Management'){?>
    <script type="text/javascript">
		$(document).ready(function() {
            var dt = $('#view_courselist').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "20%", "targets": 0 },
	                 { "width": "15%", "targets": 1 },
	                 { "width": "8%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Course Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>/fetchcourse",
                    type: "post",
	            },

	            // "columns": [
	                // { "data": "course_name" },
	                // { "data": "ttype" },
	                // { "data": "user_full_name" },
	                // { "data": "user_mobile_no" }
	                // { "data": "driver_full_name" },
	                // { "data": "driver_mobile_no" },
	                // { "data": "source_address" },                
	                // { "data": "dest_address" }, 
				    // { "data": "journey_status" },
					// { "data": "trip_flag" },  
					// { "data": "gross_bill" },              
	                // { "data": "dial4242_commision_charge" },
					// { "data": "amount_paid" },
	                // { "data": "action" },               
	            // ],

	        });
		});

		$(document).on('click','#save_course',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#course_form")[0]);

			$.ajax({
				url : "<?php echo base_url();?>createcourse",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Course Created!",
							//text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'courselisting'?>";
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

		$(document).on('click','.edit_course',function(e){
			var elemF = $(this);
			e.preventDefault();
			var course_id = elemF.attr('data-id');
			$.ajax({  
                url:"<?php echo base_url(); ?>course/get_signle_courseData",  
                method:"POST",  
                data:{courseId:course_id},
                dataType:"json",  
                success:function(data)  
                {  
                     $('#editCourse').modal('show');
                     $('#course_name1').val(data[0].course_name);  
                     $('#fees1').val(data[0].course_fees);  
                     $('#one_time_admission_fees1').val(data[0].course_onetime_adm_fees);  
                     $('#course_type1').val(data[0].course_type_id);  
                     $('#course_books1').val(data[0].course_books);  
                     $('#description1').val(data[0].course_desc);  
                     $('#certificate_cost1').val(data[0].course_cert_cost);  
                     $('#kit_cost1').val(data[0].course_kit_cost);  

					 if(data[0].course_books==1){
						$('.radio_yes').attr("checked", "checked");
					 }else{
						if(data[0].course_books==0){
							$('.radio_no').attr("checked", "checked");
						}
					 }

                     $('#remarks1').val(data[0].course_remark);
                     $('#course_id').val(course_id);
                }  
           })
        });

		$(document).on('click','#update_course',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#edit_course_form")[0]);
			var id = $("#course_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updatecourse/"+id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Course Updated!",
							text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'courselisting'?>";
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

		$(document).on('click','.delete_course',function(e){
			var elemF = $(this);
			e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>delete_course",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										// if(data.status=='success'){
											//swal("Deleted!", "", "success");
											//location.reload();
										//}
										const obj = JSON.parse(data);
											if(obj.status=='success'){
															
													swal({
														title: "Deleted!",
														text: "",
														icon: "success",
														button: "Ok",
														},function(){ 
															$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'courselisting'?>";
													});	
											}else if(obj.status=='linked'){
													swal({
															title: "Course Alreday In use!",
															text: "",
															icon: "success",
															button: "Ok",
															},function(){ 
																$("#popup_modal_sm").hide();
																window.location.href = "<?php echo base_url().'courselisting'?>";
													});	
											}else{

												swal({
														title: "Not Deleted!",
														text: "",
														icon: "success",
														button: "Ok",
														},function(){ 
															$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'courselisting'?>";
													});	
											}	

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										//$(".loader_ajax").hide();
									}
							    })
							}
							else {
					swal("Cancelled", " ", "error");
					}
				});
	    });
    </script>   
<?php } ?>


<?php if($pageTitle=='Enquiry Management' || $pageTitle=='Enquiry Edit'){?>
<script type="text/javascript">

$(document).on('change','#countryEnquiry',function(e){  
	e.preventDefault();
	//$(".loader_ajax").show();
	var country_id = $('#countryEnquiry').val();
	$.ajax({
		url : "<?php echo ADMIN_PATH;?>getstates",
		type: "POST",
		data : {'country' : country_id},
		success: function(data, textStatus, jqXHR)
		{
			$(".loader_ajax").hide();
			if(data == "failure")
			{
				$('#stateEnquiry').html('<option value="">Select State</option>');
			}
			else
			{
				$('#stateEnquiry').html(data);
			}
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			$('#stateEnquiry').html('<option value="">Select State</option>');
			//$(".loader_ajax").hide();
		}
	});
	return false;
});

$(document).on('change','#stateEnquiry',function(e){
	e.preventDefault();
	// $(".loader_ajax").show();
	var state_id = $('#stateEnquiry').val();
	$.ajax({
		url : "<?php echo ADMIN_PATH;?>getcities",
		type: "POST",
		data : {'state_id' : state_id},
		success: function(data, textStatus, jqXHR)
		{
			$(".loader_ajax").hide();
			if(data == "failure") {
				$('#cityEnquiry').html('<option value="">Select City</option>');
			
			} else {
				$('#cityEnquiry').html(data);
			}
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			$('#cityEnquiry').html('<option value="">Select City</option>');
			//$(".loader_ajax").hide();
		}
	});
	return false;
    });


    $(document).ready(function() {
            var dt = $('#view_enquirylist').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
	                 { "width": "20%", "targets": 2 },
	                 { "width": "10%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					 { "width": "10%", "targets": 6 },
					 { "width": "35%", "targets": 7 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Enquiry Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>/fetchenquiry",
                    type: "post",
	            },
	        });
	});

	$(document).on('click','#save_enquiry',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#add_enquiry_form")[0]);
			$.ajax({
				url : "<?php echo base_url();?>createenquiry",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Enquiry Created!",
							//text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'enquirylisting'?>";
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

	$(document).on('click','.edit_enquiry',function(e){
			var elemF = $(this);
			e.preventDefault();
			var enq_id = elemF.attr('data-id');
			$.ajax({  
                url:"<?php echo base_url(); ?>enquiry/get_signle_enquiry/"+enq_id,  
                method:"POST",  
                data:{enq_id:enq_id},
                dataType:"json",  
                success:function(data)  
                {  
                     $('#editEnquiry').modal('show');
                     $('#full_name1').val(data[0].enq_fullname);  
                     $('#mobile_no1').val(data[0].enq_mobile);  
                     $('#alternate_mobile1').val(data[0].enq_mobile1);  
                     $('#email1').val(data[0].enq_email);  
                     $('#alternamte_email1').val(data[0].enq_email1);  
                     $('#qualification1').val(data[0].enq_qualification);  
                     $('#purpose1').val(data[0].enq_purpose);  
                     $('#enq_date1').val(data[0].enq_date);  
                     $('#country1').val(data[0].enq_country);
                     $('#state1').val(data[0].enq_state);
                     $('#city1').val(data[0].enq_city);
                     $('#enquiry_type1').val(data[0].enq_source);
                     $('#remarks1').val(data[0].enq_remark);

					 var values=data[0].enq_course_id;
					
					 $.each(values.split(","), function(i,e){
							$(".c1 option[value='" + e + "']").prop("selected", true);
					 });
					 
                     //$("#dropdownState").append(appenddata1);
                     $('#enq_id').val(enq_id);
                }  
           })
    });

	$(document).on('click','#update_enquiry',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#update_enquiry_form")[0]);
			var id = $("#enq_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updateenquiry/"+id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Enquiry Updated!",
							text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'enquirylisting'?>";
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

	$(document).on('click','.delete_enquiry',function(e){
			var elemF = $(this);
			e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteEnquiry",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										// if(data.status=='success'){
											swal("Deleted!", "Enquiry has been deleted.", "success");
											location.reload();
										//}
									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										//$(".loader_ajax").hide();
									}
							    })
							}
							else {
					swal("Cancelled", "Enquiry deletion cancelled ", "error");
					}
				});
	});

	$(document).on('click','.add_links',function(e){
			var elemF = $(this);
			e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "You want to send link !",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, send it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>sendEnquiryLink",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										// if(data.status=='success'){
											swal("Send!", "Link Sent Successfully.", "success");
											// location.reload();
										//}
									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										//$(".loader_ajax").hide();
									}
							    })
							}
							else {
					swal("Cancelled", "Link cancelled ", "error");
					}
				});
	});

	$(document).on('click','.send_payment_link',function(e){
			var elemF = $(this);
			e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "You want to send Payment Link to User !",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, send it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
						$(".loader_ajax").show();

						$(".sweet-alert").css({"z-index":"-99"});

								$.ajax({
									url : "<?php echo base_url();?>sendPaymentLink",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										//if(data.status=='success'){
											$(".sweet-alert").css({"z-index":""});

                                            $(".loader_ajax").hide();
											swal("Send!", "Link Sent Successfully.", "success");
											//location.reload();
										//}
									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										$(".loader_ajax").hide();
									}
							    })
							}
							else {
					               swal("Cancelled", "Link cancelled ", "error");
					}
				});
	});

</script> 
<?php } ?>

<?php if($pageTitle=='Course Type'){?>
 <script type="text/javascript">
	    $(document).ready(function() {
				var dt = $('#view_coursetypelist').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "50%", "targets": 0 },
						{ "width": "5%", "targets": 1 },

					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Course Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>/fetchcoursetype",
						type: "post",
					},
				});
		});

		$(document).on('click','#save_course_type',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#course_type_form")[0]);
			$.ajax({
				url : "<?php echo base_url();?>createcoursetype",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Course Type Created!",
							//text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'coursetypelisting'?>";
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

		$(document).on('click','.edit_course_type',function(e){
			var elemF = $(this);
			e.preventDefault();
			var coursetypeId = elemF.attr('data-id');
			$.ajax({  
                url:"<?php echo base_url(); ?>course/get_signle_coursetypeData",  
                method:"POST",  
                data:{coursetypeId:coursetypeId},
                dataType:"json",  
                success:function(data)  
                {  
					  $('#editCourseType').modal('show');
				     // console.log(data.courseTypeInfo[0]);
                     // $('#editCourseType').modal('show');
                      $('#course_type_name_1').val(data.courseTypeInfo[0].ct_name);  
                      $('#coursetype_id').val(data.courseTypeInfo[0].ct_id);
                }  
           })
        });

		$(document).on('click','#update_course_type',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#edit_course_type_form")[0]);
			var id = $("#coursetype_id").val();
			$.ajax({
				url : "<?php echo base_url();?>updatcoursetype/"+id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Course Updated!",
							text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'coursetypelisting'?>";
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

		$(document).on('click','.delete_course_type',function(e){
				var elemF = $(this);
				e.preventDefault();

					swal({
						title: "Are you sure?",
						text: "",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletecoursetype",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											// if(data.status=='success'){
												// swal("Deleted!", "Course Type has been deleted.", "success");
												// location.reload();
											//}
											const obj = JSON.parse(data);
											if(obj.status=='success'){
												swal({
												title: "Deleted!",
												text: "",
												icon: "success",
												button: "Ok",
												},function(){ 
													$("#popup_modal_sm").hide();
													window.location.href = "<?php echo base_url().'coursetypelisting'?>";
											});	
											}else if(obj.status=='linked'){
												swal({
												title: "Course Already In Use",
												text: "",
												icon: "success",
												button: "Ok",
												},function(){ 
													$("#popup_modal_sm").hide();
													window.location.href = "<?php echo base_url().'coursetypelisting'?>";
											});	
											}else{

												swal({
												title: "Not Deleted",
												text: "",
												icon: "success",
												button: "Ok",
												},function(){ 
													$("#popup_modal_sm").hide();
													window.location.href = "<?php echo base_url().'coursetypelisting'?>";
											});	
											}
											

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											//$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "Course Type deletion cancelled ", "error");
						}
					});
		});
</script>
<?php } ?>

<?php if($pageTitle=='User List'){?>
	<script type="text/javascript">

		var loadFile = function(event) {
			var image = document.getElementById('output');
			image.src = URL.createObjectURL(event.target.files[0]);
		};

		var loadFile = function(event) {
			var image = document.getElementById('output1');
			image.src = URL.createObjectURL(event.target.files[0]);
		};
		
		$(document).ready(function() {
				var dt = $('#userList').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "20%", "targets": 0 },
						{ "width": "30%", "targets": 1 },
						{ "width": "20%", "targets": 2 },
						{ "width": "20%", "targets": 3 },
						{ "width": "10%", "targets": 4 },

					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No User Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchUsers",
						type: "post",
					},
				});
		});

		$(document).on('click','#save_user',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#user_form")[0]);
			$.ajax({
				url : "<?php echo base_url();?>createUser",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "User Created!",
							//text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'userListing'?>";
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

		$(document).on('click','.edit_user',function(e){
			var elemF = $(this);
			e.preventDefault();
			var userId = elemF.attr('data-id');
			$.ajax({  
                url:"<?php echo base_url(); ?>admin/get_signle_user_for_edit/"+userId,  
                method:"POST",  
                data:{userId:userId},
                dataType:"json",  
                success:function(data)  
                {  
                     $('#editUser').modal('show');
					 
                     $('#name1').val(data[0].name);  
                     $('#mobile1').val(data[0].mobile);  
                     $('#email1').val(data[0].email);
                     $('#role1').val(data[0].roleId);
					 $('#username1').val(data[0].username);
                     $('#password1').val(atob(data[0].password));
                     $('#confirm_password1').val(atob(data[0].password));

					 $('#output1').attr("src","<?php echo IMGPATH;?>/" + data[0].profile_pic);
					 
                     $('#userId').val(userId);
                }  
           })
        });

		$(document).on('click','#update_user',function(e){
				e.preventDefault();
				//$(".loader_ajax").show();
				var formData = new FormData($("#update_user_form")[0]);
				var id = $("#userId").val();
				$.ajax({
					url : "<?php echo base_url();?>updateUser/"+id,
					type: "POST",
					data : formData,
					cache: false,
					contentType: false,
					processData: false,
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
								title: "User Updated!",
								text: "",
								icon: "success",
								button: "Ok",
								},function(){ 
									$("#popup_modal_md").hide();
									window.location.href = "<?php echo base_url().'userListing'?>";
							});						
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
			
					}
				});
				return false;
		});

		$(document).on('click','.delete_user',function(e){
			var elemF = $(this);
			e.preventDefault();

			swal({
				title: "Are you sure?",
				text: "",
				type: "warning",
				showCancelButton: true,
				closeOnClickOutside: false,
				confirmButtonClass: "btn-sm btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plz!",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function(isConfirm) {
				if (isConfirm) {
					$.ajax({
					url : "<?php echo base_url();?>deleteUser",
					type: "POST",
					data : 'id='+elemF.attr('data-id'),
					success: function(data, textStatus, jqXHR)
					{
						// if(data.status=='success'){
												//swal("Deleted!", "", "success");
												//location.reload();
											//}
						swal({
							title: "Deleted!",
							text: "",
							icon: "success",
							button: "Ok",
						},function(){ 
							$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'userListing'?>";
							});		
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
										//$(".loader_ajax").hide();
						}
					})
				}
				else {
					swal("Cancelled", " ", "error");
				}
			});
		});
    </script>
	<?php } ?>

<?php if($pageTitle=='Staff List'){?>
	<script type="text/javascript">

		var loadFile = function(event) {
			var image = document.getElementById('output');
			image.src = URL.createObjectURL(event.target.files[0]);
		};

		var loadFile = function(event) {
			var image = document.getElementById('output1');
			image.src = URL.createObjectURL(event.target.files[0]);
		};

		$(document).ready(function() {
				var dt = $('#staffList').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "20%", "targets": 0 },
						{ "width": "30%", "targets": 1 },
						{ "width": "20%", "targets": 2 },
						{ "width": "20%", "targets": 3 },
						{ "width": "10%", "targets": 4 },

					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Staff Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchStaff",
						type: "post",
					},
				});
		});
		
		$(document).on('click','#save_staff',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#staff_form")[0]);
			$.ajax({
				url : "<?php echo base_url();?>createUser",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Staff Created!",
							//text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'staffListing'?>";
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

		$(document).on('click','#update_staff',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#update_staff_form")[0]);
			var id = $("#userId").val();
			$.ajax({
				url : "<?php echo base_url();?>updateUser/"+id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Staff Updated!",
							text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'staffListing'?>";
						});						
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
		
			    }
			});
			return false;
	    });

		$(document).on('click','.delete_staff',function(e){
				var elemF = $(this);
				e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "",
					type: "warning",
					showCancelButton: true,
					closeOnClickOutside: false,
					confirmButtonClass: "btn-sm btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel plz!",
					closeOnConfirm: false,
					closeOnCancel: false
				}, function(isConfirm) {
					if (isConfirm) {
						$.ajax({
						url : "<?php echo base_url();?>deleteUser",
						type: "POST",
						data : 'id='+elemF.attr('data-id'),
						success: function(data, textStatus, jqXHR)
						{
							// if(data.status=='success'){
													//swal("Deleted!", "", "success");
													//location.reload();
												//}
							swal({
								title: "Deleted!",
								text: "Staff has been deleted.",
								icon: "success",
								button: "Ok",
							},function(){ 
								$("#popup_modal_md").hide();
									window.location.href = "<?php echo base_url().'staffListing'?>";
								});		
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
											//$(".loader_ajax").hide();
							}
						})
					}
					else {
						swal("Cancelled", " ", "error");
					}
				});
		});
	</script>
<?php } ?>



<?php
if($pageTitle=='Role Listing' || $pageTitle=='Add New Role' || $pageTitle=='Edit Role'){?>
	<script type="text/javascript">

	$('#clientymodule').click(function() {
        if ($(this).is(':checked')) {
		    $('#clientpage').prop('checked', true);
			$('#clientadd').prop('checked', true);
			$('#clientedit').prop('checked', true);
			$('#clientdelete').prop('checked', true);
		}else{
			$('#clientpage').prop('checked', false);
			$('#clientadd').prop('checked', false);
			$('#clientedit').prop('checked', false);
			$('#clientdelete').prop('checked', false);
		}
	});
	
	$('#clientpage,#clientadd,#clientedit,#clientdelete').click(function() {
	    if ($('#clientpage').is(':checked') && $('#clientadd').is(':checked') && $('#clientedit').is(':checked') && $('#clientdelete').is(':checked')) {
			$('#clientymodule').prop('checked', true);
		}
	});

    $(document).ready(function() {
            var dt = $('#view_roleList').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "20%", "targets": 0 },
	                 { "width": "15%", "targets": 1 },
	                 { "width": "8%", "targets": 2 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Course Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>/fetchrolelisting",
                    type: "post",
	            },

	            // "columns": [
	                // { "data": "course_name" },
	                // { "data": "ttype" },
	                // { "data": "user_full_name" },
	                // { "data": "user_mobile_no" }
	                // { "data": "driver_full_name" },
	                // { "data": "driver_mobile_no" },
	                // { "data": "source_address" },                
	                // { "data": "dest_address" }, 
				    // { "data": "journey_status" },
					// { "data": "trip_flag" },  
					// { "data": "gross_bill" },              
	                // { "data": "dial4242_commision_charge" },
					// { "data": "amount_paid" },
	                // { "data": "action" },               
	            // ],

	        });
	});

	$(document).on('click','#save_role',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#role_form")[0]);

			$.ajax({
				url : "<?php echo base_url();?>createRole",
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Role Created!",
							//text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'roleListing'?>";
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

	$(document).on('click','#editRole',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#role_form")[0]);
			var id = $("#roleId").val();
			$.ajax({
				url : "<?php echo base_url();?>editRolerecord/"+id,
				type: "POST",
				data : formData,
				cache: false,
		        contentType: false,
		        processData: false,
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
							title: "Role Updated!",
							text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'roleListing'?>";
						});						
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
		
			    }
			});
			return false;
	});

	$(document).on('click','.deleteRole',function(e){

				var elemF = $(this);
				e.preventDefault();

					swal({
						title: "Are you sure?",
						text: "",
						type: "warning",
						showCancelButton: true,
						closeOnClickOutside: false,
						confirmButtonClass: "btn-sm btn-danger",
						confirmButtonText: "Yes, delete it!",
						cancelButtonText: "No, cancel plz!",
						closeOnConfirm: false,
						closeOnCancel: false
					}, function(isConfirm) {
						if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deleteRole",
										type: "POST",
										data : 'id='+elemF.attr('data-id'),
										success: function(data, textStatus, jqXHR)
										{
											// if(data.status=='success'){
												// swal("Deleted!", "Course Type has been deleted.", "success");
												// location.reload();
											//}
											const obj = JSON.parse(data);
											if(obj.status=='success'){
												swal({
													title: "Deleted!",
													text: "",
													icon: "success",
													button: "Ok",
													},function(){ 
														$("#popup_modal_sm").hide();
														window.location.href = "<?php echo base_url().'roleListing'?>";
												});	
										  }else if(obj.status=='linked') {
												swal({
													title: "Role Already In Use",
													text: "",
													icon: "error",
													button: "Ok",
													},function(){ 
														$("#popup_modal_sm").hide();
														window.location.href = "<?php echo base_url().'roleListing'?>";
												});	
										  }else{
											    swal({
													title: "Not Deleted",
													text: "",
													icon: "error",
													button: "Ok",
													},function(){ 
														$("#popup_modal_sm").hide();
														window.location.href = "<?php echo base_url().'roleListing'?>";
												});	
										  }

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											//$(".loader_ajax").hide();
										}
									})
								}
								else {
						swal("Cancelled", "Course Type deletion cancelled ", "error");
						}
					});
	});

   </script>
<?php } ?>

<?php if($pageTitle=='Admission Listing'){?>
<script type="text/javascript">

$(document).ready(function() {
				var dt = $('#admissionList').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "12%", "targets": 1 },
						{ "width": "20%", "targets": 2 },
						{ "width": "20%", "targets": 3 },
						{ "width": "20%", "targets": 4 },
						{ "width": "10%", "targets": 5 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No Admissions Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchadmissions",
						type: "post",
					},
				});
		});
	
</script>
<?php } ?>




