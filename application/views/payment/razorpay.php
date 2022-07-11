<!DOCTYPE html>
<html>

<head>
    <title>IICTN Payment</title>
</head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<body>
    <div class="container">
        <br><br><br>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-4">
                <figure class="card card-product">
                    <div class="img-wrap"><img src="https://iictn.in/assets/img/logos/iictn_lms.png"></div>
                    <!-- <figcaption class="info-wrap">
                        <h4 class="title">Mouse</h4>
                        <p class="desc">Some small description goes here</p>
                        <div class="rating-wrap">
                            <div class="label-rating">132 reviews</div>
                            <div class="label-rating">154 orders </div>
                        </div> 
                    </figcaption> -->

                    <figcaption class="info-wrap">
                        <h4 class="title">Contact Infromation</h4>
                        <div class="rating-wrap">
                            <div class="label-rating">Enquiry Number : <?php echo $enquiry_data[0]->enq_number; ?> </div><br>
                            <div class="label-rating">Name : <?php echo $enquiry_data[0]->enq_fullname; ?> </div><br>
                            <div class="label-rating">Mobile Number : <?php echo $enquiry_data[0]->enq_mobile; ?></div>
                        </div> <!-- rating-wrap.// -->
                    </figcaption>

                    <div class="bottom-wrap">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary float-right pay_now"
                            data-amount="<?php echo $enquiry_data[0]->course_total_fees; ?>" data-id="<?php echo $enquiry_data[0]->enq_number; ?>">Pay Now</a>
                        <div class="price-wrap h5">
                            <span class="price-new">₹ <?php echo $enquiry_data[0]->course_total_fees; ?></span>
                        </div> <!-- price-wrap.// -->
                    </div> <!-- bottom-wrap.// -->
                </figure>
            </div> <!-- col // -->
        </div> <!-- row.// -->
    </div>
    <!--container.//-->
</body>

</html>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var SITEURL = "<?php echo base_url() ?>";
$('body').on('click', '.pay_now', function(e) {
    var totalAmount = $(this).attr("data-amount");
    var product_id = $(this).attr("data-id");
    var options = {
        "key": "<?php echo RAZORPAYKEY; ?>",
        "amount": (<?php echo $enquiry_data[0]->course_total_fees ?> * 100), // 2000 paise = INR 20
        "name": "IICTN",
        "description": "Payment",
        "image": "https://iictn.in/assets/img/logos/iictn_lms.png",
        "handler": function(response) {
            $.ajax({
                url : "<?php echo base_url();?>razorpaysuccess",
                type: 'post',
                dataType: 'json',
                data: {
                    razorpay_payment_id: response.razorpay_payment_id,
                    totalAmount: totalAmount,
                    product_id: product_id,
                    enquiry_number: <?php echo $enquiry_data[0]->enq_number; ?>
                },
                success: function(msg, textStatus, jqXHR) {
                    
                    window.location.href = "<?php echo base_url();?>razorthankyou/"+product_id;
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