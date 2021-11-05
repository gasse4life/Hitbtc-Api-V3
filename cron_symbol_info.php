<?php
            //////////////////
            //////////////////
            //////////////////
            //  UPDATE MODE INSTEAD INSERT INTO  or truncate before insert
            //////////////////
            //////////////////
//////////// symbol info call ////////////////
           //////////////////
include "module/connect.php";
  
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if (!$conn) {
  die('Could not connect to database.'); } echo 'Connected successfully to the database';
$sqldel = "TRUNCATE table `symbol`";
if ($connection->query($sqldel) === TRUE) { echo "<br>Record deleted successfully"; } else { echo "<br>Error deleting record: " . $connection->error; }

$response = file_get_contents('https://api.hitbtc.com/api/2/public/symbol/');
$response = json_decode($response);

$str_to_concat = "INSERT IGNORE INTO `symbol` (`id`, `baseCurrency`, `quoteCurrency`, `quantityIncrement`, `tickSize`, `takeLiquidityRate`, `provideLiquidityRate`, `feeCurrency`) 
VALUES";

foreach($response as $item) {
  $str_to_concat = $str_to_concat."('$item->id' , '$item->baseCurrency', '$item->quoteCurrency', '$item->quantityIncrement', '$item->tickSize', '$item->takeLiquidityRate','$item->provideLiquidityRate', '$item->feeCurrency'),";
  
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

 
  mysqli_close($connection);
mysqli_close($conn);

?>