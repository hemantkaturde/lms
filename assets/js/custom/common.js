// var l = window.location;
// var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
// base_url += '/';
// (function(){
//     $("#"+link).addClass("active");
//     $("#"+sub_link).addClass("active");
// });
// =============================
/*    COMMON ALERT DIALOG     */ 
// =============================
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

// =============================
/*    DYNAMIC AJAX CALL       */ 
// =============================
function ajaxCall(callType,path,form_data,datatype,res_callback,err_callback)
{
    $("#loading").show();
    $.ajax({
        type: ''+callType+'',
        url:path,
        data:form_data,
        dataType:''+datatype+'',
        success:function(response)
        {
            res_callback(response);
        },
        error:function(error) 
        {
            err_callback(error);
        }   
    });
}