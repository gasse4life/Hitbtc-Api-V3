<?php
 include "connect.php"; 
   
$curlSecondHandler = curl_init();
curl_setopt_array($curlSecondHandler, [
    CURLOPT_URL => 'https://api.hitbtc.com/api/2/history/trades?sort=DESC&by=id&limit=500',    // max limit = 1000
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Authorization: Basic ' . base64_encode($userName . ':' . $password)],
]);

$response = curl_exec($curlSecondHandler);
curl_close($curlSecondHandler);
$array =  json_decode($response, true);  //Convert JSON String into PHP Array
         
echo $return;
          foreach($array as $row) //Extract the Array Values by using Foreach Loop
          {
            
          $query .= "INSERT IGNORE INTO getorders(id, clientOrderId, orderId, symbol, side, quantity, price, fee, timestamp, taker) 
          VALUES ('".$row["id"]."', 
                  '".$row["clientOrderId"]."',
                  '".$row["orderId"]."',
                  '".$row["symbol"]."',
                  '".$row["side"]."',
                  '".$row["quantity"]."',
                  '".$row["price"]."',
                  '".$row["fee"]."',
                  '".$row["timestamp"]."',
                  '".$row["taker"]."'); ";  // Make Multiple Insert Query 
                  
          }

          if(mysqli_multi_query($connection, $query)) //Run Mutliple Insert Query
          {
    
     echo 'New orders imported in database<br />';

    } else { echo "Error importing orders record into database : " . $connection->error;
           } 
 
?>
 

          
     
 
