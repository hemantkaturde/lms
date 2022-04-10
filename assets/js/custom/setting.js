// ===============================
// 		Email Template Delete
// ===============================
jQuery(document).ready(function(){

	jQuery(".deleteTemplate").click(function(){
		var id = $(this).parents("tr").attr("id");
	
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
			 url: baseURL+'deleteTemplate/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Template has been deleted.", "success");
			 }
		  });
		}
		else {
			swal("Cancelled", "Template deletion cancelled ", "error");
		  }
	  });
	});

    jQuery(".deleteSmtp").click(function(){
		var id = $(this).parents("tr").attr("id");
	
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
			 url: baseURL+'deleteSmtp/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Template has been deleted.", "success");
			 }
		  });
		}
		else {
			swal("Cancelled", "Template deletion cancelled ", "error");
		  }
	  });
	});

});


// ===============================
// 		Email Template INSERT
// ===============================
function email_template(id)
{
    	//console.log(resp);
	    var data = '';                      
	    data += '<div class="alert_msg"></div>';
	    data += '<form class="form-material" id="email_template_form">';
	    data += '<div class="row m-2">';
	    	data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Template Name</label>';
	    		data += '<input type="text" class="form-control" id="template_name" name="template_name" maxlength="128" placeholder="Enter Template Name Here" required>';
	   		 data += '</div>';

            data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Template Module</label>';
	            data += '<input type="text" class="form-control required" id="template_module" name="template_module" placeholder="Enter Template Module"  required>';
	        data += '</div>';
	       
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Description</label>';
	            data += '<textarea type="text" class="form-control required" id="template_desc" name="template_desc" placeholder="Enter Description" required></textarea>';
	        data += '</div>';

	    // data += '</div>';
	    // data += '<div class="row">';
                data += '<div class="col-md-12">';
                    if (id == 0) {
                        data += '<button type="submit" class="btn btn-sm btn-success" id="template_btn" onClick="add_template(0)" >Submit</button> ';
                    }
                    else {
                        data += '<button type="submit" class="btn btn-sm btn-success" id="template_btn" onClick="add_template('+id+')" >Update</button> ';
                    }
                // data += '</div>';
                // data += '<div class="col-sm-3">';
                    data += '<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>';
                data += '</div>';
            data += '</div>';	    
	    data += '</form>';

	    $(".modal-body-sm").html(data);
	    if(id == 0){
            $(".modal-title-sm").html("ADD TEMPLATE");
        }
        else
        {
            var path = baseURL+"emailSetting/get_single_emailTemplate/"+id;

            ajaxCall('GET',path,'','JSON',function(resp)
            {
                console.log(resp);
                $("#template_name").val(resp['templateInfo'][0]['etemp_name']);
                $("#template_module").val(resp['templateInfo'][0]['etemp_module']);
                $("#template_desc").val(resp['templateInfo'][0]['etemp_desc']);
            },
            function(errmsg)
            {
                console.log(errmsg);
            });

            $(".modal-title-sm").html("UPDATE TEMPLATE");
        }
	    $("#popup_modal_sm").modal('show');
}

function add_template(id)
{
	var check = 1;
	if($("#template_name").val()=="")
	{
		var msg = 'Please Enter Template Name';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#template_module").val()=="")
	{
		var msg = 'Please Enter Template Module';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#template_desc").val()=="")
	{
		var msg = 'Please Enter Template Description';
		check = 0;		
	}else
	{
		check = 1;
	}

	if(check == 0)
	{
        display_alert('err',msg);
        $("#popup_modal_sm").animate({'scrollTop':0},2000);
	}
	else
	{
		// var userId = $(this).data("userid"),
		var userId = $("#email_template_form").serialize(),
		hitURL = baseURL + "emailSetting/template_insert/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#template_btn").prop('disabled', true);
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : userId  
			}).done(function(data){
                console.log(data);
				if(data.status = true) { 
					if(id == 0)
					{
						swal({
							title: "Email Template created!",
							text: "Suceess message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(isConfirm){
                                if (isConfirm) {
								    $("#popup_modal_sm").hide();
								    location.reload();
                                }
						});
					}
					else
					{
						swal({
							title: "Email Template updated!",
							text: "Suceess message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(isConfirm){ 
								if (isConfirm) {
								    $("#popup_modal_sm").hide();
								    location.reload();
                                }
						});
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

// ===============================
// 		Email SMTP INSERT
// ===============================
function email_smtp(id)
{
    	//console.log(resp);
	    var data = '';                      
	    data += '<div class="alert_msg"></div>';
	    data += '<form class="form-material" id="email_smtp_form">';
	    data += '<div class="row m-2">';
	    	data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>SMTP Host</label>';
	    		data += '<input type="text" class="form-control" id="host_name" name="host_name" maxlength="128" placeholder="Enter Template Name Here" required>';
	   		 data += '</div>';

            data += '<div class="form-group col-md-6 mb-3">';
	    		data += '<label>Protocol</label>';
	    		data += '<input type="text" class="form-control" id="protocol" name="protocol" maxlength="128" placeholder="Enter Template Name Here" required>';
	   		 data += '</div>';

            data += '<div class="form-group col-md-6 mb-3">';
	    		data += '<label>SMTP Port</label>';
	    		data += '<input type="text" class="form-control" id="smtp_port" name="smtp_port" maxlength="128" placeholder="Enter Template Name Here" required>';
	   		 data += '</div>';

            data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>SMTP Username</label>';
	    		data += '<input type="text" class="form-control" id="smtp_username" name="smtp_username" maxlength="128" placeholder="Enter Template Name Here" required>';
	   		 data += '</div>';

            data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>SMTP Password</label>';
	            data += '<input type="text" class="form-control required" id="smtp_pass" name="smtp_pass" placeholder="Enter Template Module"  required>';
	        data += '</div>';
	       
	    // data += '</div>';
	    // data += '<div class="row">';
                data += '<div class="col-md-12">';
                    if (id == 0) {
                        data += '<button type="submit" class="btn btn-sm btn-success" id="smtp_btn" onClick="add_smtp(0)" >Submit</button> ';
                    }
                    else {
                        data += '<button type="submit" class="btn btn-sm btn-success" id="smtp_btn" onClick="add_smtp('+id+')" >Update</button> ';
                    }
                // data += '</div>';
                // data += '<div class="col-sm-3">';
                    data += '<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>';
                data += '</div>';
            data += '</div>';	    
	    data += '</form>';

	    $(".modal-body-sm").html(data);
	    if(id == 0){
            $(".modal-title-sm").html("ADD SMTP");
        }
        else
        {
            var path = baseURL+"emailSetting/get_single_emailSmtp/"+id;

            ajaxCall('GET',path,'','JSON',function(resp)
            {
                console.log(resp);
                $("#host_name").val(resp['smtpInfo'][0]['smtp_host']);
                $("#protocol").val(resp['smtpInfo'][0]['smtp_protocol']);
                $("#smtp_port").val(resp['smtpInfo'][0]['smtp_port']);
                $("#smtp_username").val(resp['smtpInfo'][0]['smtp_username']);
                $("#smtp_pass").val(resp['smtpInfo'][0]['smtp_password']);
            },
            function(errmsg)
            {
                console.log(errmsg);
            });

            $(".modal-title-sm").html("UPDATE SMTP");
        }
	    $("#popup_modal_sm").modal('show');
}

function add_smtp(id)
{
	var check = 1;
	if($("#host_name").val()=="")
	{
		var msg = 'Please Enter Host Name';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#protocol").val()=="")
	{
		var msg = 'Please Enter Protocol';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#smtp_port").val()=="")
	{
		var msg = 'Please Enter Port';
		check = 0;		
	}else
	{
		check = 1;
	}

	if(check == 0)
	{
        display_alert('err',msg);
        $("#popup_modal_sm").animate({'scrollTop':0},2000);
	}
	else
	{
		// var userId = $(this).data("userid"),
		var userId = $("#email_smtp_form").serialize(),
		hitURL = baseURL + "emailSetting/smtp_insert/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#smtp_btn").prop('disabled', true);
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : userId  
			}).done(function(data){
                console.log(data);
				if(data.status = true) { 
					if(id == 0)
					{
						swal({
							title: "Email SMTP Created!",
							text: "Suceess message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(isConfirm){
                                if (isConfirm) {
								    $("#popup_modal_sm").hide();
								    location.reload();
                                }
						});
					}
					else
					{
						swal({
							title: "Email SMTP updated!",
							text: "Suceess message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(isConfirm){ 
								if (isConfirm) {
								    $("#popup_modal_sm").hide();
								    location.reload();
                                }
						});
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}