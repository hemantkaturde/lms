<?php
 include_once('../db/config.php');

 $data = [ 
         'user_id' => '1',
         'payment_id' => $_POST['razorpay_payment_id'],
         'amount' => $_POST['totalAmount'],
         'product_id' => $_POST['product_id'],
         'enq_id' => $_POST['enq_id'],
         'enq_number' => $_POST['enq_number'],
         'add_on_course_id' => $_POST['add_on_course_id'],
        ];

        $enq_id = $data['enq_id'];
        $enq_number = $data['enq_number'];
        $payment_id = $data['payment_id'];
        $amount = $data['amount'];
        $add_on_course_id = $data['add_on_course_id'];

        if($add_on_course_id){

                $paymant_type ='add_on_course_invoice';
        }else{

                $paymant_type ='regular_invoice';
        }


$sql = "INSERT INTO tbl_payment_transaction (enquiry_id,enquiry_number,razorpay_payment_id,totalAmount,payment_mode,payment_status,paymant_type,add_on_course_id)
                                    VALUES ('$enq_id','$enq_number','$payment_id','$amount','Online-Razorpay','1','$paymant_type','$add_on_course_id')";
   
 $conn->query($sql);

 // you can write your database insertation code here
 // after successfully insert transaction in database, pass the response accordingly
 $arr = array('msg' => 'Payment successfully credited', 'status' => true);  

 echo json_encode($arr);

?>

