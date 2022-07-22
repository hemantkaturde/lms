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

?>