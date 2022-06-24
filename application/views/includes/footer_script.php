<!-- Comman page javascript -->

<script type="text/javascript">
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
							text: "Success message sent!!",
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
			        $.ajax({
						url : "<?php echo base_url();?>delete_course",
						type: "POST",
						data : 'id='+elemF.attr('data-id'),
						success: function(data, textStatus, jqXHR)
						    {
								// if(data.status=='success'){
									swal("Deleted!", "User has been deleted.", "success");
									location.reload();
								//}
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
										//$(".loader_ajax").hide();
							}
					})              

        });

		$(document).on('click','.delete_course',function(e){
			var elemF = $(this);
			e.preventDefault();

				swal({
					title: "Are you sure?",
					text: "You will not be able to recover this imaginary file!",
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
											swal("Deleted!", "User has been deleted.", "success");
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
					swal("Cancelled", "User deletion cancelled ", "error");
					}
				});
	    });
    </script>   
<?php } ?>


<?php if($pageTitle=='Enquiry Management'){?>
<script type="text/javascript">
    $(document).ready(function() {
            var dt = $('#view_enquirylist').DataTable({
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
                    url :"<?php echo base_url();?>/fetchenquiry",
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
							title: "Course Created!",
							text: "Success message sent!!",
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
</script> 
<?php } ?>