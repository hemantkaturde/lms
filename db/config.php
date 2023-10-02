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

define('EMAIL_SMTP_HOST','mail.iictn.in');		// your smtp host e.g. smtp.gmail.com
define('EMAIL_SMTP_AUTH','true');		// your smtp host e.g. smtp.gmail.com
define('EMAIL_USERNAME','admin@iictn.in');	// Your system name
define('EMAIL_PASSWORD','QY9ZT(!N#.Ro');	// Your email password
define('EMAIL_SMTP_PORT','587');				    // mail, sendmail, smtp
define('FROM_EMAIL','admin@iictn.in');		// e.g. email@example.com
define('FROM_EMAIL_NAME','IICTN-Payment');
define('EMAIL_SECURE','tls');			// e.g. email@example.com
define('EMAIL_NAME','IICTN');

define('INSTANCE_ID','651AAA06D0FAF');
define('ACCESS_TOKEN','64e7462031534');

?>