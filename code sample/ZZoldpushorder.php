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
            <h1><?php echo $_GET['side']; ?> Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Making your Order</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
       
<?php
include "connect.php";
  
// Data get from link
$getId = $_GET['id'];
$getoId = $_GET['oid'];
$getQty = $_GET['quantity'];
$getSide = $_GET['side'];
$getType = $_GET['type'];
$getPriceBuy = $_GET['price'];
$sts = $_GET['symbol'];

// select order # in stat
$sqloid = "SELECT * FROM stat";
$resultoid = $connection->query($sqloid);
$oid = mysqli_fetch_array($resultoid);
$oidpush = $oid['botorderid']+1;


 
//currency base info
$urlbase = "https://api.hitbtc.com/api/2/public/symbol/". $sts ."";
$dataubase = json_decode(file_get_contents($urlbase), true);
$base=$dataubase['baseCurrency']; // 'DOGE'btc
$quote=$dataubase['quoteCurrency']; // doge'BTC'
$qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol

echo "Symbol : ".$sts."<br>";     //  DOGEBTC
echo "Base : ".$base."<br>";      //  DOGE
echo "Quote :".$quote."<br>";     //  BTC
echo "Qty Inc :".$qtyinc."<br>";  //   increment - order min 
echo "Order #: ".$oidpush."<br>"; //  # of order maded 
 
//bid-ask price
$url = "https://api.hitbtc.com/api/2/public/ticker/". $sts ."";
$dataticker = json_decode(file_get_contents($url), true);
$symbol=$dataticker['symbol'];
$bid=$dataticker['bid']; // buy price
$ask=$dataticker['ask']; // sell price

// set order # and status depend if copy or sell
if( $_GET['side'] =='sell'){
   $pricefail = $dataticker['bid']; // buy price
}
if( $_GET['side'] =='buy'){
   $pricefail = $dataticker['ask']; // buy price
}

// buy and sell price
echo "Bid : ".$bid."<br>"; 
echo "Ask :".$ask."<br>";

echo "Buy Price :".$getPriceBuy."<br>";
     
//BALANCE from our database
$sqlbal1 = "SELECT * FROM balance where currency='$quote'";
$result123 = $connection->query($sqlbal1);
if ($result123->num_rows > 0) {
    // output data of each row
    while($row = $result123->fetch_assoc()) {
      
//order on
// data to push to the API and database
$symbol=$sts;
$side =$getSide;
$type =$getType;
$price=$getPriceBuy;
$quantity=$getQty;
$timeInForce= 'GTC'; 
$date = Date("Y-m-d H:i:s");
  
$ch = curl_init();
//do a post
curl_setopt($ch,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
curl_setopt($ch, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,"clientOrderId=$oidpush&symbol=$symbol&side=$side&price=$price&quantity=$quantity&type=$type&timeInForce=$timeInForce");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  //return the result of curl_exec,instead
  //of outputting it directly
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
//curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
$result=curl_exec($ch);
curl_close($ch);
$result=json_decode($result);
echo"<pre>";
print_r($result);
//order end
 
if( $_GET['side'] =='sell'){
  if ($result->status=='new') {
    $ostatus = '1';
  } elseif ($result->status=='partiallyFilled') {
    $ostatus = '1';
  } elseif ($result->status=='filled') {
    $ostatus = '2';
  }
 }else{
    $ostatus = '1';
 }


if (!empty($result->error)) { } else { 

 /////
//insert order
// this !empty need cause [status] => new - order placed but no trade report in json result
// will be resolved with the partially filled update add-on
  if (!empty($result->tradesReport)) {
    foreach($result->tradesReport as $report){
    $sqlinsert = "INSERT INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, price, fee, timestamp, qtyinc, base, quote) 
    VALUES ('".$report->id."', 
            '".$result->id."',
            '".$result->clientOrderId."',
            '".$ostatus."',
            '".$result->status."',
            '".$result->symbol."',
            '".$result->side."',
            '".$result->type."',
            '".$result->timeInForce."',
            '".$result->quantity."',
            '".$report->price."',
            '".$report->fee."',
            '".$report->timestamp."',
            '".$qtyinc."',
            '".$base."',
            '".$quote."'); ";
// update order id
                  // must be placed in the foreach array of insert
                  $sqloid = "UPDATE stat set botorderid=botorderid +1";
                  $resultoid2 = $connection->query($sqloid);
                  $resultoid3 = $connection->query($sqlinsert);
                }
              } else {
                //Format fee (Price + Makers Fee ) 
                if( $_GET['side'] =='sell'){
                $fee1=$getPriceBuy*2.5/1000;  // makers fee      
                $fee=number_format($fee1,11);  // format string
                                          }
                if( $_GET['side'] =='buy'){
                $fee1=$getPriceBuy*1/1000;  // makers fee      
                $fee=number_format($fee1,11);  // format string
                                           }
                  // in case of Array trade report fail
                  $sqlinsert = "INSERT INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, price, fee, timestamp, qtyinc, base, quote) 
                  VALUES ('".$result->clientOrderId."', 
                          '".$result->id."',
                         '".$result->clientOrderId."',
                         '".$ostatus."',
                         '".$result->status."',
                          '".$result->symbol."',
                          '".$result->side."',
                          '".$result->type."',
                          '".$result->timeInForce."',
                          '".$result->quantity."',
                          '".$getPriceBuy."', 
                          '".$fee."',   
                          '".$result->createdAt."',
                          '".$qtyinc."',
                          '".$base."',
                          '".$quote."'); ";
                   // update order id
                   $sqloid = "UPDATE stat set botorderid=botorderid +1";
                   $resultoid2 = $connection->query($sqloid);
                  $resultoid3 = $connection->query($sqlinsert);
                }
              }




}
 


if (!empty($result->error)) { } else { 
   

 ///// update some date if sell order
if( $_GET['side'] =='sell'){
 
  $sqlup2 = "UPDATE getorders set soldby='$oidpush' WHERE id='$getoId'";
  $resultoid5 = $connection->query($sqlup2);
}
}




} else {
    echo "0 results balance low please fund ".$quote;
}
 
    
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
