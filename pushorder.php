   <!-- v2.0.1 -->

   <?php   include "module/head.php"; ?>


<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

 
  <?php   include "module/navbar.php"; ?>
  <?php include "module/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Push Orders</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Push Orders</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
         
        <!-- /.row -->
 

        <!-- Main row -->
        <!-- Main row -->
        <!-- Main row -->
        <!-- Main row -->
        <!-- Main row -->
        <!-- Main row -->
  
      <!-- Default box -->
       
<?php
   
   // Data get from link
   $getId = $_GET['id'];
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
   $sqlbal1 = "SELECT * FROM balance where currency='USD'";
   $result123 = $connection->query($sqlbal1);
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
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
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
    }elseif( $_GET['side'] =='buy'){
     if ($result->status=='new') {
       $ostatus = '1';
     } elseif ($result->status=='partiallyFilled') {
       $ostatus = '1';
     } elseif ($result->status=='filled') {
       $ostatus = '1';
     } }
   
     
   if (!empty($result->error)) { } else { 
   
    /////
   //insert order
   // this !empty need cause [status] => new - order placed but no trade report in json result
   // will be resolved with the partially filled update add-on
   
    
       
       $sqlinsert = "INSERT IGNORE INTO getorders(howto, id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote) 
       VALUES ('manual', 
               '', 
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
    
   
   }
    
   
   
   if (!empty($result->error)) { } else { 
      ///// update some date if sell order
   if( $_GET['side'] =='sell'){
     $sqlup2 = "UPDATE getorders set soldby='$oidpush' WHERE clientOrderId='$getId'";
     $sqlup3 = "UPDATE getorders set soldfor='$getId' WHERE clientOrderId='$result->clientOrderId'";
     if ($result->status=='filled') {
        $sqlup4 = "UPDATE getorders set ostatus='2' WHERE clientOrderId='$getId'";
       $resultoid7 = $connection->query($sqlup4);
     }
    $resultoid5 = $connection->query($sqlup2);
   $resultoid6 = $connection->query($sqlup3);
   }
    
   
   }
    
    
       
   ?>
         <!-- /.default -->
    
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include "module/footer.php"; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
