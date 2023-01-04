
// ==================================
// 		ADD NEW USER
// ==================================
$(document).ready(function(){

	$('#popup_modal_sm').on('shown.bs.modal', function() {
		$('.datepicker').datepicker({
		  format: "dd-mm-yyyy",
		  todayBtn: "linked",
		  autoclose: true,
		  todayHighlight: true,
		});

		$(".select2_demo_1").select2();
	  });
	  
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
});

jQuery(document).ready(function(){
	jQuery(".deleteUser").click(function(){
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
			 url: baseURL+'deleteUser/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "User has been deleted.", "success");
			 }
		  });
		} 
		else {
		  swal("Cancelled", "User deletion cancelled ", "error");
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
		closeOnClickOutside: false,
		confirmButtonClass: "btn-sm btn-danger",
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "No, cancel plz!",
		closeOnConfirm: false,
		closeOnCancel: false
	  }, function(isConfirm) {
		if (isConfirm) {
		  $.ajax({
			 url: baseURL+'deleteRole/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Role has been deleted.", "success");
			 }
		  });
		}
		else {
			swal("Cancelled", "Role deletion cancelled ", "error");
		  }
	  });
	});

	jQuery(".deleteCourse").click(function(){
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
			 url: baseURL+'deleteCourse/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Course has been deleted.", "success");
			 }
		  });
		}
		else {
			swal("Cancelled", "Course deletion cancelled ", "error");
		  }
	  });
	});

	jQuery(".deleteCourseLink").click(function(){
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
			 url: baseURL+'deleteCourseLink/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Link has been deleted.", "success");
			 }
		  });
		}
		else {
			swal("Cancelled", "Link deletion cancelled ", "error");
		  }
	  });
	});

	jQuery(".deleteCourseType").click(function(){
		var id = $(this).parents("tr").attr("id");
	
	   swal({
		title: "Are you sure?",
		text: "You will not be able to recover this file!",
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
			 url: baseURL+'deleteCourseType/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Certificate Type has been deleted.", "success");
			 }
		  });
		}
		else {
			swal("Cancelled", "Certificate Type deletion cancelled ", "error");
		  }
	  });
	});

	jQuery(".deleteStudent").click(function(){
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
			 url: baseURL+'deleteStudent/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Student has been deleted.", "success");
			 }
		  });
		}
		else {
			swal("Cancelled", "Student deletion cancelled ", "error");
		  }
	  });
	});

	jQuery(".deleteEnquiry").click(function(){
		var id = $(this).parents("tr").attr("id");
	
	   swal({
		title: "Are you sure?",
		text: "You will not be able to recover this file!",
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
			 url: baseURL+'deleteEnquiry/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Enquiry has been deleted.", "success");
			 }
		  });
		}
		else {
			swal("Cancelled", "Enquiry deletion cancelled ", "error");
		  }
	  });
	});

	jQuery(".deleteAdmission").click(function(){
		var id = $(this).parents("tr").attr("id");
	
	   swal({
		title: "Are you sure?",
		text: "You will not be able to recover this file!",
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
			 url: baseURL+'deleteAdmission/'+id,
			 type: 'DELETE',
			 error: function() {
				alert('Something is wrong');
			 },
			 success: function(data) {
				  $("#"+id).remove();
				  swal("Deleted!", "Admission has been deleted.", "success");
			 }
		  });
		}
		else {
			swal("Cancelled", "Admission deletion cancelled ", "error");
		  }
	  });
	});

});

// ===============================
// 		USER INSERT
// ===============================

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
	    		data += '<input type="hidden" class="form-control" id="user_flag" name="user_flag" value="user" readonly>';
	    		data += '<input type="text" class="form-control" id="fname" name="fname" maxlength="128" placeholder="Enter Full Name Here" required>';
	   		 data += '</div>';
	        data += '<div class=" form-group col-md-12 mb-3">';
	            data += '<label>Email Id</label>';
	            data += '<input type="text" class="form-control required email" id="email" name="email" maxlength="128" placeholder="Eg. xyz@gmail.com" required>';
	        data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Password</label>';
	            data += '<input type="password" class="form-control required" id="password" name="password"  placeholder="Enter Password" required="">';
				data += '<span onclick="view_password();" style="float: right;margin-top: -26px;margin-right: 5px;"><i class="fa fa-eye"></i></span>';
	        data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Confirm Password</label>';
	            data += '<input type="password" class="form-control required equalTo" id="cpassword" name="cpassword"  placeholder="Confirm Your Password" required="">';
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

function staff(id)
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
	    		data += '<input type="hidden" class="form-control" id="user_flag" name="user_flag" value="staff" readonly>';
	    		data += '<input type="text" class="form-control" id="fname" name="fname" maxlength="128" placeholder="Enter Full Name Here" required>';
	   		 data += '</div>';
	        data += '<div class=" form-group col-md-12 mb-3">';
	            data += '<label>Email Id</label>';
	            data += '<input type="text" class="form-control required email" id="email" name="email" maxlength="128" placeholder="Eg. xyz@gmail.com" required>';
	        data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Password</label>';
	            data += '<input type="password" class="form-control required" id="password" name="password"  placeholder="Enter Password" required="">';
				data += '<span onclick="view_password();" style="float: right;margin-top: -26px;margin-right: 5px;"><i class="fa fa-eye"></i></span>';
	        data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Confirm Password</label>';
	            data += '<input type="password" class="form-control required equalTo" id="cpassword" name="cpassword"  placeholder="Confirm Your Password" required="">';
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

function view_password() {
	var x = document.getElementById("password");
	if (x.type === "password") {
	  x.type = "text";
	} else {
	  x.type = "password";
	}
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
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							},function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
					else
					{
						// alert("User successfully updated"); window.location.reload();
						swal({
							title: "User updated!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(){ 
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

// ===============================
// 		ROLE INSERT
// ===============================
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
						text: "Success message sent!!",
						icon: "success",
						button: "Ok",
						// timer: 2000
					}, function() {
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
						text: "Success message sent!!",
						icon: "success",
						button: "Ok",
						// timer: 2000
					}, function() {
						window.location.href = baseURL+"roleListing";
					});
					// .then(function(){ 
					// 	window.location.href = baseURL+"roleListing";
					// });
				}
				else if(data.status = false) { alert("Role Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

// ===============================
// 		COURSE INSERT
// ===============================
function courses(id)
{
    var path = baseURL+"course/get_courseAllTypeData";

	ajaxCall('GET',path,'','JSON',function(resp)
	{
	console.log(resp);
	    var data = '';                      
	    data += '<div class="alert_msg"></div>';
	    data += '<form class="form-material" id="course_form">';
	    data += '<div class="row m-2">';
	    	data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Course Name</label>';
	    		data += '<input type="text" class="form-control" id="course_name" name="course_name" maxlength="128" placeholder="Enter Course Name Here" required>';
	   		 data += '</div>';
	       
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Description</label>';
	            data += '<textarea type="text" class="form-control required" id="course_desc" name="course_desc" placeholder="Enter Description" required></textarea>';
	        data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Fees</label>';
	    		data += '<input type="text" class="form-control" id="course_fees" name="course_fees" placeholder="Enter Fees Here" required>';
	   		 data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Certificate Cost</label>';
	    		data += '<input type="text" class="form-control" id="course_cert_cost" name="course_cert_cost" placeholder="Enter Certificate Cost Here" required>';
	   		data += '</div>';
			data += '<div class="form-group col-md-12 mb-3">';
			   data += '<label>One time admission fees</label>';
			   data += '<input type="text" class="form-control" id="course_onetime_adm_fees" name="course_onetime_adm_fees" placeholder="Enter One time admission fees Here" required>';
			data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
			   data += '<label>Kit cost</label>';
			   data += '<input type="text" class="form-control" id="course_kit_cost" name="course_kit_cost" placeholder="Enter Kit Cost Here" required>';
			data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Remarks</label>';
	            data += '<textarea type="text" class="form-control" id="course_remark" name="course_remark" placeholder="Enter Remark"></textarea>';
	        data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Certificate Type</label>';
				data += '<select class="form-control select2_demo_1 required" id="course_type_id" name="course_type_id" placeholder="Select Certificate Type" required="" multiple>';
	            	data += '<option value="">Choose Certificate Type</option>';
	            	$.each(resp['courseTypeInfo'], (index, value) => {
            			data += '<option value="'+value['ct_id']+'">'+value['ct_name'] +'</option>';                        
        			});
	        	data += '</select>';
			data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Books</label></br>';
	            data += '<input type="checkbox" class="" id="course_books" name="course_books" value="YES" placeholder="Enter Books"> YES';
				data += '<input type="checkbox" class="" id="course_books" name="course_books" value="NO" placeholder="Enter Books" style="margin-left:20px;"> NO';
	        data += '</div>';
	    // data += '</div>';
	    // data += '<div class="row">';
                data += '<div class="col-md-12">';
                    if (id == 0) {
                        data += '<button type="submit" class="btn btn-sm btn-success" id="course_btn" onClick="add_course(0)" >Submit</button> ';
                    }
                    else {
                        data += '<button type="submit" class="btn btn-sm btn-success" id="course_btn" onClick="add_course('+id+')" >Update</button> ';
                    }
                // data += '</div>';
                // data += '<div class="col-sm-3">';
                    data += '<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>';
                data += '</div>';
            data += '</div>';	    
	    data += '</form>';

	    $(".modal-body-sm").html(data);
	    if(id == 0)
		{
            $(".modal-title-sm").html("ADD COURSE");
        }
        else
        {
            var path = baseURL+"course/get_signle_courseData/"+id;

            ajaxCall('GET',path,'','JSON',function(resp)
            {
                $("#course_name").val(resp['courseInfo'][0]['course_name']);
                $("#course_desc").val(resp['courseInfo'][0]['course_desc']);

				$("#course_fees").val(resp['courseInfo'][0]['course_fees']);
				$("#course_cert_cost").val(resp['courseInfo'][0]['course_cert_cost']);
				$("#course_onetime_adm_fees").val(resp['courseInfo'][0]['course_onetime_adm_fees']);
				$("#course_kit_cost").val(resp['courseInfo'][0]['course_kit_cost']);
				$("#course_remark").val(resp['courseInfo'][0]['course_remark']);
				$("#course_type_id").val(resp['courseInfo'][0]['course_type_id']);
				$("#course_books").val(resp['courseInfo'][0]['course_books']);
            },
            function(errmsg)
            {
                console.log(errmsg);
            });

            $(".modal-title-sm").html("UPDATE COURSE");
        }
	    $("#popup_modal_sm").modal('show');
	},
	function(errmsg)
	{
		console.log(errmsg);
	});
}

function add_course(id)
{
	var check = 1;
	if($("#course_name").val()=="")
	{
		var msg = 'Please Enter Course Name';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#course_desc").val()=="")
	{
		var msg = 'Please Enter Course Description';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#course_name").val()=="")
	{
		var msg = 'Please Enter Course Date';
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
		var userId = $("#course_form").serialize(),
		hitURL = baseURL + "Course/course_insert/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#course_btn").prop('disabled', true);
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
							title: "Course Created!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							},function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
					else
					{
						swal({
							title: "Course updated!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

// ====== LINKs

function courseLink(linkId, id)
{
    	//console.log(resp);
	    var data = '';                      
	    data += '<div class="alert_msg"></div>';
	    data += '<form class="form-material" id="course_link_form">';
	    data += '<div class="row m-2">';
	    	data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Link Name</label>';
	    		data += '<input type="text" class="form-control" id="link_name" name="link_name" maxlength="128" placeholder="Enter Link Here" required>';
	   		 data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Link URL</label>';
	    		data += '<input type="text" class="form-control" id="link_url" name="link_url" placeholder="http://" required>';
	   		 data += '</div>';

				data += '<div class="form-group col-md-6 mb-3">';
	    		data += '<label>Start Date</label>';
	    		data += '<input type="text" class="form-control datepicker" id="link_sdate" name="link_sdate" placeholder="dd-mm-yyyy" required>';
	   		 data += '</div>';

				data += '<div class="form-group col-md-6 mb-3">';
	    		data += '<label>End Date</label>';
	    		data += '<input type="text" class="form-control datepicker" id="link_ldate" name="link_ldate" placeholder="dd-mm-yyyy" required>';
	   		 data += '</div>';

	    // data += '</div>';
	    // data += '<div class="row">';
                data += '<div class="col-md-12">';
                    if (linkId == 0) {
                        data += '<button type="button" class="btn btn-sm btn-success" id="link_btn" onClick="add_link(0,'+id+')" >Submit</button> ';
                    }
                    else {
                        data += '<button type="submit" class="btn btn-sm btn-success" id="link_btn" onClick="add_link('+linkId+','+id+')" >Update</button> ';
                    }
                // data += '</div>';
                // data += '<div class="col-sm-3">';
                    data += '<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>';
                data += '</div>';
            data += '</div>';	    
	    data += '</form>';

	    $(".modal-body-sm").html(data);
	    if(linkId == 0){
            $(".modal-title-sm").html("ADD LINK");
        }
        else
        {
            var path = baseURL+"course/get_course_link/"+linkId;

            ajaxCall('GET',path,'','JSON',function(resp)
            {
                console.log(resp);
                $("#link_name").val(resp['linkInfo'][0]['link_name']);
				$("#link_url").val(resp['linkInfo'][0]['link_url']);
				$("#link_sdate").val(resp['linkInfo'][0]['link_sdate']);
				$("#link_ldate").val(resp['linkInfo'][0]['link_ldate']);
            },
            function(errmsg)
            {
                console.log(errmsg);
            });

            $(".modal-title-sm").html("UPDATE LINK");
        }
	    $("#popup_modal_sm").modal('show');
}

function add_link(linkId, id)
{
	var check = 1;
	if($("#link_name").val()=="")
	{
		var msg = 'Please Enter Link Name';
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
		var userId = $("#course_link_form").serialize(),
		hitURL = baseURL + "Course/course_link_insert/"+linkId+"/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#link_btn").prop('disabled', true);
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
							title: "Link Created!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							},function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
					else
					{
						swal({
							title: "Link updated!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

// ====== Certificate Type
function course_type(id)
{
    	//console.log(resp);
	    var data = '';                      
	    data += '<div class="alert_msg"></div>';
	    data += '<form class="form-material" id="course_type_form">';
	    data += '<div class="row m-2">';
	    	data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Course Name <span style="color:red">*</span></label>';
	    		data += '<input type="text" class="form-control" id="ct_name" name="ct_name" maxlength="128" placeholder="Enter Certificate Type Here" required>';
	   		data += '</div>';
	        data += '<div class="col-md-12">';
			if (id == 0) {
				data += '<button type="submit" class="btn btn-sm btn-success" id="ct_btn" onClick="add_course_type(0)" >Submit</button> ';
			}
			else {
				data += '<button type="submit" class="btn btn-sm btn-success" id="ct_btn" onClick="add_course_type('+id+')" >Update</button> ';
			}
        	data += '<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>';
            data += '</div>';
            data += '</div>';	    
	    data += '</form>';

	    $(".modal-body-sm").html(data);
	    if(id == 0){
            $(".modal-title-sm").html("ADD Certificate Type");
        }
        else
        {
            var path = baseURL+"course/get_signle_courseTypeData/"+id;

            ajaxCall('GET',path,'','JSON',function(resp)
            {
                console.log(resp);
                $("#ct_name").val(resp['courseTypeInfo'][0]['ct_name']);
            },
            function(errmsg)
            {
                console.log(errmsg);
            });

            $(".modal-title-sm").html("UPDATE Certificate Type");
        }
	    $("#popup_modal_sm").modal('show');
}

function add_course_type(id)
{
	var check = 1;
	if($("#ct_name").val()=="")
	{
		var msg = 'Please Enter Certificate Type Name';
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
		var userId = $("#course_type_form").serialize(),
		hitURL = baseURL + "Course/course_type_insert/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#ct_btn").prop('disabled', true);
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
							title: "Certificate Type Created!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							},function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
					else
					{
						swal({
							title: "Certificate Type updated!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

// ===============================
// 		STUDENT INSERT
// ===============================

function student(id)
{
    var path = baseURL+"student/student_assets";

    ajaxCall('GET',path,'','JSON',function(resp)
    {
    	//console.log(resp);
	    var data = '';                      
	    data += '<div class="alert_msg"></div>';
	    data += '<form class="form-material" id="student_form">';
	    data += '<div class="row m-2">';
	    	data += '<div class="form-group col-md-6 mb-3">';
	    		data += '<label>First Name</label>';
	    		data += '<input type="text" class="form-control" id="fname" name="fname" maxlength="128" placeholder="Enter First Name Here" required>';
	   		 data += '</div>';
			data += '<div class="form-group col-md-6 mb-3">';
	    		data += '<label>Last Name</label>';
	    		data += '<input type="text" class="form-control" id="lname" name="lname" maxlength="128" placeholder="Enter Last Name Here" required>';
	   		 data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Mobile No</label>';
	            data += '<input type="text" class="form-control required digits" id="mobile" name="mobile" placeholder="Enter 10 Digit Mobile Number" maxlength="10" required>';
	        data += '</div>';
			data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Gender</label>';
	            data += '<select class="form-control required" id="gender" name="gender" placeholder="Select Gender" required="">';
	            	data += '<option value="">Choose Gender</option>';
					data += '<option value="Male">Male</option>';
	            	data += '<option value="Female">Female</option>';
	            data += '</select>';
	        data += '</div>';
			data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Date of Birth</label>';
	    		data += '<input type="text" class="form-control datepicker" id="dob" name="dob" maxlength="128" placeholder="dd-mm-yyyy" required>';
	   		 data += '</div>';
			data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Address</label>';
	    		data += '<textarea type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required></textarea>';
	   		 data += '</div>';
	        data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Courses</label>';
	            data += '<select class="form-control select2_demo_1 required" id="course" name="course[]" placeholder="Select Course" required="" multiple>';
	            	data += '<option value="">Choose Courses</option>';
	            	$.each(resp['courses'], (index, value) => {
            			data += '<option value="'+value['courseId']+'">'+value['course_name'] +'</option>';                        
        			});
	            data += '</select>';
	        data += '</div>';
	    // data += '</div>';
	    // data += '<div class="row">';
                data += '<div class="col-md-12">';
                    if (id == 0) {
                        data += '<button type="button" class="btn btn-sm btn-success" id="user_btn" onClick="add_student(0)" >Submit</button> ';
                    }
                    else {
                        data += '<button type="button" class="btn btn-sm btn-success" id="user_btn" onClick="add_student('+id+')" >Update</button> ';
                    }
                // data += '</div>';
                // data += '<div class="col-sm-3">';
                    data += '<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>';
                data += '</div>';
            data += '</div>';	    
	    data += '</form>';

	    $(".modal-body-sm").html(data);
	    if(id == 0){
            $(".modal-title-sm").html("ADD STUDENT");
        }
        else
        {
            var path = baseURL+"student/get_signle_student/"+id;

            ajaxCall('GET',path,'','JSON',function(resp)
            {
                console.log(resp);
                $("#fname").val(resp['studentInfo'][0]['student_fname']);
                $("#lname").val(resp['studentInfo'][0]['student_lname']);
				$("#gender").val(resp['studentInfo'][0]['student_gender']);
				$("#dob").val(resp['studentInfo'][0]['student_dob']);
                $("#mobile").val(resp['studentInfo'][0]['student_mobile']);
                $("#address").val(resp['studentInfo'][0]['student_address']);
				$("#course").val(resp['studentInfo'][0]['student_course']);
            },
            function(errmsg)
            {
                console.log(errmsg);
            });

            $(".modal-title-sm").html("UPDATE STUDENT");
        }
	    $("#popup_modal_sm").modal('show');

	 },
    function(errmsg)
    {
        console.log(errmsg);
    });
}

function add_student(id)
{
	var check = 1;
	if($("#fname").val()=="")
	{
		var msg = 'Please Enter Name';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#mobile").val()=="")
	{
		var msg = 'Please Enter Mobile Number';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#gender").val()=="")
	{
		var msg = 'Please Enter Gender';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#course").val()=="")
	{
		var msg = 'Please Enter Course';
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
		var userId = $("#student_form").serialize(),
		hitURL = baseURL + "Student/student_insert/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#stBtn").prop('disabled', true);
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
							title: "Student Created!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							},function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
					else
					{
						swal({
							title: "Student updated!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}


// ===============================
// 		ENQUIRY INSERT
// ===============================

function enquiry(id)
{
    var path = baseURL+"student/student_assets";

    ajaxCall('GET',path,'','JSON',function(resp)
    {
    	//console.log(resp);
	    var data = '';                      
	    data += '<div class="alert_msg"></div>';
	    data += '<form class="form-material" id="enquiry_form">';
	    data += '<div class="row m-2">';
	    	
			data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Name</label>';
	    		data += '<input type="text" class="form-control" id="name" name="name" maxlength="128" placeholder="Enter Full Name Here" required>';
	   		 data += '</div>';
	        data += '<div class="form-group col-md-6 mb-3">';
	            data += '<label>Mobile No</label>';
	            data += '<input type="text" class="form-control required digits" id="mobile" name="mobile" placeholder="Enter 10 Digit Mobile Number" maxlength="10" required>';
	        data += '</div>';
			data += '<div class="form-group col-md-6 mb-3">';
	            data += '<label>Alternate Mobile</label>';
	            data += '<input type="text" class="form-control required digits" id="mobile1" name="mobile1" placeholder="Enter alternate Mobile Number" maxlength="10" required>';
	        data += '</div>';

			data += '<div class="form-group col-md-6 mb-3">';
	            data += '<label>Email</label>';
	            data += '<input type="text" class="form-control required" id="email" name="email" placeholder="Enter email"required>';
	        data += '</div>';
			data += '<div class="form-group col-md-6 mb-3">';
	            data += '<label>Alternamte Email</label>';
	            data += '<input type="text" class="form-control required digits" id="email1" name="email1" placeholder="Enter alternate email">';
	        data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Qualification</label>';
	            data += '<input type="text" class="form-control required" id="qualification" name="qualification" placeholder="Enter Qualification">';
	        data += '</div>';

			data += '<div class="form-group col-md-4 mb-3">';
	            data += '<label>Country</label>';
	            data += '<input type="text" class="form-control " id="country" name="country" placeholder="Enter Country">';
	        data += '</div>';
			data += '<div class="form-group col-md-4 mb-3">';
	            data += '<label>State</label>';
	            data += '<input type="text" class="form-control " id="state" name="state" placeholder="Enter State">';
	        data += '</div>';
			data += '<div class="form-group col-md-4 mb-3">';
	            data += '<label>City</label>';
	            data += '<input type="text" class="form-control " id="city" name="city" placeholder="Enter City">';
	        data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	            data += '<label>Purpose</label>';
	            data += '<input type="text" class="form-control required" id="purpose" name="purpose" placeholder="Enter Purpose">';
	        data += '</div>';

			data += '<div class="form-group col-md-6 mb-3">';
	    		data += '<label>Date of Enquiry</label>';
	    		data += '<input type="text" class="form-control datepicker" id="enq_date" name="enq_date" placeholder="dd-mm-yyyy" required>';
	   		data += '</div>';

			data += '<div class="form-group col-md-6 mb-3">';
	            data += '<label>Enquiry Source</label>';
	            data += '<select class="form-control required" id="source" name="source" placeholder="Select Source" required="">';
	            	data += '<option value="">Choose Source</option>';
					data += '<option value="Email">Email</option>';
	            	data += '<option value="Friends">Friends</option>';
	            	data += '<option value="Other">Other</option>';
	            data += '</select>';
	        data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Remark</label>';
	    		data += '<textarea type="text" class="form-control" id="remark" name="remark" placeholder="Enter Remark" required></textarea>';
	   		 data += '</div>';
	        // data += '<div class="form-group col-md-12 mb-3">';
	        //     data += '<label>Courses</label>';
	        //     data += '<select class="form-control select2_demo_1 required" id="course" name="course[]" placeholder="Select Course" required="" multiple>';
	        //     	data += '<option value="">Choose Courses</option>';
	        //     	$.each(resp['courses'], (index, value) => {
            // 			data += '<option value="'+value['courseId']+'">'+value['course_name'] +'</option>';                        
        	// 		});
	        //     data += '</select>';
	        // data += '</div>';
	    // data += '</div>';
	    // data += '<div class="row">';
                data += '<div class="col-md-12">';
                    if (id == 0) {
                        data += '<button type="button" class="btn btn-sm btn-success" id="user_btn" onClick="add_enquiry(0)" >Submit</button> ';
                    }
                    else {
                        data += '<button type="button" class="btn btn-sm btn-success" id="user_btn" onClick="add_enquiry('+id+')" >Update</button> ';
                    }
                // data += '</div>';
                // data += '<div class="col-sm-3">';
                    data += '<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>';
                data += '</div>';
            data += '</div>';	    
	    data += '</form>';

	    $(".modal-body-sm").html(data);
	    if(id == 0){
            $(".modal-title-sm").html("ADD ENQUIRY");
        }
        else
        {
            var path = baseURL+"enquiry/get_signle_enquiry/"+id;

            ajaxCall('GET',path,'','JSON',function(resp)
            {
                console.log(resp);
                $("#name").val(resp['enquiryInfo'][0]['enq_fullname']);
                $("#mobile").val(resp['enquiryInfo'][0]['enq_mobile']);
				$("#mobile1").val(resp['enquiryInfo'][0]['enq_mobile1']);
				$("#email").val(resp['enquiryInfo'][0]['enq_email']);
                $("#email1").val(resp['enquiryInfo'][0]['enq_email1']);
                $("#qualification").val(resp['enquiryInfo'][0]['enq_qualification']);
				$("#purpose").val(resp['enquiryInfo'][0]['enq_purpose']);
				$("#country").val(resp['enquiryInfo'][0]['enq_country']);
				$("#state").val(resp['enquiryInfo'][0]['enq_state']);
				$("#city").val(resp['enquiryInfo'][0]['enq_city']);
				$("#enq_date").val(resp['enquiryInfo'][0]['enq_date']);
				$("#source").val(resp['enquiryInfo'][0]['enq_source']);
				$("#remark").val(resp['enquiryInfo'][0]['enq_remark']);
            },
            function(errmsg)
            {
                console.log(errmsg);
            });

            $(".modal-title-sm").html("UPDATE ENQUIRY");
        }
	    $("#popup_modal_sm").modal('show');

	 },
    function(errmsg)
    {
        console.log(errmsg);
    });
}

function add_enquiry(id)
{
	var check = 1;
	if($("#name").val()=="")
	{
		var msg = 'Please Enter Name';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#mobile").val()=="")
	{
		var msg = 'Please Enter Mobile Number';
		check = 0;		
	}else
	{
		check = 1;
	}

	if($("#email").val()=="")
	{
		var msg = 'Please Enter Email';
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
		var userId = $("#enquiry_form").serialize(),
		hitURL = baseURL + "Enquiry/enquiry_insert/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#stBtn").prop('disabled', true);
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
							title: "Enquiry Created!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							},function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
					else
					{
						swal({
							title: "Enquiry updated!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

// ===============================
// 		ENQUIRY INSERT
// ===============================

function admission(id)
{
    var path = baseURL+"student/student_assets";

    ajaxCall('GET',path,'','JSON',function(resp)
    {
    	//console.log(resp);
	    var data = '';
		var img_path = baseURL+"uploads/admission/no_image.gif";
	    data += '<div class="alert_msg"></div>';
	    data += '<form class="form-material" id="admission_form">';
	    data += '<div class="row m-2">';
	    	
			data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Name</label>';
	    		data += '<input type="text" class="form-control" id="full_name" name="full_name" maxlength="128" placeholder="Enter Full Name Here" required>';
	   		 data += '</div>';

			data += '<div class="form-group col-md-6 mb-3">';
	    		data += '<label>Date of Admission</label>';
	    		data += '<input type="text" class="form-control datepicker" id="adm_date" name="adm_date" placeholder="dd-mm-yyyy" required>';
	   		data += '</div>';

			data += '<div class="form-group col-md-6 mb-3">';
	            data += '<label>Enquiry Source</label>';
	            data += '<select class="form-control required" id="source" name="source" placeholder="Select Source" required="">';
	            	data += '<option value="">Choose Source</option>';
					data += '<option value="Email">Email</option>';
	            	data += '<option value="Friends">Friends</option>';
	            	data += '<option value="Other">Other</option>';
	            data += '</select>';
	        data += '</div>';

			data += '<div class="form-group col-md-12 mb-3">';
	    		data += '<label>Remark</label>';
	    		data += '<textarea type="text" class="form-control" id="remark" name="remark" placeholder="Enter Remark" required></textarea>';
	   		data += '</div>';

			data += '<div class="form-group col-md-4 mb-3">';
			   data += '<label>Photo</label>';
			   data += '<input type="file" class="form-control" id="photo" name="photo" onchange="readURL(this);">';
			data += '</div>';

			data += '<div class="form-group col-md-4 mb-3">';
			   data += '<label>Adhar Card</label>';
			   data += '<input type="file" class="form-control" id="adhar_card" name="adhar_card" onchange="readURL1(this);">';
			data += '</div>';

			data += '<div class="form-group col-md-4 mb-3">';
			   data += '<label>Pan Card</label>';
			   data += '<input type="file" class="form-control" id="pan_card" name="pan_card" onchange="readURL2(this);">';
			data += '</div>';

			data += '<div class="form-group col-md-4 mb-3">';
			   data += '<img src="'+img_path+'" id="photo1" width="50%" alt="Photo"></img>';
			data += '</div>';
			
			data += '<div class="form-group col-md-4 mb-3">';
			   data += '<img src="'+img_path+'" id="adhar_card1" width="50%" alt="Photo"></img>';
			data += '</div>';
			
			data += '<div class="form-group col-md-4 mb-3">';
			   data += '<img src="'+img_path+'" id="pan_card1" width="50%" alt="Photo"></img>';
			data += '</div>';

            data += '<div class="col-md-12">';
                    if (id == 0) {
                        data += '<button type="button" class="btn btn-sm btn-success" id="user_btn" onClick="add_admission(0)" >Submit</button> ';
                    }
                    else {
                        data += '<button type="button" class="btn btn-sm btn-success" id="user_btn" onClick="add_admission('+id+')" >Update</button> ';
                    }
                    data += '<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>';
                data += '</div>';
            data += '</div>';	    
	    data += '</form>';

	    $(".modal-body-sm").html(data);
	    if(id == 0){
            $(".modal-title-sm").html("ADD ADMISSION");
        }
        else
        {
            var path = baseURL+"admission/get_signle_admission/"+id;

            ajaxCall('GET',path,'','JSON',function(resp)
            {
                console.log(resp);
                $("#full_name").val(resp['admInfo'][0]['full_name']);
				$("#adm_date").val(resp['admInfo'][0]['admission_date']);
				$("#source").val(resp['admInfo'][0]['adm_source']);
				$("#remark").val(resp['admInfo'][0]['admission_remark']);

				if(resp['admInfo'][0]['adm_passportsize_photo'] != "")
				{
					var data = baseURL+"uploads/admission/"+resp[0]['adm_passportsize_photo'];
				}
				else
				{
					var data = baseURL+"uploads/admission/no_image.gif";
				}

				if(resp['admInfo'][0]['adm_adhar_photo'] != "")
				{
					var data1 = baseURL+"uploads/admission/"+resp[0]['adm_adhar_photo'];
				}
				else
				{
					var data1 = baseURL+"uploads/admission/no_image.gif";
				}

				if(resp['admInfo'][0]['adm_pan_photo'] != "")
				{
					var data2 = baseURL+"uploads/admission/"+resp[0]['adm_pan_photo'];
				}
				else
				{
					var data2 = baseURL+"uploads/admission/no_image.gif";
				}


				$("#photo1").attr('src',data);
				$("#adhar_card1").attr('src',data1);
				$("#pan_card1").attr('src',data2);

            },
            function(errmsg)
            {
                console.log(errmsg);
            });

            $(".modal-title-sm").html("UPDATE ADMISSION");
        }
	    $("#popup_modal_sm").modal('show');

	 },
    function(errmsg)
    {
        console.log(errmsg);
    });
}

function add_admission(id)
{
	var check = 1;
	if($("#full_name").val()=="")
	{
		var msg = 'Please Enter Name';
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
		var formid = document.getElementById('admission_form');
    	var userId = new FormData(formid);

		// var userId = $("#enquiry_form").serialize(),
		hitURL = baseURL + "Admission/admission_insert/"+id,
		currentRow = $(this);
		console.log(hitURL);
		$("#admissionBtn").prop('disabled', true);
		jQuery.ajax({
			type:'POST',
			url:hitURL,
			data : userId,
			contentType : false,
			processData : false,
			dataType : 'json',
			}).done(function(data){

				if(data.status = true) { 
					if(id == 0)
					{
						swal({
							title: "Admission Created!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							},function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
					else
					{
						swal({
							title: "Admission updated!",
							text: "Success message sent!!",
							icon: "success",
							button: "Ok",
							// timer: 2000
							}, function(){ 
								$("#popup_modal_sm").hide();
								location.reload();
						});
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

function readURL(input) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#photo1')
				.attr('src', e.target.result)
				.width(150)
				.height(150);
		};

		reader.readAsDataURL(input.files[0]);
	}
}

function readURL1(input) 
	{
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
				$('#adhar_card1')
				.attr('src', e.target.result)
				.width(150)
				.height(150);
	        };

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function readURL2(input) 
	{
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
				$('#pan_card1')
				.attr('src', e.target.result)
				.width(150)
				.height(150);
	        };

	        reader.readAsDataURL(input.files[0]);
	    }
	}