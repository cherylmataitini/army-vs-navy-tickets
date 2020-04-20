<?php 
//$sessionPath = '../tmp';
//session_save_path($sessionPath);
session_start();
// check if form has been submitted

$product_ids = array();

//session_destroy();

// check if addtocart btn has been submitted
if(filter_input(INPUT_POST, 'add_to_cart')){
    // check if session shopping cart exists
    if(isset($_SESSION['shopping_cart'])){

        // keep track of how many products are in shopping cart
        $count = count($_SESSION['shopping_cart']);

        // create sequential array for matching array keys to product ids
        $product_ids = array_column($_SESSION['shopping_cart'], 'id');     

        // make sure product being added to cart doesn't already exist in shopping cart session variable
        if(!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
            $_SESSION['shopping_cart'][$count] = array(     # count how many products are in cart & use $count for next array key
                'id' => filter_input(INPUT_GET, 'id'),
                'name' => filter_input(INPUT_POST, 'name'),
                'price' => filter_input(INPUT_POST, 'price'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );
        } else {
            // just increase QUANTITY of the key in the cart - not re-adding the id
            // match array key to the id of the product being added to the cart
            for($i = 0; $i < count($product_ids); $i++){
                if($product_ids[$i] == filter_input(INPUT_GET, 'id')){      # if id submitted already exists in product id array
                    $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');     # adding 'quantity' onto existing quantity of $i key
                }
            }
        }

    } else { // if shopping cart doesnt exist create 1st product w/ array key 0
        // creating array using submitted form data starting from key 0 & fill it w/ values
        $_SESSION['shopping_cart'][0] = array(
            'id' => filter_input(INPUT_GET, 'id'),
            'name' => filter_input(INPUT_POST, 'name'),
            'price' => filter_input(INPUT_POST, 'price'),
            'quantity' => filter_input(INPUT_POST, 'quantity')
        );
    }
}

// action=delete for remove btn
if(filter_input(INPUT_GET, 'action') == 'delete'){
    // loop through all products in shopping cart until matches w/ GET id variable
    foreach($_SESSION['shopping_cart'] as $key => $product){
        if($product['id'] == filter_input(INPUT_GET, 'id')){
            // removes product from shopping cart when it matches w/ the GET id
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
    // reset session array keys so they match w/ product ids numeric array (makes sure right prodcts are being + and - to cart)
    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}


/*
pre_r($_SESSION);
function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}*/

?>


<?php // connect to database
require('config/db.php');
require('config/config.php');

$query = 'SELECT * FROM products ORDER by id ASC';

// execute sql query
$result = mysqli_query($connect, $query);


?>


<!-- start markup-->
<?php include('inc/header.php'); ?>

<div class="main-tickets-bg">
    <?php include('inc/navbar.php'); ?>
    <div class="ticket-header">
        <h1>Order Tickets/Wristbands</h1>
        <p>NOTE: Customers may place an order for tickets/wristbands here. Payment for orders will NOT be taken through this website however, payment instructions will be provided at checkout. All orders will be cross-referenced with payments that have been received by the AvN REME Officer.</p>
        <p style="color:#be0000;">Each wristband can only be purchased with a ticket.</p>
    </div>


    <div class="form-container">
        <?php
            if($result):
                if(mysqli_num_fields($result)>0):
                while($product = mysqli_fetch_assoc($result)):
                    # accessing product data & displaying
                    ?>
                    <div>
                        <form action="https://avnremetickets.com/buy-tickets.php?action=add&id=<?php echo $product['id']; ?>" method="POST">
                            <div class="product">
                                <h4><?php echo $product['name'];?></h4>
                                <h4>£<?php echo $product['price'];?></h4>
                                <!--to access product name and price inside of the variables once form is submitted-->
                                <input type="text" name="quantity" value="1">
                                <input type="hidden" name="name" value="<?php echo $product['name'];?>">
                                <input type="hidden" name="price" value="<?php echo $product['price'];?>">
                                <input type="submit" name="add_to_cart" value="Add" class="learn-btn">
                            </div>
                        </form>
                    </div>
                <?php    
                endwhile;
            endif;
        endif;
        ?>
        <div class="product-table-div" style="overflow-x: auto;"><!--cart table-->
        <table class="table" style=" overflow-x:auto;">
            <tr><th colspan="5" class="order-bg"><h3>Order Details</h3></th></tr>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>
            <?php
            if(!empty($_SESSION['shopping_cart'])):

                $total = 0; // creating to use when calculating grand total

                foreach($_SESSION['shopping_cart'] as $key => $product):
            ?>
            <tr>
                <td><?php echo $product['name'];?></td>
                <td><?php echo $product['quantity'];?></td>
                <td><?php echo $product['price'];?></td>
                <td><?php echo number_format($product['quantity'] * $product['price'], 2);?></td>
                <td>
                    <a href="https://avnremetickets.com/buy-tickets.php?action=delete&id=<?php echo $product['id'];?>"><div class="remove-btn">Remove<div></a>
                </td>
            </tr>
            <?php 
                    $total = $total + ($product['quantity'] * $product['price']);
                endforeach;
            ?>
            <!--calculate postage-->
            <?php  
            $cartSum = 0;       // define these outside the foreach loop
            $postage = 0;
                if(!empty($_SESSION['shopping_cart'])){ 
                    foreach($_SESSION['shopping_cart'] as $key => $product){
                    
                    $cartSum += $product['quantity'];
                    
                    if($cartSum <=10){
                        $postage = 3.00;}
                    if($cartSum >=11 && $cartSum < 30){
                        $postage = 4.50;}
                    if($cartSum >=30 && $cartSum < 50){
                        $postage = 5.50;}
                    if($cartSum >=50){
                        $postage = 6.50;}
                    }
                }
                
                $complete_total = $total + $postage;
            ?>

            <tr><!--postage-->
            <td colspan="3" align="right" class="spaced-cell">Postage</td>
            <td align="right" class="spaced-cell">£<?php echo number_format($postage, 2)?></td>
            <td></td>
            </tr>
            <tr><!--Grand total-->
                <td colspan="3" align="right" class="spaced-cell">Total</td>
                <td align="right"class="spaced-cell">£<?php echo number_format($complete_total,2); ?></td>
                <td></td>
            </tr> 
            <tr>

                <td colspan="5">
                    
                </td>
            </tr>
        <?php 
        endif;
        ?>
        </table>
        <?php 
            if(isset($_SESSION['shopping_cart'])):
            if(count($_SESSION['shopping_cart']) > 0):
        ?>
           
            <a href="https://avnremetickets.com/checkout" class="checkout-btn" style="color:white">Checkout</a>
        <?php endif; endif; ?>

        </div><!--end of table div-->

    </div> <!--end of form-container-->
    

</div>

<?php include('inc/footer.php');
//echo $postage; echo $complete_total;
if(isset($postage)){
    $_SESSION['postage'] = $postage;
}
if(isset($complete_total)){
    $_SESSION['complete_total'] = $complete_total;
}
/*$postage = $_SESSION['postage'];
$complete_total = $_SESSION['complete_total'];*/

// TEST SESSION
/*
$sessionPath = 'C:\xampp\tmp';

$msg = is_readable($sessionPath) ? $msg = 'Path is readable' : $msg = 'Path is NOT readable';
echo $msg . '<br>';

$msg2 = is_writable($sessionPath) ? $msg2 = 'Path is writable' : $msg2 = 'Path is NOT writable';
echo $msg2 . '<br>';

$msg3 = is_executable($sessionPath) ? $msg3 = 'Path is executable' : $msg3 = 'Path is NOT executable';
echo $msg3 . '<br>';

phpinfo();*/

?>