<?php
 include "connect.php"; 
$sql = "INSERT INTO orders (symbol, price_buy, amount) VALUES ('" . $_POST['symbol'] ."', '" . $_POST['price_buy'] . "', '" . $_POST['amount'] . "')";

//if ($connection->query($sql) === TRUE) {
	if(mysqli_query($connection, $sql)){
  echo "Record added successfully";
} else {
  echo "Error: " . $sql . "<br>" . $connection->error;
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
$connection->close();


?>

<form action="insertdb.php" method="post">
    <p>
        <label for="firstName">Symbol:</label>
        <input type="text" name="symbol" id="Symbol">
    </p>
    <p>
        <label for="lastName">Price Buy:</label>
        <input type="text" name="price_buy" id="PriceBuy">
    </p>
    <p>
        <label for="emailAddress">Amount:</label>
        <input type="text" name="amount" id="Amount">
    </p>
    <input type="submit" value="Submit">
</form>


 





