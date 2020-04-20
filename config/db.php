<?php 
// connect to database


$connect = mysqli_connect($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_NAME"]);

// check connection
if(mysqli_connect_errno()){
    // if true connection failed
    echo 'Failed to connect to MySQL '. mysqli_connect_errno();     // see what error it is
}