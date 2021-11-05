<?php

  include "module/connect.php"; 
  $clientOrderId = $_GET['clientOrderId'];
  
  $cancel = curl_init();
//do a post
curl_setopt($cancel,CURLOPT_URL,"https://api.hitbtc.com/api/2/order/$clientOrderId");
curl_setopt($cancel, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
//curl_setopt($cancel, CURLOPT_POST,1);
curl_setopt($cancel, CURLOPT_CUSTOMREQUEST, "DELETE");
//curl_setopt($cancel,CURLOPT_POSTFIELDS,"clientOrderId=$clientOrderId");
curl_setopt($cancel, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
  //return the result of curl_exec,instead
  //of outputting it directly
curl_setopt($cancel, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($cancel, CURLOPT_HTTPHEADER, array('accept: application/json'));
//curl_setopt($cancel,CURLOPT_HTTPHEADER,$header);
$resultc=curl_exec($cancel);
curl_close($cancel);
$resultc=json_decode($resultc);
echo"<pre>";
print_r($resultc);
//order end

$sqlupcancel = "UPDATE getorders set astatus='canceled', ostatus='2' WHERE clientOrderId='".$clientOrderId."'";
$perform = mysqli_query($connection, $sqlupcancel);
  ?>