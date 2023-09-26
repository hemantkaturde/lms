<?php
if($_SERVER['HTTP_HOST']=='localhost'){
  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lms";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    define('RAZORPAYKEY','rzp_test_MuaQbngB5NBp7h');
    define('SERVER','http://localhost/lms_2/');

}else{
    $servername = 'localhost';
    $username = 'iictn';
    $password = 'lms2022';
    $dbname = 'lmsiictn';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    define('SERVER','https://iictn.in/');
    define('RAZORPAYKEY','rzp_test_MuaQbngB5NBp7h');
}

define('EMAIL_SMTP_HOST','smtp-relay.brevo.com');	
define('EMAIL_SMTP_AUTH','true');	
define('EMAIL_USERNAME','admin@iictn.in');
define('EMAIL_PASSWORD','EFwG7g1h2vmOTMHB');
define('EMAIL_SMTP_PORT','587');
define('FROM_EMAIL','admin@iictn.in');
define('FROM_EMAIL_NAME','IICTN-Payment');
define('EMAIL_SECURE','tls');
define('EMAIL_NAME','IICTN');	

define('INSTANCE_ID','64FC5A51A7429');
define('ACCESS_TOKEN','64e7462031534');

?>