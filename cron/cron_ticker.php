<?php
            ////////////////// 
//////////// TICKER call ////////////////   
           //////////////////    

include "connect.php";
  
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if (!$conn) {
  die('Could not connect to database.'); } echo 'Connected successfully to the database';
$sqldel = "TRUNCATE table `ticker`";
if ($connection->query($sqldel) === TRUE) { echo "<br>Record deleted successfully"; } else { echo "<br>Error deleting record: " . $connection->error; }

$response = file_get_contents('https://api.hitbtc.com/api/2/public/ticker/');
$response = json_decode($response);

$str_to_concat = "INSERT INTO `ticker` (`symbol`, `ask`, `bid`, `last`, `low`, `high`, `open`, `volume`, `volumeQuote`, `timestamp`) 
VALUES";

foreach($response as $item) {
  $str_to_concat = $str_to_concat."('$item->symbol' , '$item->ask', '$item->bid', '$item->last', '$item->low', '$item->high', '$item->open', '$item->volume','$item->volumeQuote', '$item->timestamp'),";
  
}
// We are removing last char from string, because its comma ` , `
$str_to_concat = substr_replace($str_to_concat ,"", -1);
$sqlt = $str_to_concat;

// Making an insertion into the database
if(mysqli_query($conn, $sqlt)){
  echo "<br>Tickers Records added successfully.<br>";
} else{
  echo "<br>ERROR: Could not able to execute $conn. ",mysqli_error($conn);
}
$sqlupcron = "UPDATE cron_time SET time  = NOW(), numbera=numbera +1 WHERE cron_name='ticker'";
$resultoidcron = $connection->query($sqlupcron);

mysqli_close($conn);
mysqli_close($connection);
 
?>