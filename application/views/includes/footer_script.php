<?php
if($pageTitle=='Course Management'){?>
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
	                "sEmptyTable": "<i>No Trips Found.</i>",
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

		
			
		



    </script>   
<?php } ?>