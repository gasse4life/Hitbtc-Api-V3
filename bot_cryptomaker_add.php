   <!-- v2.0.1 -->

   <?php   include "module/head.php"; ?>


<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader 
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>-->

 
  <?php   include "module/navbar.php"; ?>
  <?php include "module/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Add Order</h1>
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
  
    <!-- Main content -->
    <!-- Main content -->
    <!-- Main content -->
    <!-- Main content -->
  
<?php 
if(isset($_POST['freecoin'])){
// Data get from link
// data to push to the API and database
$timeInForce = 'GTC'; 
$inSymbol = $_POST['symbol'];
$inQty = $_POST['quantity'];
$inPrice = $_POST['price'];
$tick= $_POST['tick'];
$a= $_POST['price']*10/100;
$b= $_POST['price']+$a;
$inSellPrice = number_format((float)$b,$tick,".","");
$type = $_POST['type'];
$side = $_POST['side'];
$base = $_POST['base'];
$quote = $_POST['quote'];
$date = Date("Y-m-d H:i:s");
  
$ch = curl_init();
//do a post
curl_setopt($ch,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
curl_setopt($ch, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
curl_setopt($ch,CURLOPT_POSTFIELDS,"symbol=$inSymbol&side=$side&price=$inPrice&quantity=$inQty&type=$type&timeInForce=$timeInForce");
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
  
  ///####################
                if (!empty($result->error)) { 
                                                        foreach($result as $item) {   
                                                         $errorbbt = "INSERT IGNORE INTO error(seq, error) 
                                                          VALUES ('', 'API: Could not able to execute. bot_cryptomaker_add.php <br>".$inSymbol."<br>".$item->code."<br>".$item->message."<br>')";                    
                                                                  $resultbbt = $connection->query($errorbbt);
                                                                  mysqli_free_result($resultbbt);
                                                              }
                
                } else { 

                /////
                //insert order in database
                    $sqlinsert = "INSERT IGNORE INTO coincreator(symbol, qty, pricebuy, goal10, status, cumQuantity, date, base, quote, orderId, ClientOrderId) 
                    VALUES ('".$result->symbol."', 
                            '".$result->quantity."',
                            '".$inPrice."', 
                            '".$inSellPrice."', 
                            '".$result->status."', 
                            '".$result->cumQuantity."', 
                            '".$result->createdAt."', 
                            '".$base."', 
                            '".$quote."', 
                            '".$result->id."', 
                            '".$result->clientOrderId."')";
                // update order id in stat
                                // must be placed in the foreach array of insert
                                $sqloidup = "UPDATE stat set botorderid=botorderid +1";
                                $resultoid2 = $connection->query($sqloidup);
                                $resultoid3 = $connection->query($sqlinsert);

                // put warn of the sale in db
                            $aa=$result->quantity;
                            $bb=$result->symbol;
                            $spent=$result->quantity*$result->price;
                            $sqlinsert2 = "INSERT IGNORE INTO winfo(warn) 
                            VALUES ('CM-Bot Just Bought ".$result->quantity."x ".$result->symbol.", ".$spent." ".$quote." spent ')";         
                            $spent2 = $connection->query($sqlinsert2);

                            }
  ///####################

 
  
 // end isset post
}else{  
    
    // main form action
    // main form action
    // main form action
    $symbol = $_GET['symbol'];

//ask price
$url = "https://api.hitbtc.com/api/2/public/ticker/". $symbol ."";
$dataticker = json_decode(file_get_contents($url), true);
$ask=$dataticker['ask']; // sell price
  
//currency base info
$urlbase = "https://api.hitbtc.com/api/2/public/symbol/". $symbol ."";
$dataubase = json_decode(file_get_contents($urlbase), true);
$base=$dataubase['baseCurrency']; // 'DOGE'btc
$quote=$dataubase['quoteCurrency']; // doge'BTC'
$qtyinc=$dataubase['quantityIncrement']*10; // qty increment of a symbol (x10)
$sellamount=($dataubase['quantityIncrement']*90/100)*10; // amount to sell (90%)
$tickSize=$dataubase['tickSize'];
$tick=strpos(strrev($tickSize), ".");
//////////////////////////
$ask5=$ask-($ask*5/100); 
$ask10=$ask-($ask*10/100); 
$ask15=$ask-($ask*15/100); 
$ask20=$ask-($ask*20/100);
$goal10=$ask+($ask*10/100);
//////////////////////////
 ?>


            <!-- -->
            <!-- -->
            <!-- -->
            <table align="center" width="90%">
            <tr>
            <td>This Bot wait <?php echo $base; ?> raise by 10% to sell 90 % of the <?php echo $base; ?> to creating 10 % <?php echo $base; ?> free<br>Minimum amount to buy depend of the quantity increment of a coin.<br><br></td>
            </tr>
            <tr>
            <td><?php 
            echo "This bot need to buy a minimum / mutiple of : ".$qtyinc."  ".$base."<br>"; 
            ?></td>
            </tr>
            <tr>
            <td> 

                                    <table align="center" width="90%">
                                    <tr>
                                    <td align="left">
                                    <!--left side -->
                                    <form action='' method='POST'>
                                    Symbol to buy : <?php echo $symbol; ?> <br>
                                    Enter qty to buy : <input type='text' name='quantity' size='5' value='<?php echo "$qtyinc"?>'> <br>
                                    Enter price to buy : <input type='text' name='price' size='11' value='<?php echo "$ask"?>'> <br>
                                    <input type='hidden' name='symbol' value='<?php echo $symbol ?>'> 
                                    <input type='hidden' name='base' value='<?php echo $base ?>'> 
                                    <input type='hidden' name='quote' value='<?php echo $quote ?>'> 
                                    <input type='hidden' name='side' value='buy'> 
                                    <input type='hidden' name='type' value='limit'> 
                                    <input type='hidden' name='tick' value='<?php echo $tick ?>'> 
                                    <input type='hidden' name='sellamount' value='<?php echo $sellamount ?>'> 
                                    <input type='submit' name='freecoin' value='Send Order'/>
                                    </form>
                                    </td>
                                    <td align="right">
                                    <!--right side -->
                                    <table align="right">
                                    <tr>
                                    <td>
                                    <?php  
                                    echo "<u>Pre-Selection</u><br>";
                                    echo "Now Price ".$ask;
                                    echo "<br>(-05%) " .number_format($ask5,$tick);
                                    echo "<br>(-10%) " .number_format($ask10,$tick);
                                    echo "<br>(-15%) " .number_format($ask15,$tick);
                                    echo "<br>(-20%) " .number_format($ask20,$tick);
                                    ?>

                                    <br>
                                    <?php echo "# of coin to sell: ".$sellamount; ?>
                                    </td>
                                    </tr>
                                    </table>
                                    </td>
                                    </tr>
                                    </table>
            
            </td>
            </tr>
            </table>
            <!-- -->
            <!-- -->
            <!-- -->



<?php
//  end main form action
}
?>



    <!-- Main content -->
    <!-- Main content -->
    <!-- Main content -->
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

 