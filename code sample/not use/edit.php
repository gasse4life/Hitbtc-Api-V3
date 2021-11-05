<?php
 include "connect.php"; 

// php code to Update data from mysql database Table
$id = $_GET['id']; // get id through query string
$symbol = $_GET['symbol'];
$price_buy = $_GET['price_buy'];
$amount = $_GET['amount'];

if(isset($_POST['update']))
{
   // get values form input text and number
      $id = $_POST['id'];
    $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $bname = $_POST['bname'];
           
   // mysql query to Update data
   $query = "UPDATE `orders` SET `symbol`='".$fname."',`price_buy`='".$lname."',`amount`= $bname WHERE `id` = $id";
   $result = mysqli_query($connection, $query);
   
   mysqli_close($connection);
   header("location:orders.php"); // redirects to all records page
        exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form action="edit.php" method="post">
            ID To Update:  <input type="hidden" name="id" value="<?php echo $id; ?>" required><?php echo $id; ?> <br><br>
            Symbol:<input type="text" name="fname" value="<?php echo $symbol; ?>" required><br><br>
            Price Buy:<input type="text" name="lname" value="<?php echo $price_buy; ?>" required><br><br>
            Amount:<input type="number" name="bname" value="<?php echo $amount; ?>" required><br><br>
            <input type="submit" name="update" value="Update Data">
        </form>
    </body>
</html>