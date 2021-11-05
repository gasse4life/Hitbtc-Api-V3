<?php
 include "connect.php"; 
  if (!$connection) {
  die('Could not connect to database.');
}
 
 
 $curlSecondHandler = curl_init();

curl_setopt_array($curlSecondHandler, [
    CURLOPT_URL => 'https://api.hitbtc.com/api/2/trading/balance',
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_HTTPHEADER => [
        'Authorization: Basic ' . base64_encode($userName . ':' . $password)
    ],
]);

$response = curl_exec($curlSecondHandler);
curl_close($curlSecondHandler);
 $array =  json_decode($response, true);  //Convert JSON String into PHP Array
         
 $sql123 = "TRUNCATE TABLE balance  ";
 if ($connection->query($sql123) === TRUE) {
    echo "&nbsp;"; // Record deleted successfully
    } else {
    echo "Error deleting record: " . $connection->error;
    } 
echo $return;
          foreach($array as $row) //Extract the Array Values by using Foreach Loop
          {
            
          $query .= "INSERT INTO balance(currency, available, reserved) VALUES ('".$row["currency"]."', '".$row["available"]."','".$row["reserved"]."'); ";  // Make Multiple Insert Query 

          }
          
          if(mysqli_multi_query($connection, $query)) //Run Mutliple Insert Query
    {
     echo 'Balance Updated<br />';
      }else {
    echo "Error importing Balance record into database : " . $connection->error;
} 

?>


          
     
 
