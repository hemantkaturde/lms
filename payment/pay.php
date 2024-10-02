<html>

<head>
    <title>IICTN Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
        .card-product .img-wrap {
            border-radius: 3px 3px 0 0;
            overflow: hidden;
            position: relative;
            height: 220px;
            text-align: center;
        }

        .card-product .img-wrap img {
            max-height: 100%;
            max-width: 100%;
            object-fit: cover;
        }

        .card-product .info-wrap {
            overflow: hidden;
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .card-product .bottom-wrap {
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .label-rating {
            margin-right: 10px;
            color: #333;
            display: inline-block;
            vertical-align: middle;
        }

        .card-product .price-old {
            color: #999;
        }

        @media (max-width: 576px) {
            .img-wrap {
                height: 150px;
            }

            .info-wrap h4,
            .title {
                font-size: 1.2rem;
            }

            .bottom-wrap {
                text-align: center;
            }

            .price-wrap {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <br><br><br>
        <div class="row justify-content-center align-items-center">
            <?php
           include_once('../db/config.php');
           $id = $_GET['enq'];
           
          

           if(isset($_GET['add_on_course_id'])){
             $add_on_course_id = $_GET['add_on_course_id'];
           }else{
             $add_on_course_id ='';
           }

           if($add_on_course_id){
             $add_on_course_id_condition =$add_on_course_id;
           }else{

             $add_on_course_id_condition =0;
           }

           $sql = "SELECT * FROM tbl_enquiry where enq_number='".$id."' and isDeleted =0" ;
           $result = $conn->query($sql);
           //$row = $result->fetch_assoc();
           if($result->num_rows > 0){ 

             if($add_on_course_id){

                 $sql_add = "SELECT *,tbl_add_on_courses.discount as add_on_courses_discount FROM tbl_add_on_courses 
                 join tbl_course ON  tbl_add_on_courses.course_id = tbl_course.courseId 
                 join tbl_enquiry ON  tbl_add_on_courses.enquiry_id = tbl_enquiry.enq_id 
                 where  id='".$add_on_course_id."'" ;
                 $result_add = $conn->query($sql_add);
                 $row_add = $result_add->fetch_assoc();

                 if($result_add->num_rows > 0){ 
                 

                      $all_course_name = $row_add['course_name'];
                      $course_name= $row_add['course_name'];
                      $enq_number = $row_add['enq_number'];
                      $enq_fullname= $row_add['enq_fullname'];
                      $enq_mobile = $row_add['enq_mobile'];
                      $enq_id = $row_add['enq_id'];
                      $final_amount = $row_add['course_total_fees'] - $row_add['add_on_courses_discount'];
         
                     $get_course_fees_transaction = "SELECT sum(totalAmount) as total_transaction_amount FROM `tbl_payment_transaction` where enquiry_id ='".$enq_id."' and  paymant_type='add_on_course_invoice' and payment_status=1" ;
                     $course_result_transaction = $conn->query($get_course_fees_transaction);
                     $row_course_transaction = $course_result_transaction->fetch_assoc(); 

                     if($row_course_transaction['total_transaction_amount']){

                         $total_payabale = $final_amount - $row_course_transaction['total_transaction_amount'];

                     }else{

                         $total_payabale = $final_amount;
                     }
                 }

             }else{

     
                 $row = $result->fetch_assoc(); 

                 $course_ids    =   explode(',',$row['enq_course_id']);
                 $total_fees = 0;
                 $course_name = '';
                 $i = 1;
                 foreach($course_ids as $id)
                 {
                     $get_course_fees = "SELECT * FROM tbl_course where courseId='".$id."' and isDeleted =0" ;
                     $course_result = $conn->query($get_course_fees);
                     $row_course = $course_result->fetch_assoc(); 
                     $total_fees += $row_course['course_total_fees'];
                     $course_name .= $i++.'-'.$row_course['course_name'].' ₹ '.$row_course['course_total_fees']. ',   ';    
                 }
                 $course_name = trim($course_name, ', ');
                 $enq_id = $row['enq_id'];

                 // $course_name= $row['course_name'];
                 $enq_number = $row['enq_number'];
                 $enq_fullname= $row['enq_fullname'];
                 $enq_mobile = $row['enq_mobile'];

 
                 $get_course_fees_transaction = "SELECT sum(totalAmount) as total_transaction_amount FROM `tbl_payment_transaction` where enquiry_id ='".$enq_id."' and  paymant_type='regular_invoice' and payment_status=1" ;
                 $course_result_transaction = $conn->query($get_course_fees_transaction);
                 $row_course_transaction = $course_result_transaction->fetch_assoc(); 
 
                 if($row_course_transaction['total_transaction_amount']){
 
                     $total_payabale = $row['final_amount']-$row_course_transaction['total_transaction_amount'];
 
                 }else{
 
                      $total_payabale = $row['final_amount'];
                 }  

             }

           ?>
            <?php if($total_payabale > 0){ ?>
            <div class="col-lg-6 col-md-8 col-sm-12 justify-content-center align-items-center">
                <figure class="card card-product justify-content-center align-items-center" style="border: 1px solid #212529; background: #fff">
                    <div class="img-wrap"><img src="https://iictn.in/assets/img/logos/iictn_lms.png"></div>
                    <figcaption class="info-wrap ">
                        <h4 class="title">Contact Information</h4>
                        <div class="rating-wrap">
                            <div class="label-rating"><b>Enquiry Number :</b> <?php echo $enq_number; ?> </div>
                            <br>
                            <div class="label-rating"><b>Name :</b> <?php echo $enq_fullname; ?> </div><br>
                            <div class="label-rating"><b>Mobile Number :</b> <?php echo $enq_mobile; ?></div><br>
                            <div class="label-rating"><b>Selected Courses :</b> <?php echo $course_name; ?></div>
                        </div>
                    </figcaption>
                    <br>

                    <h4 class="title">Total Course Fees</h4>
                    <div class="rating-wrap">
                        <div class="label-rating">
                            <h4><b><?php echo '₹ ' . $total_payabale; ?> </b></h4>
                        </div><br>
                    </div>

                    <div class="bottom-wrap col-lg-6 col-md-8 col-sm-12 justify-content-center align-items-center" style="margin-bottom:15px">
                        <div class="price-wrap h5">
                            <input type="number" id="final_student_amount" placeholder="Enter Amount" name="final_student_amount" class="form-control col-lg-12 col-md-12 col-sm-12">
                            <span id="error"> <span>
                        </div>
                        <div style="text-align: center;">
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary buy_now" data-amount="" data-id="1">Pay Now</a>
                        </div>
                    </div>
                </figure>
            </div>
            <?php } else { ?>
            <!-- All Payment Done Section -->
            <div class="col-lg-6 col-md-8 col-sm-12 text-center">
                <article class="bg-secondary mb-3" style="background-color:#fff !important">
                    <div class="card-body">
                        <img src="https://iictn.in/assets/img/logos/iictn_lms.png" width="150px" height="150px" alt="Company Logo" />
                        <h2 class="text-black"><b>!! All Payment Already Done !!</b></h2>
                    </div>
                </article>
            </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $('body').on('click', '.buy_now', function(e) {
            var final_amt = $("#final_student_amount").val();
            if (final_amt) {
                var totalAmount = final_amt;
                var addoncourseid = <?php echo $add_on_course_id_condition; ?>;
                var product_id = $(this).attr("data-id");
                var options = {
                    "key": "<?php echo RAZORPAYKEY; ?>",
                    "amount": (totalAmount * 100),
                    "name": "IICTN",
                    "description": "Payment",
                    "image": "https://iictn.in/assets/img/logos/iictn_lms.png",
                    "handler": function(response) {
                        $.ajax({
                            url: '<?php echo SERVER; ?>payment/payment-process.php',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                razorpay_payment_id: response.razorpay_payment_id,
                                totalAmount: totalAmount,
                                product_id: product_id,
                                enq_id: <?php echo $enq_id; ?>,
                                enq_number: <?php echo $enq_number; ?>,
                                add_on_course_id: addoncourseid,
                            },
                            success: function(msg) {
                                if(addoncourseid) {
                                    window.location.href = '<?php echo SERVER; ?>payment/success.php?enq=<?=$enq_id;?>&&add_on_course_id=<?=$add_on_course_id?>';
                                } else {
                                    window.location.href = '<?php echo SERVER; ?>payment/success.php?enq=<?=$enq_id;?>';
                                }
                            }
                        });
                    },
                    "theme": {
                        "color": "#528FF0"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
                e.preventDefault();
            } else {
                alert('Enter Amount');
            }
        });
    </script>
</body>
<?php
      }
?>