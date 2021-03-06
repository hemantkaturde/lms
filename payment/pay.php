
<html>
<head>
    <title>PHP Razorpay Payment Gateway Integration Example</title>
</head>
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
</style>

<body>
    <div class="container">
        <br><br><br>
        <div class="row justify-content-center align-items-center">
              <?php
              include_once('../db/config.php');
              $id = $_GET['enq'];
              $sql = "SELECT * FROM tbl_enquiry where enq_number='".$id."' and isDeleted =0" ;
              $result = $conn->query($sql);
              //$row = $result->fetch_assoc();
              if($result->num_rows > 0){ 
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
                    $course_name .= $i.'-'.$row_course['course_name']. ',';    
                }
                  $all_course_name = trim($course_name, ', ');
              ?>

            <div class="col-md-6 justify-content-center align-items-center">
                <figure class="card card-product justify-content-center align-items-center" style="border: 1px solid #212529; background: #fff">
                    <div class="img-wrap"><img src="https://iictn.in/assets/img/logos/iictn_lms.png">
                    </div>
                    <figcaption class="info-wrap ">
                                    <h4 class="title">Contact Infromation</h4>
                                    <div class="rating-wrap">
                                        <div class="label-rating"><b>Enquiry Number : </b><?php echo $row['enq_number']; ?> </div><br>
                                        <div class="label-rating"><b>Name : </b><?php echo $row['enq_fullname']; ?> </div><br>
                                        <div class="label-rating"><b>Mobile Number : </b><?php echo $row['enq_mobile']; ?></div><br>
                                        <div class="label-rating"><b>Selected Courses : </b><?php echo $course_name; ?></div>
                                    </div> <!-- rating-wrap.// -->
                    </figcaption><br>

                    <div class="bottom-wrap col-md-6 justify-content-center align-items-center" style="margin-bottom:15px">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary float-right buy_now"
                            data-amount="<?php echo $total_fees; ?>" data-id="1">Pay Now</a>
                        <div class="price-wrap h5">
                            <span class="price-new">??? <?php echo $total_fees; ?></span>
                        </div> <!-- price-wrap.// -->
                    </div> <!-- bottom-wrap.// -->
                </figure>
            </div> <!-- col // -->
        </div> <!-- row.// -->
    </div>
    <!--container.//-->

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    $('body').on('click', '.buy_now', function(e) {
        var totalAmount = $(this).attr("data-amount");
        var product_id = $(this).attr("data-id");
        var options = {
            "key": "<?php echo RAZORPAYKEY;?>",
            "amount": (<?php echo $total_fees; ?> * 100), // 2000 paise = INR 20
            "name": "IICTN",
            "description": "Payment",
            "image": "https://iictn.in/assets/img/logos/iictn_lms.png",
            "handler": function(response) {
                $.ajax({
                    url: '<?php echo SERVER;?>payment/payment-process.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        razorpay_payment_id: response.razorpay_payment_id,
                        totalAmount: totalAmount,
                        product_id: product_id,
                    },
                    success: function(msg) {
                        window.location.href = '<?php echo SERVER;?>payment/success.php?enq=<?=$row['enq_id'];?>';
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
    });
    </script>
</body>

</html>

<?php
      }
?>