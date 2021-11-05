<?php
            //////////////////
//////////// TICKER daily call ////////////////
           //////////////////
include "module/connect.php";
  
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if (!$conn) {
  die('Could not connect to database.'); } echo 'Connected successfully to the database';
$sqldel = "TRUNCATE table `ticker`";
if ($connection->query($sqldel) === TRUE) { echo "<br>Record deleted successfully"; } else { echo "<br>Error deleting record: " . $connection->error; }

$response = file_get_contents('https://api.hitbtc.com/api/2/public/ticker/');
$response = json_decode($response);

$str_to_concat = "INSERT IGNORE INTO `ticker_daily` (`symbol`, `ask`) 
VALUES";

foreach($response as $item) {
  $str_to_concat = $str_to_concat."('$item->symbol' , '$item->ask'),";
  
}
// We are removing last char from string, because its comma ` , `
$str_to_concat = substr_replace($str_to_concat ,"", -1);
$sqlt = $str_to_concat;

// Making an insertion into the database
if(mysqli_query($conn, $sqlt)){
  echo "<br>Tickers daily Records added successfully.<br>";
} else{
  echo "<br>ERROR: Could not able to execute $conn. ",mysqli_error($conn);
}
 

mysqli_close($conn);
mysqli_close($connection);

?>