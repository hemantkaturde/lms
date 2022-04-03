// ==================================
// 		ADD NEW USER
// ==================================
// $(document).ready(function(){
	
// 	var addUserForm = $("#addUser");
	
// 	var validator = addUserForm.validate({
		
// 		rules:{
// 			fname :{ required : true },
// 			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post"} },
// 			password : { required : true },
// 			cpassword : {required : true, equalTo: "#password"},
// 			mobile : { required : true, digits : true },
// 			role : { required : true, selected : true},
// 			vendor : { required : true, selected : true}
// 		},
// 		messages:{
// 			fname :{ required : "This field is required"},
// 			email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
// 			password : { required : "This field is required"},
// 			cpassword : {required : "This field is required", equalTo: "Please enter same password" },
// 			mobile : { required : "This field is required", digits : "Please enter numbers only" },
// 			role : { required : "This field is required", selected : "Please select atleast one option" },
// 			vendor : { required : "This field is required", selected : "Please select atleast one option" }
// 		}
// 	});
// });

jQuery(document).ready(function(){
	jQuery(".deleteUser").click(function(){
		var id = $(this).parents("tr").attr("id");
	
	   swal({
		title: "Are you sure?",
		text: "You will not be able to recover this imaginary file!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-sm btn-danger",
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "No, cancel plx!",
		closeOnConfirm: false,
		closeOnCancel: false
	  }).then( function(isConfirm) {
		if (isConfirm) {
		  $.ajax({
			 url: baseURL+'deleteUser/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Your imaginary file has been deleted.", "success");
			 }
		  });
		} else {
		  swal("Cancelled", "Your imaginary file is safe :)", "error");
		}
	  });
	});

	jQuery(".deleteRole").click(function(){
		var id = $(this).parents("tr").attr("id");
	
	   swal({
		title: "Are you sure?",
		text: "You will not be able to recover this imaginary file!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-sm btn-danger",
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "No, cancel plx!",
		closeOnConfirm: false,
		closeOnCancel: false
	  }).then( function(isConfirm) {
		if (isConfirm) {
		  $.ajax({
			 url: baseURL+'deleteRole/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Your imaginary file has been deleted.", "success");
			 }
		  });
		} else {
		  swal("Cancelled", "Your imaginary file is safe :)", "error");
		}
	  });
	});
});



function users(id)
{
    var path = baseURL+"admin/get_assets_for_user";

    ajaxCall('GET',path,'','JSON',function(resp)
    {
    	//console.log(resp);
	    var data = '';                      
	    data += '<div class="alert_msg"></div>';
	    data += '<form class="form-material" id="user_form">';
	    data += '<div class="row m-2">';
	    	data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Name</label>';
	    		data += '<input type="text" class="form-control" id="fname" name="fname" maxlength="128" placeholder="Enter Full Name Here" required>';
	   		 data += '</div>';
	        data += '<div class=" form-group col-md-12 mb-3">';
	            data += '<label>Email Id</label>';
	            data += '<input type="text" class="form-control required email" id="email" name="email" maxlength="128" placeholder="Eg. xyz@gmail.com" required>';
	        data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Password</label>';
	            data += '<input type="password" class="form-control required" id="password" name="password" maxlength="20" placeholder="Enter Password" required="">';
	        data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Confirm Password</label>';
	            data += '<input type="password" class="form-control required equalTo" id="cpassword" name="cpassword" maxlength="20" placeholder="Confirm Your Password" required="">';
	        data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Telephone No</label>';
	            data += '<input type="text" class="form-control required digits" id="mobile" name="mobile" placeholder="Enter 10 Digit Mobile Number" maxlength="10" required>';
	        data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Role</label>';
	            data += '<select class="form-control required" id="role" name="role" placeholder="Select Role" required="">';
	            	data += '<option value="">Choose Role</option>';
	            	$.each(resp['roles'], (index, value) => {
            			data += '<option value="'+value['roleId']+'">'+value['role'] +'</option>';                        
        			});
	            data += '</select>';
	        data += '</div>';
	    // data += '</div>';
	    // data += '<div class="row">';
                data += '<div class="col-md-12">';
                    if (id == 0) {
                        data += '<button type="submit" class="btn btn-sm btn-success" id="user_btn" onClick="add_user(0)" >Submit</button> ';
                    }
                    else {
                        data += '<button type="submit" class="btn btn-sm btn-success" id="user_btn" onClick="add_user('+id+')" >Update</button> ';
                    }
                // data += '</div>';
                // data += '<div class="col-sm-3">';
                    data += '<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>';
                data += '</div>';
            data += '</div>';	    
	    data += '</form>';

	    $(".modal-body-sm").html(data);
	    if(id == 0){
            $(".modal-title-sm").html("ADD USER");
        }
        else
        {
            var path = baseURL+"admin/get_signle_user_for_edit/"+id;

            ajaxCall('GET',path,'','JSON',function(resp)
            {
                console.log(resp);
                $("#fname").val(resp['userInfo'][0]['name']);
                $("#email").val(resp['userInfo'][0]['email']);
                $("#mobile").val(resp['userInfo'][0]['mobile']);
                $("#role").val(resp['userInfo'][0]['roleId']);
            },
            function(errmsg)
            {
                console.log(errmsg);
            });

            $(".modal-title-sm").html("UPDATE USER");
        }
	    $("#popup_modal_sm").modal('show');

	 },
    function(errmsg)
    {
        console.log(errmsg);
    });
}

function add_user(id)
{
	var check = 1;
	if($("#fname").val()=="")
	{
		check = 0;		
	}else
	{
		check = 1;
	}
	if(check == 0)
	{
		$("#popup_modal_sm").hide();
		var msg = 'Please enter name';
        display_alert('err',msg);
        $("#popup_modal_sm").animate({'scrollTop':0},2000);
	}
	else
	{
		// var userId = $(this).data("userid"),
		var userId = $("#user_form").serialize(),
		hitURL = baseURL + "Admin/user_insert/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#user_btn").prop('disabled', true);
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : userId  
			}).done(function(data){

				if(data.status = true) { 
					if(id == 0)
					{
						swal({
							title: "User Created!",
							text: "Suceess message sent!!",
							icon: "success",
							button: "Ok",
							timer: 2000
							}).then(function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
					else
					{
						// alert("User successfully updated"); window.location.reload();
						swal({
							title: "User updated!",
							text: "Suceess message sent!!",
							icon: "success",
							button: "Ok",
							timer: 2000
							}).then(function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
						// $("#popup_modal_sm").hide();
						// var msg = 'User updated successfully';
                        // display_alert('succ',msg);
                        // $("#popup_modal_sm").animate({'scrollTop':0},2000);
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

function add_role()
{
	var check = 1;
	if($("#role").val()=="")
	{
		check = 0;		
	}else
	{
		check = 1;
	}
	if(check == 0)
	{
		var msg = 'Please enter name';
        display_alert('err',msg);
        $("#body, html").animate({'scrollTop':0},2000);
	}
	else
	{
		// var userId = $(this).data("userid"),
		var userId = $("#role_form").serialize(),
		hitURL = baseURL + "addNewRole/",
		currentRow = $(this);
		console.log(hitURL);
		$("#role_btn").prop('disabled', true);
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : userId  
			}).done(function(data){
				console.log(data);
				if(data == 1) { 
					swal({
						title: "Role Created!",
						text: "Suceess message sent!!",
						icon: "success",
						button: "Ok",
						timer: 2000
					}).then(function(){ 
						window.location.href = baseURL+"roleListing";
					});
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

function update_role(id)
{
	var check = 1;
	if($("#role").val()=="")
	{
		check = 0;		
	}else
	{
		check = 1;
	}
	if(check == 0)
	{
		var msg = 'Please enter name';
        display_alert('err',msg);
        $("#body, html").animate({'scrollTop':0},2000);
	}
	else
	{
		// var userId = $(this).data("userid"),
		var userId = $("#role_form").serialize(),
		hitURL = baseURL + "editRoleRecord/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#role_btn").prop('disabled', true);
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : userId  
			}).done(function(data){
				console.log(data);
				if(data == 1) { 
					swal({
						title: "Role Updated!",
						text: "Suceess message sent!!",
						icon: "success",
						button: "Ok",
						timer: 2000
					}).then(function(){ 
						window.location.href = baseURL+"roleListing";
					});
				}
				else if(data.status = false) { alert("Role Error"); }
				else { alert("Access denied..!"); }
		});
	}
}