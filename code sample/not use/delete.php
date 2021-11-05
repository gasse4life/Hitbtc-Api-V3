<?php
 include "connect.php"; 

$id = $_GET['id']; // get id through query string

          $sql123 = "DELETE from getorders WHERE `clientOrderId` = $id";

if ($connection->query($sql123) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleted record: " . $connection->error;
} 