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

    define('RAZORPAYKEY','rzp_live_EjGpefgMl9fDxf');
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
    define('RAZORPAYKEY','rzp_live_EjGpefgMl9fDxf');
}



define('EMAIL_SMTP_HOST','mail.iictn.in');		// your smtp host e.g. smtp.gmail.com
define('EMAIL_SMTP_AUTH','true');		// your smtp host e.g. smtp.gmail.com
define('EMAIL_USERNAME','admin@iictn.in');	// Your system name
define('EMAIL_PASSWORD','tSap[NWrd6^B');	// Your email password
define('EMAIL_SMTP_PORT','587');				    // mail, sendmail, smtp
define('FROM_EMAIL','admin@iictn.in');		// e.g. email@example.com
define('FROM_EMAIL_NAME','IICTN-Payment');
define('EMAIL_SECURE','tls');			// e.g. email@example.com
define('EMAIL_NAME','IICTN');

//define('INSTANCE_ID','65784BDAEE97A');
//define('ACCESS_TOKEN','64e7462031534');

define('INSTANCE_ID','0qYcUO2erwVT7Wp');
define('ACCESS_TOKEN','3e4e9f746799bd08b6d912c8ee99ec0a0900ea0c');

?>