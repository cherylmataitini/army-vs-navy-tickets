<?php
session_start();
//echo('Success!'); 

require('config/db.php');
require('config/config.php');



include('inc/header.php');

?>

<div class="main-success">
<?php include('inc/navbar.php');?> 

<div class="success-inner">
    <div class="success-headings">
    <h1>Success!</h1>
    <h3>Your order has been submitted.</h3>
    <h3>Make sure to pay your Grand Total of £<?php echo number_format($_SESSION['complete_total'], 2)?> 
    either by cheque or online banking (details below) if you have not done so already. </h3>
    <h4>Your order will be cross-referenced with payments that have been received by the AvN REME Team.</h4>
    </div>

    <div class="payment-div">
                <div class="cheque-div">
                <p><strong>Cheques payable to ARRC SP BN HQ</strong></p>
                <p>Send cheques to:</p> <br>
                    <div>
                        <p>CAPT MATAITINI</p>
                        <p>SP DIV</p>
                        <p>ARRC HQ</p>
                        <p>IMJIN BARRACKS</p>
                        <p>INNISWORTH</p>
                        <p>GL3 1HW</p>
                    </div>
                </div>

                <div class="bank-div">
                <p><strong>Pay via online banking to the account:</strong></p><br>
                    <div>
                        <p>ARRC SP BN HQ</p>
                        <p>ACCOUNT NUMBER: 11585612</p>
                        <p>SORTCODE: 16-19-26</p>
                        <p>Use Reference: AvN20 & customer surname</p>
                    </div>
                </div>

    </div><!--end of payment div-->
</div>
    
</div><!--end of main-success-->

<?php

/*
unset($_SESSION['shopping_cart']);
unset($_SESSION['complete_total']);
unset($_SESSION['postage']);
session_destroy();*/
include('inc/footer.php');?>

