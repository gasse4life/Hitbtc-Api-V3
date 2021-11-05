<?php 
 include "connect.php"; 
 $date = Date("Y-m-d H:i");


 #########
  // AutoSellCheckup
  // look up if an order is ready to buy (autosell ON)
$sql = "SELECT * FROM cron_time where cron_name='sellcheck'";
$resultact = mysqli_query($connection, $sql);
$cron = mysqli_fetch_array($resultact);
//echo "Auto Sell Checkup<br>";
//echo "time now " . $date . "<br>";
//echo "next cron " . $cron['time'] . "<br>";
 if($date>=$cron['time']) {
    include "autosellcheckup.php";
    //echo "OK<br>";
//i substract 3 second of time due to cron job execute time
    $sqlupcron = "UPDATE cron_time SET time  = ADDTIME(NOW(), 57) WHERE cron_name='sellcheck'";
    $resultoidcron = $connection->query($sqlupcron);
 }else{ echo"not now for auto sell check up - pls wait <br>";}
 ###########
 mysqli_free_result($resultact);

  #########
  // AutoSell
  // sell orders when rdytosell='1'
  $sql2 = "SELECT * FROM cron_time where cron_name='sellready'";
  $resultact2 = mysqli_query($connection, $sql2);
  $cron2 = mysqli_fetch_array($resultact2);
  //echo "Auto Sell Checkup<br>";
  //echo "time now " . $date . "<br>";
  //echo "next cron " . $cron2['time'] . "<br>";
   if($date>=$cron2['time']) {
       include "autosell.php";
      //echo "OK<br>";
  //i substract 3 second of time due to cron job execute time
      $sqlupcron2 = "UPDATE cron_time SET time  = ADDTIME(NOW(), 57) WHERE cron_name='sellready'";
      $resultoidcron2 = $connection->query($sqlupcron2);
   }else{ echo"not now for auto sell - pls wait <br>";}

   mysqli_free_result($resultact2);
   ###########
  
   
   




   mysqli_close($connection);


 

?>
