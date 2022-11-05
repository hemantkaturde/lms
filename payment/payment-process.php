<?php
 include_once('../db/config.php');

 $data = [ 
         'user_id' => '1',
         'payment_id' => $_POST['razorpay_payment_id'],
         'amount' => $_POST['totalAmount'],
         'product_id' => $_POST['product_id'],
         'enq_id' => $_POST['enq_id'],
         'enq_number' => $_POST['enq_number'],
        ];

        $enq_id = $data['enq_id'];
        $enq_number = $data['enq_number'];
        $payment_id = $data['payment_id'];
        $amount = $data['amount'];

$sql = "INSERT INTO tbl_payment_transaction (enquiry_id,enquiry_number,razorpay_payment_id,totalAmount,payment_mode,payment_status)
                                    VALUES ('$enq_id','$enq_number','$payment_id','$amount','Online-Razorpay','1')";
   
 $conn->query($sql);

 // you can write your database insertation code here
 // after successfully insert transaction in database, pass the response accordingly
 $arr = array('msg' => 'Payment successfully credited', 'status' => true);  

 echo json_encode($arr);

?>

