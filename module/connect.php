<?php
 
/*
    $connection = mysqli_connect('localhost', 'u802938324_usr', 'D3v@5t4t0r');
    if (!$connection){
    die("Database Connection Failed");
    }
    $select_db = mysqli_select_db($connection, 'u802938324_bot');
    if (!$select_db){
        die("Database Selection Failed" . mysqli_error($connection));
    }

    // Substitute the values with the ones for your database.
    $dbhost = 'localhost';
    $dbuser = 'u802938324_usr';
    $dbpass = 'D3v@5t4t0r';
    $db = 'u802938324_bot';
   */
     
     $connection = mysqli_connect('localhost', 'root', '');
     if (!$connection){
         die("Database Connection Failed");
     }
     $select_db = mysqli_select_db($connection, 'bot');
     if (!$select_db){
         die("Database Selection Failed" . mysqli_error($connection));
     }
     
      // Substitute the values with the ones for your database.
     $dbhost = 'localhost';
     $dbuser = 'root';
     $dbpass = '';
     $db = 'bot';

// HitBtc Api username as public key && password as secret key
$userName = 'gg7_IaCO-e4_K2Ar4u3APwjTiT01qQJV';
$password = 'HRiwLvKK7bN2aW_qeICYgmQXJd8fL1jx';
  
?>