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

		$(document).on('click','#close',function(e){  
			history.go(0);
			location.reload();

			//alert('close');
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
	                 { "width": "15%", "targets": 0 },
	                 { "width": "8%", "targets": 1 },
	                 { "width": "8%", "targets": 2 },
	                 { "width": "8%", "targets": 3 },
					 { "width": "8%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
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
						// swal({
						// 	title: "Course Created!",
						// 	//text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
						// 		$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'courselisting'?>";
						//});						
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

					//alert(data[0].course_books);

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
						$('.radio_yes1').attr("checked", "checked");
					 }

					 if(data[0].course_books==0){
						$('.radio_no1').attr("checked", "checked");	
					 }
					 
					 if(data[0].course_mode_online==1){
						$(".course_mode_online1").attr("checked", "true");
					 }else{
						//$(".course_mode_online1").attr("checked", "flase");
					 }

					 if(data[0].course_mode_offline==1){
						$(".course_mode_offline1").attr("checked", "true");
					 }else{
						//$(".course_mode_offline1").attr("checked", "flase");
					 }


					 $('#cgst1').val(data[0].course_cgst_tax_value);  
					 $('#cgst_tax1').val(data[0].course_cgst); 
					 $('#sgst1').val(data[0].course_sgst_tax_value);  
					 $('#sgst_tax1').val(data[0].course_sgst);  
					 $('#total_course_fees1').val( Math.round(data[0].course_total_fees));  
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
						// swal({
						// 	title: "Course Updated!",
						// 	text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
						// 		$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'courselisting'?>";
						//});						
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

				// swal({
				// 	title: "Are you sure?",
				// 	text: "",
				// 	type: "warning",
				// 	showCancelButton: true,
				// 	closeOnClickOutside: false,
				// 	confirmButtonClass: "btn-sm btn-danger",
				// 	confirmButtonText: "Yes, delete it!",
				// 	cancelButtonText: "No, cancel plz!",
				// 	closeOnConfirm: false,
				// 	closeOnCancel: false
				// }, function(isConfirm) {
				// 	if (isConfirm) {
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
															
													// swal({
													// 	title: "Deleted!",
													// 	text: "",
													// 	icon: "success",
													// 	button: "Ok",
													// 	},function(){ 
													// 		$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'courselisting'?>";
													//});	
											}else if(obj.status=='linked'){
													// swal({
													// 		title: "Course Alreday In use!",
													// 		text: "",
													// 		icon: "success",
													// 		button: "Ok",
													// 		},function(){ 
													// 			$("#popup_modal_sm").hide();
																window.location.href = "<?php echo base_url().'courselisting'?>";
													//});	
											}else{

												// swal({
												// 		title: "Not Deleted!",
												// 		text: "",
												// 		icon: "success",
												// 		button: "Ok",
												// 		},function(){ 
												// 			$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'courselisting'?>";
												//});	
											}	

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										//$(".loader_ajax").hide();
									}
							    })
				// 			}
				// 			else {
				// 	swal("Cancelled", " ", "error");
				// 	}
				// });
	    });

		$(document).on('blur', '#fees,#certificate_cost,#kit_cost,#one_time_admission_fees', function(){

			if($("#fees").val()){
				var fees = $("#fees").val();
			}else{
				var fees = 0;
			}

			if($("#certificate_cost").val()){
				var certificate_cost = $("#certificate_cost").val();
			}else{
				var certificate_cost = 0;
			}

			if($("#kit_cost").val()){
				var kit_cost = $("#kit_cost").val();
			}else{
				var kit_cost = 0;
			}

			if($("#one_time_admission_fees").val()){
				var one_time_admission_fees = $("#one_time_admission_fees").val();
			}else{
				var one_time_admission_fees = 0;
			}

			if($("#cgst_tax").val()){
				var cgst_tax = $("#cgst_tax").val();
			}else{
				var cgst_tax = 0;
			}

			if($("#sgst_tax").val()){
				var sgst_tax = $("#sgst_tax").val();
			}else{
				var sgst_tax = 0;
			}
			var total_fees_befor_tax = parseFloat(fees) + parseFloat(certificate_cost) + parseFloat(kit_cost) + parseFloat(one_time_admission_fees);
            var cgst_value = total_fees_befor_tax *  cgst_tax / 100 ;
			$("#cgst").val(cgst_value);
			var sgst_value = total_fees_befor_tax *  sgst_tax / 100 ;
			$("#sgst").val(sgst_value);
			var total_fees = total_fees_befor_tax + cgst_value +sgst_value;
            $("#total_course_fees").val( Math.round(total_fees));

		});

		$(document).on('blur', '#fees1,#certificate_cost1,#kit_cost1,#one_time_admission_fees1', function(){

			if($("#fees1").val()){
				var fees = $("#fees1").val();
			}else{
				var fees = 0;
			}

			if($("#certificate_cost1").val()){
				var certificate_cost = $("#certificate_cost1").val();
			}else{
				var certificate_cost = 0;
			}

			if($("#kit_cost1").val()){
				var kit_cost = $("#kit_cost1").val();
			}else{
				var kit_cost = 0;
			}

			if($("#one_time_admission_fees1").val()){
				var one_time_admission_fees = $("#one_time_admission_fees1").val();
			}else{
				var one_time_admission_fees = 0;
			}

			if($("#cgst_tax1edit").val()){
				var cgst_tax1edit = $("#cgst_tax1edit").val();
			}else{
				var cgst_tax1edit = 0;
			}

	
			if($("#sgst_tax1edit").val()){
				var sgst_tax1edit = $("#sgst_tax1edit").val();
			}else{
				var sgst_tax1edit = 0;
			}

			var total_fees_befor_tax = parseFloat(fees) + parseFloat(certificate_cost) + parseFloat(kit_cost) + parseFloat(one_time_admission_fees);

            var cgst_value = total_fees_befor_tax *  cgst_tax1edit / 100 ;

	
			$("#cgst1").val(cgst_value);
			var sgst_value = total_fees_befor_tax *  sgst_tax1edit / 100 ;
			$("#sgst1").val(sgst_value);
			var total_fees = total_fees_befor_tax + cgst_value +sgst_value;
            $("#total_course_fees1").val(Math.round(total_fees));

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
	                 { "width": "8%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
	                 { "width": "15%", "targets": 2 },
	                 { "width": "8%", "targets": 3 },
					 { "width": "15%", "targets": 4 },
					 { "width": "10%", "targets": 5 },
					//  { "width": "10%", "targets": 6 },
					 { "width": "18%", "targets": 6 }
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
                    url :"<?php echo base_url();?>fetchenquiry",
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
						// swal({
						// 	title: "Enquiry Created!",
						// 	//text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'enquirylisting'?>";
						//});						
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
						// swal({
						// 	title: "Enquiry Updated!",
						// 	text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'enquirylisting'?>";
						//});						
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

				// swal({
				// 	title: "Are you sure?",
				// 	text: "",
				// 	type: "warning",
				// 	showCancelButton: true,
				// 	closeOnClickOutside: false,
				// 	confirmButtonClass: "btn-sm btn-danger",
				// 	confirmButtonText: "Yes, delete it!",
				// 	cancelButtonText: "No, cancel plz!",
				// 	closeOnConfirm: false,
				// 	closeOnCancel: false
				// }, function(isConfirm) {
				// 	if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteEnquiry",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										// if(data.status=='success'){
											//swal("Deleted!", "Enquiry has been deleted.", "success");
											location.reload();
										//}
									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										//$(".loader_ajax").hide();
									}
							    })
				// 			}
				// 			else {
				// 	swal("Cancelled", "Enquiry deletion cancelled ", "error");
				// 	}
				// });
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

	// $(document).on('click','.send_payment_link',function(e){
	// 		var elemF = $(this);
	// 		e.preventDefault();

	// 			swal({
	// 				title: "Are you sure?",
	// 				text: "You want to send Payment Link to User !",
	// 				type: "warning",
	// 				showCancelButton: true,
	// 				closeOnClickOutside: false,
	// 				confirmButtonClass: "btn-sm btn-danger",
	// 				confirmButtonText: "Yes, send it!",
	// 				cancelButtonText: "No, cancel plz!",
	// 				closeOnConfirm: false,
	// 				closeOnCancel: false
	// 			}, function(isConfirm) {
	// 				if (isConfirm) {
	// 					$(".loader_ajax").show();

	// 					$(".sweet-alert").css({"z-index":"-99"});

	// 							$.ajax({
	// 								url : "<?php echo base_url();?>sendPaymentLink",
	// 								type: "POST",
	// 								data : 'id='+elemF.attr('data-id'),
	// 								success: function(data, textStatus, jqXHR)
	// 								{
	// 									//if(data.status=='success'){
	// 										$(".sweet-alert").css({"z-index":""});

    //                                         $(".loader_ajax").hide();
	// 										swal("Send!", "Link Sent Successfully.", "success");
	// 										//location.reload();
	// 									//}
	// 								},
	// 								error: function (jqXHR, textStatus, errorThrown)
	// 								{
	// 									$(".loader_ajax").hide();
	// 								}
	// 						    })
	// 						}
	// 						else {
	// 				               swal("Cancelled", "Link cancelled ", "error");
	// 				}
	// 			});
	// });

	$(document).on('click','.send_brochure_link',function(e){
			var elemF = $(this);
			e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "You want to Brochure link to User !",
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
									url : "<?php echo base_url();?>sendBrochureLink",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										//if(data.status=='success'){
											$(".sweet-alert").css({"z-index":""});

                                            $(".loader_ajax").hide();
											swal("Send!", "Brochure Sent Successfully.", "success");
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
					               swal("Cancelled", "Brochure cancelled ", "error");
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
						// swal({
						// 	title: "Course Type Created!",
						// 	//text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
						// 		$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'coursetypelisting'?>";
						//});						
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
						// swal({
						// 	title: "Course Updated!",
						// 	text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'coursetypelisting'?>";
						//});						
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

					// swal({
					// 	title: "Are you sure?",
					// 	text: "",
					// 	type: "warning",
					// 	showCancelButton: true,
					// 	closeOnClickOutside: false,
					// 	confirmButtonClass: "btn-sm btn-danger",
					// 	confirmButtonText: "Yes, delete it!",
					// 	cancelButtonText: "No, cancel plz!",
					// 	closeOnConfirm: false,
					// 	closeOnCancel: false
					// }, function(isConfirm) {
						//if (isConfirm) {
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
											// if(obj.status=='success'){
											// 	swal({
											// 	title: "Deleted!",
											// 	text: "",
											// 	icon: "success",
											// 	button: "Ok",
											// 	},function(){ 
											// 		$("#popup_modal_sm").hide();
											// 		window.location.href = "<?php echo base_url().'coursetypelisting'?>";
											// });	
											// }else if(obj.status=='linked'){
											// 	swal({
											// 	title: "Course Already In Use",
											// 	text: "",
											// 	icon: "success",
											// 	button: "Ok",
											// 	},function(){ 
											// 		$("#popup_modal_sm").hide();
											// 		window.location.href = "<?php echo base_url().'coursetypelisting'?>";
											// });	
											// }else{

											// 	swal({
											// 	title: "Not Deleted",
											// 	text: "",
											// 	icon: "success",
											// 	button: "Ok",
											// 	},function(){ 
											// 		$("#popup_modal_sm").hide();
													window.location.href = "<?php echo base_url().'coursetypelisting'?>";
											// });	
											// }
											

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											//$(".loader_ajax").hide();
										}
									})
								//}
								//else {
						//swal("Cancelled", "Enquiry deletion cancelled ", "error");
						//}
					//});
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
						{ "width": "20%", "targets": 1 },
						{ "width": "15%", "targets": 2 },
						{ "width": "20%", "targets": 3 },
						{ "width": "15%", "targets": 4 },
						{ "width": "15%", "targets": 5 },

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
						// swal({
						// 	title: "User Created!",
						// 	//text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'userListing'?>";
						//});						
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

					 if(data[0].profile_pic){
						const imgpath = data[0].profile_pic;
					    $('#output1').attr("src","<?php echo IMGPATH;?>/" + data[0].profile_pic);
						$('#existing_img').val(imgpath);
					 }else{
						const imgpathoptional = "<?php echo base_url(); ?>assets/img/admin-avatar.png";
					    $('#output1').attr("src","<?php echo base_url(); ?>assets/img/admin-avatar.png");
						$('#existing_img').val('admin-avatar.png');
					 }
					 
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
							// swal({
							// 	title: "User Updated!",
							// 	text: "",
							// 	icon: "success",
							// 	button: "Ok",
							// 	},function(){ 
									$("#popup_modal_md").hide();
									window.location.href = "<?php echo base_url().'userListing'?>";
							//});						
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

			// swal({
			// 	title: "Are you sure?",
			// 	text: "",
			// 	type: "warning",
			// 	showCancelButton: true,
			// 	closeOnClickOutside: false,
			// 	confirmButtonClass: "btn-sm btn-danger",
			// 	confirmButtonText: "Yes, delete it!",
			// 	cancelButtonText: "No, cancel plz!",
			// 	closeOnConfirm: false,
			// 	closeOnCancel: false
			// }, function(isConfirm) {
			// 	if (isConfirm) {
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
						// swal({
						// 	title: "Deleted!",
						// 	text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// },function(){ 
							$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'userListing'?>";
							//});		
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
										//$(".loader_ajax").hide();
						}
					})
				// }
				// else {
				// 	swal("Cancelled", " ", "error");
				// }
			//});
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

		$(document).on('click','.edit_staff',function(e){
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
						swal("Cancelled", "Role deletion cancelled ", "error");
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

	$(document).on('click','.delete_admission',function(e){
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
									url : "<?php echo base_url();?>deleteAdmission",
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
															window.location.href = "<?php echo base_url().'admissionListing'?>";
													});	
											}else if(obj.status=='linked'){
													swal({
															title: "Admission Alreday In use!",
															text: "",
															icon: "success",
															button: "Ok",
															},function(){ 
																$("#popup_modal_sm").hide();
																window.location.href = "<?php echo base_url().'admissionListing'?>";
													});	
											}else{

												swal({
														title: "Not Deleted!",
														text: "",
														icon: "success",
														button: "Ok",
														},function(){ 
															$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'admissionListing'?>";
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

<?php if($pageTitle=='Enquiry Follow Up'){?>
	<script type="text/javascript">



	</script>
<?php } ?>

<?php  if($pageTitle=='SMTP Configuration'){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
					var dt = $('#smtpsettingList').DataTable({
						"columnDefs": [ 
							{ className: "details-control", "targets": [ 0 ] },
							{ "width": "15%", "targets": 0 },
							{ "width": "8%", "targets": 1 },
							{ "width": "20%", "targets": 2 },
							{ "width": "20%", "targets": 3 },
							{ "width": "20%", "targets": 4 },
							{ "width": "10%", "targets": 5 },

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
							url :"<?php echo base_url();?>fetchSmtpsetting",
							type: "post",
						},
					});
		});

		$(document).on('click','#save_smtp_setting',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#email_smtp_form")[0]);
			$.ajax({
				url : "<?php echo base_url();?>createemailsmtp",
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
							title: "SMTP Configuration Created!",
							//text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'emailsmtpListing'?>";
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

		$(document).on('click','.edit_smtp',function(e){
			var elemF = $(this);
			e.preventDefault();
			var smtpId = elemF.attr('data-id');
			$.ajax({  
                url:"<?php echo base_url(); ?>emailSetting/get_single_emailSmtp/"+smtpId,  
                method:"POST",  
                data:{smtpId:smtpId},
                dataType:"json",  
                success:function(data)  
                {  
                     $('#editEmailSMTP').modal('show');
                     $('#smtp_host1').val(data[0].smtp_host);  
					 $('#smtp_port1').val(data[0].smtp_port);
					 $('#protocol1').val(data[0].smtp_protocol);
					 $('#smtp_username1').val(data[0].smtp_username);
					 $('#smtp_password1').val(data[0].smtp_password);
					 $('#from_name1').val(data[0].from_name);
					 $('#email_name1').val(data[0].email_name);
					 $('#cc_email1').val(data[0].cc_email);
					 $('#bcc_email1').val(data[0].bcc_email);
                     $('#smtpId').val(smtpId);
                }  
           })
        });

		$(document).on('click','#update_smtp_setting',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#edit_email_smtp_form")[0]);
			var id = $("#userId").val();
			$.ajax({
				url : "<?php echo base_url();?>updateSMTP/"+id,
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
							title: "SMTP Configuaration Updated!",
							text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'emailsmtpListing'?>";
						});						
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
		
			    }
			});
			return false;
	    });
		
		$(document).on('click','.delete_smtp',function(e){

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
										url : "<?php echo base_url();?>deletesmtp",
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
														window.location.href = "<?php echo base_url().'emailsmtpListing'?>";
												});	
										  }else if(obj.status=='linked') {
												swal({
													title: "Role Already In Use",
													text: "",
													icon: "error",
													button: "Ok",
													},function(){ 
														$("#popup_modal_sm").hide();
														window.location.href = "<?php echo base_url().'emailsmtpListing'?>";
												});	
										  }else{
											    swal({
													title: "Not Deleted",
													text: "",
													icon: "error",
													button: "Ok",
													},function(){ 
														$("#popup_modal_sm").hide();
														window.location.href = "<?php echo base_url().'emailsmtpListing'?>";
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
						swal("Cancelled", "SMTP Configuration deletion cancelled ", "error");
						}
					});
	    });

    </script>
<?php } ?>

<?php if($pageTitle=='Add Course Topics' || $pageTitle=='Topics Delete' || $pageTitle=='Edit Course Topics'){ ?>
	<script type="text/javascript">
		var course_id =$('#course_id_1_post').val();
        $(document).ready(function() {	
					var dt = $('#view_coursetopicsattAchmentList').DataTable({
						"columnDefs": [ 
							{ className: "details-control", "targets": [ 0 ] },
							{ "width": "85%", "targets": 0 },
							{ "width": "20%", "targets": 1 },
							// { "width": "5%", "targets": 2 }

						],
						responsive: true,
						"oLanguage": {
							"sEmptyTable": "<i>No Topics / Chapters Found.</i>",
						}, 
						"bSort" : false,
						"bFilter":true,
						"bLengthChange": true,
						"iDisplayLength": 10,   
						"bProcessing": true,
						"serverSide": true,
						"ajax":{
							url :"<?php echo base_url();?>fetchCourseAttchemant/"+course_id,
							type: "post",
						},
					});
		});

		$(document).on('click','#save_course_topic',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#addCourseAttchment_form")[0]);

			$.ajax({
				url : "<?php echo base_url();?>savecoursetopicAttahcment",
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
						// swal({
						// 	title: "Topic Successfully Added!",
						// 	//text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
						// 		$("#modal-md").hide();
						// 		window.location.href = "<?php echo base_url().'addchapters/'?>"+course_id;
						// });		
						$("#modal-md").hide();
						window.location.href = "<?php echo base_url().'addchapters/'?>"+course_id;				
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   		//$(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.edit_course_topic',function(e){
			var elemF = $(this);
			e.preventDefault();
			var topic_id = elemF.attr('data-id');
			$.ajax({  
                url:"<?php echo base_url(); ?>course/get_signle_course_topic",  
                method:"POST",  
                data:{topic_id:topic_id,course_id:course_id},
                dataType:"json",  
                success:function(data)  
                {  
                     $('#editCourseAttchment').modal('show');
                     $('#topic_name_1').val(data[0].topic_name);  
                     $('#remark_1').val(data[0].remark);  
                     $('#course_id_1_post').val(data[0].course_id);
					 $('#topic_id').val(data[0].id);

                }  
           })
        });

		$(document).on('click','#update_course_topic',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#editCourseAttchment_form")[0]);
			//var id = $("#userId").val();
			$.ajax({
				url : "<?php echo base_url();?>updatecourseTopics",
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
						// swal({
						// 	title: "Topic Updated!",
						// 	text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'addchapters/'?>"+course_id;
						//});						
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
		
			    }
			});
			return false;
	    });

		$(document).on('click','.delete_course_topic',function(e){

			var elemF = $(this);
			e.preventDefault();

				// swal({
				// 	title: "Are you sure?",
				// 	text: "",
				// 	type: "warning",
				// 	showCancelButton: true,
				// 	closeOnClickOutside: false,
				// 	confirmButtonClass: "btn-sm btn-danger",
				// 	confirmButtonText: "Yes, delete it!",
				// 	cancelButtonText: "No, cancel plz!",
				// 	closeOnConfirm: false,
				// 	closeOnCancel: false
				// }, function(isConfirm) {
				// 	if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteCourseTopics",
									type: "POST",
									data : 'id='+elemF.attr('data-id'),
									success: function(data, textStatus, jqXHR)
									{
										const obj = JSON.parse(data);
										if(obj.status=='success'){
											//swal("Deleted!", "Course Type has been deleted.", "success");
											//location.reload();
											window.location.href = "<?php echo base_url().'addchapters/'?>"+course_id;

										}
									// 	const obj = JSON.parse(data);
									// 	if(obj.status=='success'){
									// 		swal({
									// 			title: "Deleted!",
									// 			text: "",
									// 			icon: "success",
									// 			button: "Ok",
									// 			},function(){ 
									// 				$("#popup_modal_sm").hide();
									// 				window.location.href = "<?php echo base_url().'addchapters/'?>"+course_id;
									// 		});	
									// }else if(obj.status=='linked') {
									// 		swal({
									// 			title: "Topics Already In Use",
									// 			text: "",
									// 			icon: "error",
									// 			button: "Ok",
									// 			},function(){ 
									// 				$("#popup_modal_sm").hide();
									// 				window.location.href = "<?php echo base_url().'addchapters/'?>"+course_id;
									// 		});	
									// }else{
									// 		swal({
									// 			title: "Not Deleted",
									// 			text: "",
									// 			icon: "error",
									// 			button: "Ok",
									// 			},function(){ 
									// 				$("#popup_modal_sm").hide();
									// 				window.location.href = "<?php echo base_url().'addchapters/'?>"+course_id;
									// 		});	
									// }

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										//$(".loader_ajax").hide();
									}
								})
				// 			}
				// 			else {
				// 	swal("Cancelled", "Topics deletion cancelled ", "error");
				// 	}
				// });
		});

    </script>
<?php } ?>

<?php if($pageTitle=='Time Table Listing' || $pageTitle=='Add New Time Table Listing'){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
			    var course_id_form = $('#course_id_form').val();
				var dt = $('#view_time_table_list').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "10%", "targets": 0 },
						{ "width": "10%", "targets": 1 },
						{ "width": "20%", "targets": 2 },
						{ "width": "5%", "targets": 3 },
					],
					responsive: true,
					"oLanguage": {
						"sEmptyTable": "<i>No TimeTable List  Found.</i>",
					}, 
					"bSort" : false,
					"bFilter":true,
					"bLengthChange": true,
					"iDisplayLength": 10,   
					"bProcessing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url();?>fetchTimetable/"+course_id_form,
						type: "post",
					},
				});
		});

		$(document).on('click','#save_timetable_listing',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var course_id_form = $('#course_id_form').val();
			var formData = new FormData($("#addNewtimetable_form")[0]);
			$.ajax({
				url : "<?php echo base_url();?>savenewtimetable",
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
						// swal({
						// 	title: "Time Table Successfully Uplaoded !",
						// 	//text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'timetableListing/'?>"+course_id_form;
						//});						
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   		//$(".loader_ajax").hide();
			    }
			});
			return false;
	    });

		$(document).on('click','.delete_topic_timetable',function(e){

				var elemF = $(this);
				e.preventDefault();

					// swal({
					// 	title: "Are you sure?",
					// 	text: "",
					// 	type: "warning",
					// 	showCancelButton: true,
					// 	closeOnClickOutside: false,
					// 	confirmButtonClass: "btn-sm btn-danger",
					// 	confirmButtonText: "Yes, delete it!",
					// 	cancelButtonText: "No, cancel plz!",
					// 	closeOnConfirm: false,
					// 	closeOnCancel: false
					// }, function(isConfirm) {
					// 	if (isConfirm) {
									$.ajax({
										url : "<?php echo base_url();?>deletetopictimetable",
										type: "POST",
										data : {'time-table-id' :elemF.attr('time-table-id'), 'course_id' : elemF.attr('course_id')},
										//data : 'time-table-id='+elemF.attr('time-table-id'),
										success: function(data, textStatus, jqXHR)
										{
											// if(data.status=='success'){
												// swal("Deleted!", "Course Type has been deleted.", "success");
												// location.reload();
											//}
											const obj = JSON.parse(data);
											if(obj.status=='success'){
												// swal({
												// 	title: "Deleted!",
												// 	text: "",
												// 	icon: "success",
												// 	button: "Ok",
												// 	},function(){ 
														$("#popup_modal_sm").hide();
														window.location.href = "<?php echo base_url().'timetableListing/'?>"+elemF.attr('course_id');
												//});	
										    }else{
											    // swal({
												// 	title: "Not Deleted",
												// 	text: "",
												// 	icon: "error",
												// 	button: "Ok",
												// 	},function(){ 
														$("#popup_modal_sm").hide();
														window.location.href = "<?php echo base_url().'timetableListing'?>"+elemF.attr('course_id');
												//});	
										  }

										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											//$(".loader_ajax").hide();
										}
									})
					// 			}
					// 			else {
					// 	swal("Cancelled", "Time Table deletion cancelled ", "error");
					// 	}
					// });
	    });

	
	</script>
<?php } ?>

<?php if($pageTitle=='Topic Attachment Upload Listing' || $pageTitle=='Document Listing Delete'){ ?>
	<script type="text/javascript">
        $(document).ready(function() {

			var course_id_form = $('#course_id_form').val();
			var topic_id_form = $('#topic_id_form').val();
			var doc_type_form = $('#doc_type_form').val();

				var dt = $('#view_topic_document_document').DataTable({
					"columnDefs": [ 
						{ className: "details-control", "targets": [ 0 ] },
						{ "width": "20%", "targets": 0 },
						{ "width": "30%", "targets": 1 },
						{ "width": "3%", "targets": 2 },
						 { "width": "30%", "targets": 3 },
						// { "width": "30%", "targets": 5 }
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
						url :"<?php echo base_url();?>fetchTopicDocument?type="+doc_type_form+"&topic_id="+topic_id_form+"&course_id="+course_id_form+"",
						type: "post",
					},
				});
		});


		$(document).on('click','.delete_topic_document',function(e){
		var elemF = $(this);
		e.preventDefault();

		    var course_id_form = $('#course_id_form').val();
			var topic_id_form = $('#topic_id_form').val();
			var doc_type_form = $('#doc_type_form').val();

			// swal({
			// 	title: "Are you sure?",
			// 	text: "",
			// 	type: "warning",
			// 	showCancelButton: true,
			// 	closeOnClickOutside: false,
			// 	confirmButtonClass: "btn-sm btn-danger",
			// 	confirmButtonText: "Yes, delete it!",
			// 	cancelButtonText: "No, cancel plz!",
			// 	closeOnConfirm: false,
			// 	closeOnCancel: false
			// }, function(isConfirm) {
			// 	if (isConfirm) {
							$.ajax({
								url : "<?php echo base_url();?>deleteTopicDocuments",
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
										// swal({
										// 	title: "Deleted!",
										// 	text: "",
										// 	icon: "success",
										// 	button: "Ok",
										// 	},function(){ 
												$("#popup_modal_sm").hide();
												window.location.href = "<?php echo base_url();?>viewalltopicdocuments?type="+doc_type_form+"&topic_id="+topic_id_form+"&course_id="+course_id_form+"";
										//});	
								     }else{
										// swal({
										// 	title: "Not Deleted",
										// 	text: "",
										// 	icon: "error",
										// 	button: "Ok",
										// 	},function(){ 
												$("#popup_modal_sm").hide();
												window.location.href = "<?php echo base_url();?>viewalltopicdocuments?type="+doc_type_form+"&topic_id="+topic_id_form+"&course_id="+course_id_form+"";
										//});	
								}

								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									//$(".loader_ajax").hide();
								}
							})
			// 			}
			// 			else {
			// 	swal("Cancelled", "Course Type deletion cancelled ", "error");
			// 	}
			// });
		});

   </script>
<?php }  ?>

<?php if($pageTitle=='Detail View Timetable Listing'){ ?>
        
	<script type="text/javascript">
	    $(document).ready(function() {
		var course_id_form = $('#course_id_form').val();
		var time_table_id = $('#time_table_id').val();

			var dt = $('#view_time_table_topics_listing').DataTable({
				"columnDefs": [ 
					{ className: "details-control", "targets": [ 0 ] },
					{ "width": "10%", "targets": 0 },
					{ "width": "10%", "targets": 1 },
					{ "width": "30%", "targets": 2 },
					// { "width": "30%", "targets": 5 }
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
					url :"<?php echo base_url();?>fetchTopicTimetableListing?time_table_id="+time_table_id+"&course_id="+course_id_form+"",
					type: "post",
				},
			});
		});
	</script>

<?php } ?>

<?php if($pageTitle=='Examination Management'){ ?>
	<script type="text/javascript">
     $(document).ready(function() {
			var dt = $('#view_examinationlist').DataTable({
				"columnDefs": [ 
					{ className: "details-control", "targets": [ 0 ] },
					{ "width": "20%", "targets": 0 },
					{ "width": "30%", "targets": 1 },
					{ "width": "10%", "targets": 2 },
					{ "width": "10%", "targets": 3 },
					{ "width": "10%", "targets": 4 }
				],
				responsive: true,
				"oLanguage": {
					"sEmptyTable": "<i>No Examination Found.</i>",
				}, 
				"bSort" : false,
				"bFilter":true,
				"bLengthChange": true,
				"iDisplayLength": 10,   
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
					url :"<?php echo base_url();?>fetchExaminationListing",
					type: "post",
				},
			});
	});


	$(document).on('click','#save_examination',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#examination_form")[0]);
			$.ajax({
				url : "<?php echo base_url();?>createExamination",
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
							title: "Examination Created!",
							//text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'examinationlisting'?>";
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
	
	$(document).on('click','.edit_examination',function(e){
			var elemF = $(this);
			e.preventDefault();
			var exam_id = elemF.attr('data-id');
			$.ajax({  
                url:"<?php echo base_url(); ?>examination/get_signle_examinationData",  
                method:"POST",  
                data:{exam_id:exam_id},
                dataType:"json",  
                success:function(data)  
                {  
                     $('#editExamination').modal('show');

                     $('#course_name1').val(data[0].c_id);  
                     $('#examination_title1').val(data[0].exam_title);
					 $('#examination_time1').val(data[0].exam_time);
					 $('#examination_status1').val(data[0].exam_status);
                     $('#exam_id1').val(exam_id);
                }  
           })
    });


	$(document).on('click','#update_examination',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#editexamination_form")[0]);
			var id = $("#exam_id1").val();
			$.ajax({
				url : "<?php echo base_url();?>updateExamination/"+id,
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
							title: "Examination Updated!",
							text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'examinationlisting'?>";
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

	$(document).on('click','.delete_examination',function(e){
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
									url : "<?php echo base_url();?>delete_examination",
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
															window.location.href = "<?php echo base_url().'examinationlisting'?>";
													});	
											}else{

												swal({
														title: "Not Deleted!",
														text: "",
														icon: "success",
														button: "Ok",
														},function(){ 
															$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'examinationlisting'?>";
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

<?php if($pageTitle=='View Question Paper'){ ?>
	<script type="text/javascript">
  
    $(document).on('click','#addqestionapaperexel',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var examination_id = $('#examination_id').val();
			var formData = new FormData($("#addqestionapaper_form")[0]);
			$.ajax({
				url : "<?php echo base_url();?>uploadquestionpaper",
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
							title: "Question Paper Successfully Uplaoded !",
							//text: "",
							icon: "success",
							button: "Ok",
							},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'viewquestionpaper/'?>"+examination_id;
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

	

	</script>
<?php } ?>

<?php if($pageTitle=='Enquiry Follow Up'){ ?>
	<script type="text/javascript">
        $(document).ready(function() {
			var enquiry_id = $('#enquiry_id').val();
            var dt = $('#view_enquiryFollowuplist').DataTable({
	            "columnDefs": [ 
	                 { className: "details-control", "targets": [ 0 ] },
	                 { "width": "8%", "targets": 0 },
	                 { "width": "8%", "targets": 1 },
	                 { "width": "20%", "targets": 2 },
	                 { "width": "8%", "targets": 3 }
	            ],
	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Follow up Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": true,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>/fetchEnquiryFollowup/"+enquiry_id,
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

		$(document).on('click','#save_follow_up',function(e){
					e.preventDefault();
					//$(".loader_ajax").show();

					var enquiry_id = $('#enquiry_id').val();

					var formData = new FormData($("#followup_form")[0]);
					$.ajax({
						url : "<?php echo base_url();?>createFollowup",
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
								// swal({
								// 	title: "Examination Created!",
								// 	//text: "",
								// 	icon: "success",
								// 	button: "Ok",
								// 	},function(){ 
										$("#popup_modal_md").hide();
										window.location.href = "<?php echo base_url().'followup/'?>"+enquiry_id;
								//});						
							}
							
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							//$(".loader_ajax").hide();
						}
					});
					return false;
		});

		$(document).on('click','.delete_enquiry_followup',function(e){

			var enquiry_id = $('#enquiry_id').val();

			var elemF = $(this);
			e.preventDefault();

				// swal({
				// 	title: "Are you sure?",
				// 	text: "",
				// 	type: "warning",
				// 	showCancelButton: true,
				// 	closeOnClickOutside: false,
				// 	confirmButtonClass: "btn-sm btn-danger",
				// 	confirmButtonText: "Yes, delete it!",
				// 	cancelButtonText: "No, cancel plz!",
				// 	closeOnConfirm: false,
				// 	closeOnCancel: false
				// }, function(isConfirm) {
				// 	if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>delete_enquiry_followup",
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
															
													// swal({
													// 	title: "Deleted!",
													// 	text: "",
													// 	icon: "success",
													// 	button: "Ok",
													// 	},function(){ 
															$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'followup/'?>"+enquiry_id;
													//});	
											}else{

												// swal({
												// 		title: "Not Deleted!",
												// 		text: "",
												// 		icon: "success",
												// 		button: "Ok",
												// 		},function(){ 
															$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'followup/'?>"+enquiry_id;
												//});	
											}	

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										//$(".loader_ajax").hide();
									}
							    })
				// 			}
				// 			else {
				// 	swal("Cancelled", " ", "error");
				// 	}
				// });
	    });

		$(document).on('click','.edit_enquiry_followup',function(e){
			var elemF = $(this);
			e.preventDefault();
			var followup_id = elemF.attr('data-id');
			$.ajax({  
                url:"<?php echo base_url(); ?>enquiry/get_signle_followupData",  
                method:"POST",  
                data:{followup_id:followup_id},
                dataType:"json",  
                success:function(data)  
                {  
                     $('#edit_enquiry_followup').modal('show');
					 $('#follow_up_date1').val(data[0].date);
					 $('#remark1').val(data[0].remark);
                     $('#followup_id1').val(followup_id);
                }  
           })
        });

		$(document).on('click','#upadate_follow_up',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var formData = new FormData($("#update_followup_form")[0]);
			var id = $("#enquiry_id1").val();
			$.ajax({
				url : "<?php echo base_url();?>updatefollowupdata",
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
						// swal({
						// 	title: "Examination Updated!",
						// 	text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'followup/'?>"+id;
						//});						
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


	</script>
<?php } ?>

<?php if($pageTitle=='Enquiry Payment Details'){ ?>
	<script type="text/javascript">
	$(document).on('click','#update_discount',function(e){
			e.preventDefault();
			 //$(".loader_ajax").show();
			var formData = new FormData($("#update_enquiry_form")[0]);
			var enquiry_id =  $('#enquiry_id').val();
		
			$.ajax({
				url : "<?php echo base_url();?>update_discount",
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
						// swal({
						// 	title: "Examination Created!",
						// 	//text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
								$("#popup_modal_md").hide();
								window.location.href = "<?php echo base_url().'payment_details/'?>"+enquiry_id;
						//});						
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   		//$(".loader_ajax").hide();
			    }
			});
			return false;
	});

	$(document).on('blur', '#discounted_amount', function(){
		if($("#discounted_amount").val()){
			var total_amount =  parseFloat($("#total_amount").val());
			var discounted_amount =  parseFloat($("#discounted_amount").val());
			var final_cost_to_the_usr = total_amount - discounted_amount;
			$("#total_benifit").val(Math.round(discounted_amount));
			$("#final_student_amount").val(Math.round(final_cost_to_the_usr));
		}
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

	$(document).on('click','#add_manual_payment',function(e){
			e.preventDefault();
			//$(".loader_ajax").show();
			var enquiry_id = $("#enquiry_id").val();
			var formData = new FormData($("#add_paynent_form")[0]);
			$.ajax({
				url : "<?php echo base_url();?>addmanualpayment",
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
						// swal({
						// 	title: "Enquiry Created!",
						// 	//text: "",
						// 	icon: "success",
						// 	button: "Ok",
						// 	},function(){ 
								$("#popup_modal_sm").hide();
								window.location.href = "<?php echo base_url().'payment_details/'?>"+enquiry_id;
						//});						
				    }
					
				},
				error: function (jqXHR, textStatus, errorThrown)
			    {
			   		//$(".loader_ajax").hide();
			    }
			});
			return false;
	});

	$(document).on('click','.delete_enquiry_tarnsaction',function(e){
			var elemF = $(this);

			var enquiry_id = $("#enquiry_id").val();
	
			e.preventDefault();

				// swal({
				// 	title: "Are you sure?",
				// 	text: "",
				// 	type: "warning",
				// 	showCancelButton: true,
				// 	closeOnClickOutside: false,
				// 	confirmButtonClass: "btn-sm btn-danger",
				// 	confirmButtonText: "Yes, delete it!",
				// 	cancelButtonText: "No, cancel plz!",
				// 	closeOnConfirm: false,
				// 	closeOnCancel: false
				// }, function(isConfirm) {
				// 	if (isConfirm) {
								$.ajax({
									url : "<?php echo base_url();?>deleteEnquiryTransaction",
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
															
													// swal({
													// 	title: "Deleted!",
													// 	text: "",
													// 	icon: "success",
													// 	button: "Ok",
													// 	},function(){ 
															$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'payment_details/'?>"+enquiry_id;
													//});	
											}else if(obj.status=='linked'){
													// swal({
													// 		title: "Admission Alreday In use!",
													// 		text: "",
													// 		icon: "success",
													// 		button: "Ok",
													// 		},function(){ 
																$("#popup_modal_sm").hide();
																window.location.href = "<?php echo base_url().'payment_details/'?>"+enquiry_id;
													//});	
											}else{

												// swal({
												// 		title: "Not Deleted!",
												// 		text: "",
												// 		icon: "success",
												// 		button: "Ok",
												// 		},function(){ 
															$("#popup_modal_sm").hide();
															window.location.href = "<?php echo base_url().'payment_details/'?>"+enquiry_id;
													//});	
											}	

									},
									error: function (jqXHR, textStatus, errorThrown)
									{
										//$(".loader_ajax").hide();
									}
							    })
				// 			}
				// 			else {
				// 	swal("Cancelled", " ", "error");
				// 	}
				// });
	});

	$(document).on('click','.view_enquiry_tarnsaction',function(e){
			var elemF = $(this);
			e.preventDefault();
			var transaction_id = elemF.attr('data-id');
			$.ajax({  
                url:"<?php echo base_url(); ?>enquiry/get_enquiry_tarnsaction_details/"+transaction_id,  
                method:"POST",  
                data:{transaction_id:transaction_id},
                dataType:"json",  
                success:function(data)  
                {  
                
                     $('#view_enquiry_tarnsaction').modal('show');
                     $('#enquiry_number_detail').val(data[0].enquiry_number);  
					 $('#payment_mode_detail').val(data[0].payment_mode);  
					 $('#manual_payment_amount_details').val(data[0].totalAmount);
					 $('#payment_date_details').val(data[0].payment_date);
					 $('#cheuqe_number_detials').val(data[0].cheuqe_number);  
					 $('#bank_name_details').val(data[0].bank_name);  
					 $('#prepared_by_details').val(data[0].prepared_by); 
                }  
           })
    });


	$(document).on('click','.send_manual_admission_link',function(e){
			var elemF = $(this);
			e.preventDefault();
				swal({
					title: "Are you sure?",
					text: "You want to send Manual Link to User !",
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
									url : "<?php echo base_url();?>sendManualAdmissionlink",
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




