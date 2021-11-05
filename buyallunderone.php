   <!-- v2.0.1 -->

   <?php   include "module/head.php"; ?>


<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
 

 
  <?php   include "module/navbar.php"; ?>
  <?php include "module/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Buy min qty of all coin under 1$</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Buy min qty of all coin under 1$</li>
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
 ///// 
 // Data get from link
 $getmaxr = $_GET['maxr'];
 $getminr = $_GET['minr'];
 
 // Attempt select query execution
//$sql = "SELECT * FROM `balance` WHERE available > 0 OR reserved > 0 ORDER BY `currency` ASC";
//$sql = "SELECT * FROM `tickerdaily` WHERE `symbol` LIKE '%USD%' AND ask>='". $getminr ."' AND ask<='". $getmaxr ."' ORDER BY `ask` ASC";
$sql = "SELECT * FROM `ticker` WHERE `symbol` LIKE '%USD%' AND ask<='0.5' ORDER BY `ask` ASC";
if($resultsql = mysqli_query($connection, $sql)){
    if(mysqli_num_rows($resultsql) > 0){
	 
      $num_rows = mysqli_num_rows($resultsql);
      echo $num_rows . "<br>";

                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>Currency</th>";
                echo "<th>price(ask)</th>";
                echo "<th>qty inc</th>";
                echo "<th>total if buy</th>";
                echo "</tr>";



        while($row = mysqli_fetch_array($resultsql)){

          // select order # in stat
          // $sqloid = "SELECT * FROM stat";
          // $resultoid = $connection->query($sqloid);
         //  $oid = mysqli_fetch_array($resultoid);
          // $oidpush = $oid['botorderid']+1;

          $urlbase = "https://api.hitbtc.com/api/2/public/symbol/" . $row['symbol'] . "";
          $dataubase = json_decode(file_get_contents($urlbase), true);
          $base=$dataubase['baseCurrency']; // 'DOGE'btc
          $quote=$dataubase['quoteCurrency']; // doge'BTC'
          $qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol
          


                echo "<tr>";
                echo "<td>" . $row['symbol'] . "</td>";
                echo "<td>" . $row['ask'] . "</td>";
                echo "<td>" . $qtyinc . "</td>";
                echo "<td>" . $qtyinc*$row['ask'] . "</td>";
                echo "</tr>";
 
                $ch = curl_init();
//do a post
curl_setopt($ch,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
curl_setopt($ch, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
curl_setopt($ch,CURLOPT_POSTFIELDS,"symbol=".$row['symbol']."&side=buy&price=".$row['ask']."&quantity=".$qtyinc."&type=limit&timeInForce=GTC");
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
  $sqlinsert = "INSERT IGNORE INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote) 
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
 

        }
        echo "</table>";
        // Free result set
      //  mysqli_free_result($resultsql);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute" . mysqli_error($connection);
    $err = mysqli_error($connection);
    $errorasc = "INSERT INTO error(seq, error) 
    VALUES ('', 
            'ERROR: Could not able to execute. buyallunderone.php - ".$err."'); ";                    
            
            $resultasc = $connection->query($errorasc);
}

// Close connection
mysqli_close($connection);
 
 
?>

      <!-- /.default -->
 
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
       
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
