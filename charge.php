<?php
session_start();
require('config/config.php');
require('config/db.php');
//include('validation.php');



function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

if(filter_has_var(INPUT_POST, 'submit')){
    $first =  htmlspecialchars($_POST['first']);
    $last =  htmlspecialchars($_POST['last']);
    $email =  htmlspecialchars($_POST['email']);
}

if(isset($_POST['submit'])){
    $address = array(
        'street' => htmlspecialchars($_POST['street']),
        'street2' => htmlspecialchars($_POST['street2']),
        'city' => htmlspecialchars($_POST['city']),
        'county' => htmlspecialchars($_POST['county']),
        'postcode' => htmlspecialchars($_POST['postcode']),
    );

    $postcode = htmlspecialchars($_POST['postcode']);
    $postage = $_SESSION['postage'];
    $grand_total = $_SESSION['complete_total'];
 
$address_string =
htmlspecialchars($_POST['street']). ' '.
htmlspecialchars($_POST['street2']). ' '.
htmlspecialchars($_POST['city']). ' '.
htmlspecialchars($_POST['county']). ' '.
htmlspecialchars($_POST['postcode']). ' ';
}




foreach($_SESSION['shopping_cart'] as $key => $product){
     $order =
     $product['name']. ' '.
     $price = $product['price']. ' '.
     $quantity = $product['quantity']. ' '.
     $total = number_format($product['quantity'] * $product['price'], 2);
 }

 $serialize_cart =  base64_encode(serialize($_SESSION['shopping_cart']));


$sql =
"INSERT INTO user_details (complete_order, address, postage, grand_total, first, last, email) VALUES(
    '$serialize_cart',
    '$address_string',
    '$postage',
    '$grand_total',
    '$first',
    '$last',
    '$email'
)";


$result = mysqli_query($connect, $sql );

/*

pre_r($address);

pre_r($_SESSION['shopping_cart']);

//echo(unserialize($serialize_cart)). '<br>';
echo($postage) .'<br>';
echo($grand_total).'<br>';
echo $address_string;

*/

header('location: https://avnremetickets.com/success');

