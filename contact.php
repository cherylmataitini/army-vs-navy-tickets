
<?php
// Message vars
$msg = '';
$msgClass = '';

    // check for submit
if(filter_has_var(INPUT_POST, 'submit')){
    #    echo 'Submitted';
    // get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // check required fields
    if(!empty($email) && !empty($name) && !empty($message)){
        // passed
        //check email
        if(filter_var($email,FILTER_VALIDATE_EMAIL)=== false){
            //email validate failed
            $msg = '* Please enter a valid email';
            $msgClass= 'alert-danger';
        } else {
            // email passed
            // set up recipient email
            $toEmail = 'avn-reme-tickets-wristbands@outlook.com';
            $subject = 'Contact Request from '.$name;
            $body = '<h2>Contact Request</h2>
            <h4>Name</h4><p>'.$name.'</p>
            <h4>Email</h4><p>'.$email.'</p>
            <h4>Message</h4><p>'.$message.'</p>
            ';

            // set email headers
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8" ."\r\n";
            
            // additional headers
            $headers .= "From: " .$name. "<".$email.">". "\r\n";

            //mail function
            if(mail($toEmail, $subject, $body, $headers)){
                // email sent
                $msg = 'Success! Your email has been sent';
                $msgClass = 'alert-success';
            } else {
                $msg = 'Your email was not sent';
                $msgClass = 'alert-danger';
            }
        }
    } else{
        // failed
        $msg = '* Please fill in all fields';
        $msgClass = 'alert-danger';         // alert-danger in bootstrap makes text red
    }
}
?>


<?php include("inc/header.php");?>



<div class="background-contact">
<?php include("inc/navbar.php");?>
<div class="main-form-div">  
    <div class="alert-container">
        <?php if($msg != ''): ?>
        <div class="alert <?php echo $msgClass; ?>"><?php echo $msg ?></div>
        <?php endif ?>
    </div>
    
    <h2>Contact the REME AvN Project Officer for any queries</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <div class="form-field">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : '' ?>">    
        </div>
        <div class="form-field"> 
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : '' ?>">
        </div>
        <div class="form-field">
            <label>Message</label>
            <textarea type="text" name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : '' ?></textarea>
        </div>
        <div class="button-holder">
        <button type="submit" name="submit" class="learn-btn">Submit</button>
        </div>
    </form>
</div> <!--end of main-form-div-->
</div> 
<?php include('inc/footer.php');
