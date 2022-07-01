var l = window.location;
var base_url = 'http://localhost/lms/lms/';
// base_url += '';

function display_alert(type,message)
{
    var alert_msg = '';

    if(type == 'err')
    {
        alert_msg += '<div class="alert alert-danger alert-bordered m-t-40" role="alert">';
        alert_msg += '<span><strong>'+message+'</strong></span></div>';
    }
    else if(type == 'warn')
    {
        alert_msg += '<div class="alert alert-warning alert-bordered m-t-40" role="alert">';
        alert_msg += '<span ><strong>'+message+'</strong></span></div>';
    }
    else if(type == 'succ')
    {
        alert_msg += '<div class="alert alert-success alert-bordered m-t-40" role="alert">';
        alert_msg += '<span><strong>'+message+'</strong></span></div>';
    }

    $(".alert_msg").html(alert_msg);

    setTimeout(function(){
        $(".alert_msg").html("");       
    },5000);
}

$('#login-form #login_btn').click(function(e) {

    $('#login-form').validate({
        errorClass: "help-block",
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        highlight: function(e) {
            $(e).closest(".form-group").addClass("has-error")
        },
        unhighlight: function(e) {
            $(e).closest(".form-group").removeClass("has-error")
        },
        submitHandler: function(form)
         {
            var str = $("#login-form").serialize();
            var path = base_url+"login/loginMe";
           console.log(path);
            $.ajax({
                type:"POST",
                data:str,
                url:path,
                dataType:'JSON',
                success:function(result)
                {
                    console.log(result);
                    if(result == 1)
                    {
                        window.location.href=base_url+"dashboard";
                    }
                    else
                    {
                        var msg = 'Email address or Password is wrong';
                        display_alert('err',msg);
                        $("body, html").animate({'scrollTop':0},2000);
                    }
                }
            });
        }               
    });
});

// $('#login-form #login_btn').click(function(e) {

//     $('#login-form').validate({
//         errorClass: "help-block",
//         rules: {
//             email: {
//                 required: true,
//                 email: true
//             },
//             password: {
//                 required: true
//             }
//         },
//         highlight: function(e) {
//             $(e).closest(".form-group").addClass("has-error")
//         },
//         unhighlight: function(e) {
//             $(e).closest(".form-group").removeClass("has-error")
//         },
//         submitHandler: form
        
//         }),
//         function form()
//          {
//             var str = $("#login-form").serialize();
//             var path = base_url+"login/loginMe";
           
//             $.ajax({
//                 type:"POST",
//                 data:str,
//                 url:path,
//                 dataType:'JSON',
//                 success:function(result)
//                 {
//                     console.log(result);
//                     if(result == 1)
//                     {
//                         window.location.href=base_url+"dashboard";
//                     }
//                     else
//                     {
//                         var msg = 'Email address or Password is wrong';
//                         display_alert('err',msg);
//                         $("body, html").animate({'scrollTop':0},2000);
//                     }
//                 }
//             });
//         }               
    
// });
