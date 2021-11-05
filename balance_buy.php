<!DOCTYPE html>
<html lang="en">
<?php  include "module/head.php"; ?>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php  include "module/navbar.php"; ?>
  <!-- /.navbar -->

  <?php include "module/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Balance</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <?php
///// 
 // Data get from link
 $getsymbol = $_GET['symbol'];
  
 
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>Currency</th>";
                echo "<th>price(ask)</th>";
                echo "<th>qty inc</th>";
                echo "<th>total if buy</th>";
                echo "</tr>";



 
          // select order # in stat
          // $sqloid = "SELECT * FROM stat";
          // $resultoid = $connection->query($sqloid);
         //  $oid = mysqli_fetch_array($resultoid);
          // $oidpush = $oid['botorderid']+1;

          $urlbase = "https://api.hitbtc.com/api/2/public/symbol/" . $getsymbol . "";
          $dataubase = json_decode(file_get_contents($urlbase), true);
          $base=$dataubase['baseCurrency']; // 'DOGE'btc
          $quote=$dataubase['quoteCurrency']; // doge'BTC'
          $qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol
          
//bid-ask price
$url = "https://api.hitbtc.com/api/2/public/ticker/". $getsymbol ."";
$dataticker = json_decode(file_get_contents($url), true);
$symbol=$dataticker['symbol'];
$bid=$dataticker['bid']; // buy price
$ask=$dataticker['ask']; // sell price

          $quantity0=1/$bid; // Usd balance divide by price buy
          $quantity3 =floor($quantity0 / $qtyinc) * $qtyinc;
      //    echo "Available divide by bid = X : ". $quantity0 ."<br>";  
    //      echo "( X / qty increment ) * qty increment : ". $quantity3 ."<br>";  

                echo "<tr>";
                echo "<td>" . $getsymbol . "</td>";
                echo "<td>" . $ask . "</td>";
                echo "<td>" . $qtyinc . "</td>";
                echo "<td>" . $qtyinc*$ask . "</td>";
                echo "</tr>";
 
                $ch = curl_init();
//do a post
curl_setopt($ch,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
curl_setopt($ch, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,"symbol=".$getsymbol."&side=buy&price=".$ask."&quantity=".$quantity3."&type=limit&timeInForce=GTC");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  //return the result of curl_exec,instead
  //of outputting it directly
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
//curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
$resulti=curl_exec($ch);
curl_close($ch);
$result=json_decode($resulti);
echo"<pre>";
print_r($result); 
if (!empty($result->error)) { } else {
  $ostatus = '1';
  $sqlinsert = "INSERT INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote) 
  VALUES ('', 
          '".$result->id."', 
          '".$result->clientOrderId."',
          '".$ostatus."',
          '".$result->status."',
          '".$result->symbol."',
          '".$result->side."',
          '".$result->type."',
          '".$result->timeInForce."',
          '".$result->quantity."',
          '".$result->cumQuantity."',
          '".$getPriceBuy."',
          '".$result->createdAt."',
          '".$qtyinc."',
          '".$base."',
          '".$quote."'); ";
// update order id
                // must be placed in the foreach array of insert
                $sqloidup = "UPDATE stat set botorderid=botorderid +1";
                $resultoid2 = $connection->query($sqloidup);
                $resultoid3 = $connection->query($sqlinsert);
}
 

         echo "</table>";
    

// Close connection
mysqli_close($connection);
 
 
?>

      <!-- /.default -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <!-- Main Footer -->
  <?php include "module/footer.php"; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

 
<?php include "module/script.php"; ?>

</body>
</html>
