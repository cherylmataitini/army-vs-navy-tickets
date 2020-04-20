<?php 
session_start();
require('config/config.php');
require('config/db.php');
//include('validation.php');



// validation vars
$validAddress = '';
$validDetails = '';


function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

if(isset($_SESSION['postage'])&& $_SESSION['complete_total']){
    //if(isset($_SESSION['shopping_cart'])){


    $postage = $_SESSION['postage'];
    $grand_total = $_SESSION['complete_total'];
}



include('inc/header.php');
?>

<div class="checkout-bg">
    <?php include('inc/navbar.php');?>
    <h1>Checkout</h1>
    <div class="goback-div">
    <a href="https://avnremetickets.com/buy-tickets.php" class="learn-btn" style="color: white">Go back</a>
    </div>

    <div class="checkout-container">

    <h3 class ="cart-title">Cart</h3>
    <form action="https://avnremetickets.com/charge.php" method="POST" name="checkout-form"> <!--FORM ACTION-->
    <table class="order-table">
    <tr>
        <th>Item</td>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>

    <tr>
        <?php foreach($_SESSION['shopping_cart'] as $key => $product):?>
        <tr>
            <td><?php echo $product['name'];?></td>
            <td>£<?php echo $product['price'];?></td>
            <td><?php echo $product['quantity'];?></td>
            <td>£<?php echo number_format($product['quantity'] * $product['price'], 2);?></td>
        <?php endforeach;?>
    </tr>

    <tr>
        <th colspan="3" align="right">Postage:</th>
        <th align="right" class="spaced-cell">£<?php echo number_format($postage,2)?></th>
    </tr>

    <tr>
        <th colspan="3" align="right">Grand Total:</th>
        <th align="right" class="spaced-cell">£<?php echo number_format($grand_total, 2)?></th>
    </tr>
</table>
<hr>
    
    <div class="personal-details">
    
        <h2>Your Details</h2>
        <?php if($validDetails != ''):?>
        <div class="validation"><?php echo $validDetails;?></div>
        <?php endif ?>

        <div class="block">
        <label>First Name</label>
        <input type="text" name="first" required>
        </div>

        <div class="block">
        <label>Last Name</label>
        <input type="text" name="last" required>
        </div>

        <div class="block">
        <label>Email</label>
        <input type="text" name="email" required>
        </div>

        <br>
        
        <h2>Shipping Details</h2>
        <div class="validation"><p><?php echo $validAddress?></p></div>
        
        <div class="block">
        <label>Line 1</label>
        <input type="text" name="street" placeholder="Street Address" required>
        </div>

        <div class="block">
        <label>Line 2</label>
        <input type="text" name="street2" placeholder="Street Address Line 2">
        </div>

        <div class="block">
        <label>City</label>
        <input type="text" name="city" placeholder="City/Town" required>
        </div>

        <div class="block">
        <label>County</label>
        <input type="text" name="county" placeholder="County" required>
        </div>
    
        <div class="block">
        <label>Postcode</label>
        <input type="text" name="postcode" placeholder="Postcode" required>
        </div><br>

        <h2>How To Pay</h2>
        
        <h4>Pay your Grand Total of £<?php echo number_format($grand_total, 2) ?> either via online banking or by cheque as described below. </h4>
        <h4>Orders submitted will be cross-referenced with payments received by AvN REME Admin. </h4>
        <br>

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
            <p>Pay via online banking to the account:</p><br>
                <div>
                    <p><strong>ARRC SP BN HQ</strong></p>
                    <p>ACCOUNT NUMBER: 11585612</p>
                    <p>SORTCODE: 16-19-26</p>
                    <p><strong>Use Reference: AvN20 & customer surname</p>
                </div>
            </div>

        </div><!--end of payment div-->

        <br>
        <button type="submit" name="submit" class="checkout-btn">Complete Order</button>
    

        
    </form>
    </div><!--end of personal details div-->
</div><!--end of form container div-->

<div class="data-protecc">
<p>The REME Army vs Navy (AvN) Project Officer is the Data Controller for the REME AvN customer database. The REME AvN 
    Project Officer is: SO3 Maint Ops | HQ ARRC | Imjin Barracks | Innisworth | GLOUCESTER | GL3 1HW </p>

<p><strong>Data Protection.</strong> The REME AvN Project Team uses customers' details in accordance with DP law, enabling the REME AvN team to provide you with REME AvN Tickets and REME wristbands. You are entitled under DP law to 
withdraw your consent in providing your information; however, this may affect our ability to provide you tickets and wristbands.</p>
<p></p>
<p><strong>Disclosure and Control of Data.</strong> We will NOT use your information to send emails about competitions, events or market research purposes; nor will we sell or disclose your personal information to third parties. You can request details of 
personal information which we hold about you under the Data Protection Act 1998; you may write to the REME AvN Project Officer - contact details above (email also at the bottom of the page).</p>
<p><strong>Security.</strong> We are committed to ensuring that your information is secure. In order to prevent unauthorised access or disclosure, we have put in place suitable procedures to safeguard and secure the information we collect.</p>
<p><strong>Data Retention and Deletion</strong> Your personal data will not be kept longer than is necessary to fulfil the objectives of the REME AvN Project. Your data will be retained for one month after the event and then deleted/discarded within GDPR guidelines.</p>

</div>


</div><!--end of main-bg div-->
<?php include('inc/footer.php');


