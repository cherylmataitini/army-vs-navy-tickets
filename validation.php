<?php
$validAddress = '';
$validDetails = '';


if(filter_has_var(INPUT_POST, 'submit')){
    #    echo 'Submitted';
    // get form data
    $first = htmlspecialchars($_POST['first']);
    $last = htmlspecialchars($_POST['last']);
    $email = htmlspecialchars($_POST['email']);
    
    // check required fields
    if(!empty($email) && !empty($firstname) && !empty($lastname)){
        // passed
        //check email
        if(filter_var($email,FILTER_VALIDATE_EMAIL)=== false){
            //email validate failed
            $validDetails = '* Please enter a valid email';
        }
    } else {
        $validDetails = '*Please fill in all the fields';
    }
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
}



if(filter_has_var(INPUT_POST, 'submit')){
    foreach($address as $key => $value){
        if(!empty($value)){
            if(preg_match("/^[a-zA-Z]{1,2}([0-9]{1,2}|[0-9][a-zA-Z])\s*[0-9][a-zA-Z]{2}$/", $postcode) === 0){
                $validAddress = '*Please enter a valid address';
            }
        } else {
            $validAddress = 'Please fill in all the fields';
        }
    }   
}



?>