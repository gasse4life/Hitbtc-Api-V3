 
<?php
             //////////////////   <!-- v2.0.1 -->

//////////// BALANCE call ////////////////
           //////////////////
 include "connect.php"; 
  if (!$connection) {
  die('Could not connect to database.');
}
 //////////////////
$sqlupcronw = "UPDATE cron_time SET time  = NOW(), numbera=numbera +1 WHERE cron_name='balance'";
 
if ($connection->query($sqlupcronw))  
{
echo 'OK stat updated....<br />';
}else {
echo "Error updating stat record into database : " . $connection->error;

}                   
/////////////////////


 $ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.hitbtc.com/api/2/trading/balance',
    CURLOPT_RETURNTRANSFER => true, 
    CURLOPT_SSL_VERIFYHOST => 2, 
    CURLOPT_SSL_VERIFYPEER => false, 
    CURLOPT_HTTPHEADER => [
        'Authorization: Basic ' . base64_encode($userName . ':' . $password)
    ],
]);

$response = curl_exec($ch);
curl_close($ch);
 $array =  json_decode($response, true);  //Convert JSON String into PHP Array
 //print_r($array);
 
////////////////////////////////////////////     
 if (!empty($array->error)) {
      foreach($array as $item) { 
      $errorbbt = "INSERT INTO error(seq, error) 
      VALUES ('', 
      'ERROR: Could not able to execute. Buying Bot 1 <br>'".$symbol."'<br>'".$item->code."'<br>'".$item->message."'<br>')";                    
      
      $resultbbt = $connection->query($errorbbt);
      mysqli_free_result($resultbbt);
  }

    } else {
      $sql123 = "TRUNCATE TABLE balance  ";
      $blablba = $connection->query($sql123);
    foreach($array as $rowb) //Extract the Array Values by using Foreach Loop
    {
      
    $query .= "INSERT INTO balance(currency, available, reserved) VALUES ('".$rowb["currency"]."', '".$rowb["available"]."','".$rowb["reserved"]."'); ";  // Make Multiple Insert Query 

    }
    
    if(mysqli_multi_query($connection, $query)) //Run Mutliple Insert Query
{
echo 'Balance Updated<br />';
}else {
echo "Error importing Balance record into database : " . $connection->error;

} 
mysqli_free_result($query);

     } 
//////////////////////////////////////////




  
  mysqli_close($connection);
  

?>