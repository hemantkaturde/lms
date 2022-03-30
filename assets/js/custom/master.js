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

function add_update_users(id)
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
		alert("Please Enter required fields");
	}
	else
	{
		// var userId = $(this).data("userid"),
		var userId = $("#addNewUser_form").serialize(),
		hitURL = baseURL + "Admin/user_insert/"+id,
		currentRow = $(this);
		console.log(hitURL);

		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : userId  
			}).done(function(data){

				if(data.status = true) { 
					if(id == 0)
					{
						alert("User successfully created"); window.location.reload();
					}
					else
					{
						alert("User successfully updated"); window.location.reload();
					}
				}
				else if(data.status = false) { alert("User Error"); }
				else { alert("Access denied..!"); }
		});
	}
}

jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});