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
            <h1 class="m-0">Bot Percent</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Bot Percent</li>
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
  
    <!-- Main content -->
    <!-- Main content -->
    <!-- Main content -->


<?php
// ticker
$amountperstep = $_GET['aps'];
$sdf = $_GET['symbol'];
$sqlact = "SELECT * FROM ticker where symbol='".$sdf."'";
$resultact = mysqli_query($connection, $sqlact);
$roww = mysqli_fetch_array($resultact);

// symbol config
//currency base info
$urlbase = "https://api.hitbtc.com/api/2/public/symbol/". $sdf ."";
$dataubase = json_decode(file_get_contents($urlbase), true);
$base=$dataubase['baseCurrency']; // 'DOGE'btc
$quote=$dataubase['quoteCurrency']; // doge'BTC'
$qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol
$tickSize=$dataubase['tickSize'];
$tick=strpos(strrev($tickSize), ".");
if($quote=='USD'){
  $amountperstep = $_GET['aps'];
}
if($quote=='BTC'){
  // btc price
  $sqlbtc = "SELECT * FROM ticker where symbol='BTCUSD'";
$resultbtc = mysqli_query($connection, $sqlbtc);
$btc = mysqli_fetch_array($resultbtc);
  $btcformat = $_GET['aps']/$btc['ask'];
  $amountperstep = $btcformat;
}
 

######
 //Format profit price 1% 
$sellprice1=$roww['bid']*1/100;  // 1% profit
$sellprice2=$roww['bid']-$sellprice1; // price buy + 1%
$sellprice3=number_format($sellprice2,$tick);  // format string
//Format profit price 3% 
$sellprice4=$roww['bid']*2/100;  // 2% profit
$sellprice5=$roww['bid']-$sellprice4; // price buy + 2%
$sellprice6=number_format($sellprice5,$tick);  // format string
//Format profit price 5% 
$sellprice7=$roww['bid']*3/100;  // 3% profit
$sellprice8=$roww['bid']-$sellprice7; // price buy + 3%
$sellprice9=number_format($sellprice8,$tick);  // format string
//Format profit price 10% 
$sellprice10=$roww['bid']*4/100;  // 4% profit
$sellprice11=$roww['bid']-$sellprice10; // price buy + 4%
$sellprice12=number_format($sellprice11,$tick);  // format string
//Format profit price 50% 
$sellprice13=$roww['bid']*5/100;  // 5% profit
$sellprice14=$roww['bid']-$sellprice13; // price buy + 5%
$sellprice15=number_format($sellprice14,$tick);  // format string
#######

   if(mysqli_num_rows($resultact) > 0){
    //ticker data
    echo  $roww['symbol']."<br>";
    echo  "Ask : ".$roww['ask']."<br>";
    echo  "Bid : ".$roww['bid']."<br><br>";

    // config data
    //echo  "Active : ".$conf['active']."<br><br>";
    //echo  "Next Step : ".$conf['nextstep']."<br><br>";
    //echo  "Stop At : ".$conf['stopat']."<br><br>";

    //quantity format
        $quantity0=$amountperstep/$roww['bid']; // Usd balance divide by price buy
        $quantity3 =floor($quantity0 / $qtyinc) * $qtyinc;
        echo $amountperstep."$ divide by bid = X : ". $quantity0 ."<br>";  
        echo "( X / qty increment ) * qty increment = amount to buy ". $quantity3 ."<br>";  

    // format next step buy price
    echo  "now : ".$roww['ask']."<br>";
            #####################
            #####################
              
            $ch3 = curl_init();
            //do a post
            curl_setopt($ch3,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
            curl_setopt($ch3, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
            curl_setopt($ch3, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
            curl_setopt($ch3,CURLOPT_POSTFIELDS,"symbol=$sdf&side=buy&price=".$roww['ask']."&quantity=$quantity3&type=limit&timeInForce=GTC");
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER,1);
            //return the result of curl_exec,instead
            //of outputting it directly
            curl_setopt($ch3, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch3, CURLOPT_HTTPHEADER, array('accept: application/json'));
            //curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            $result3=curl_exec($ch3);
            curl_close($ch3);
            $result3=json_decode($result3);
            echo"<pre>";
            print_r($result3);
            //order end
            
            if( $result3->side =='sell'){
            if ($result3->status=='new') {
                $ostatus = '1';
            } elseif ($result3->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result3->status=='filled') {
                $ostatus = '2';
            }
            }elseif( $result3->side =='buy'){
            if ($result3->status=='new') {
                $ostatus = '1';
            } elseif ($result3->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result3->status=='filled') {
                $ostatus = '1';
            } }
            
            if (!empty($result3->error)) { } else { 

            /////
            //insert order
            // this !empty need cause [status] => new - order placed but no trade report in json result
            // will be resolved with the partially filled update add-on
            
                $sqlinsert3 = "INSERT IGNORE INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote) 
                VALUES ('', 
                        '".$result3->id."', 
                        '".$result3->clientOrderId."',
                        '".$ostatus."',
                        '".$result3->status."',
                        '".$result3->symbol."',
                        '".$result3->side."',
                        '".$result3->type."',
                        '".$result3->timeInForce."',
                        '".$result3->quantity."',
                        '".$result3->cumQuantity."',
                        '".$roww['ask']."',
                        '".$result3->createdAt."',
                        '".$qtyinc."',
                        '".$base."',
                        '".$quote."'); ";
            // update order id
                            // must be placed in the foreach array of insert
                            $sqloidup3 = "UPDATE stat set botorderid=botorderid +1";
                            $resultoid33 = $connection->query($sqloidup3);
                            $resultoid3333 = $connection->query($sqlinsert3);
                            
                        }
            
             
             
            
             
                
            #####################
            #####################
    echo  "1% : ".$sellprice3."<br>";
            #####################
            #####################
            // Data get from link
               
            //currency base info
            $urlbase = "https://api.hitbtc.com/api/2/public/symbol/". $sdf ."";
            $dataubase = json_decode(file_get_contents($urlbase), true);
            $base=$dataubase['baseCurrency']; // 'DOGE'btc
            $quote=$dataubase['quoteCurrency']; // doge'BTC'
            $qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol
      
            //BALANCE from our database
            $sqlbal1 = "SELECT * FROM balance where currency='USD'";
            $result123 = $connection->query($sqlbal1);
            // output data of each row
                while($row = $result123->fetch_assoc()) {
                 
            $ch1 = curl_init();
            //do a post
            curl_setopt($ch1,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
            curl_setopt($ch1, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
            curl_setopt($ch1, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
            curl_setopt($ch1,CURLOPT_POSTFIELDS,"symbol=$sdf&side=buy&price=$sellprice3&quantity=$quantity3&type=limit&timeInForce=GTC");
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1);
            //return the result of curl_exec,instead
            //of outputting it directly
            curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch1, CURLOPT_HTTPHEADER, array('accept: application/json'));
            //curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            $result1=curl_exec($ch1);
            curl_close($ch1);
            $result1=json_decode($result1);
            echo"<pre>";
            print_r($result1);
            //order end
            
            if( $result1->side =='sell'){
            if ($result1->status=='new') {
                $ostatus = '1';
            } elseif ($result1->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result1->status=='filled') {
                $ostatus = '2';
            }
            }elseif( $result1->side =='buy'){
            if ($result1->status=='new') {
                $ostatus = '1';
            } elseif ($result1->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result1->status=='filled') {
                $ostatus = '1';
            } }
            
            if (!empty($result1->error)) {
              $errorbbt = "INSERT INTO error(seq, error) 
    VALUES ('', 
            'ERROR: Could not able to execute. bot_percent.php <br> '".$result1->error."''); ";                    
            
            $resultbbt = $connection->query($errorbbt);
             } else { 
  
                $sqlinsert1 = "INSERT IGNORE INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote) 
                VALUES ('', 
                        '".$result1->id."', 
                        '".$result1->clientOrderId."',
                        '".$ostatus."',
                        '".$result1->status."',
                        '".$result1->symbol."',
                        '".$result1->side."',
                        '".$result1->type."',
                        '".$result1->timeInForce."',
                        '".$result1->quantity."',
                        '".$result1->cumQuantity."',
                        '".$sellprice3."',
                        '".$result1->createdAt."',
                        '".$qtyinc."',
                        '".$base."',
                        '".$quote."'); ";
            // update order id
                            // must be placed in the foreach array of insert
                            $sqloidup1 = "UPDATE stat set botorderid=botorderid +1";
                            $resultoid11 = $connection->query($sqloidup1);
                            $resultoid111 = $connection->query($sqlinsert1);
                            
                        }
            
            }
             
             
                
            #####################
            #####################
    echo  "2% : ".$sellprice6."<br>";
            #####################
            #####################
              
            $ch4 = curl_init();
            //do a post
            curl_setopt($ch4,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
            curl_setopt($ch4, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
            curl_setopt($ch4, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
            curl_setopt($ch4,CURLOPT_POSTFIELDS,"symbol=$sdf&side=buy&price=$sellprice6&quantity=$quantity3&type=limit&timeInForce=GTC");
            curl_setopt($ch4, CURLOPT_RETURNTRANSFER,1);
            //return the result of curl_exec,instead
            //of outputting it directly
            curl_setopt($ch4, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch4, CURLOPT_HTTPHEADER, array('accept: application/json'));
            //curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            $result4=curl_exec($ch4);
            curl_close($ch4);
            $result4=json_decode($result4);
            echo"<pre>";
            print_r($result4);
            //order end
            
            if( $result4->side =='sell'){
            if ($result4->status=='new') {
                $ostatus = '1';
            } elseif ($result4->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result4->status=='filled') {
                $ostatus = '2';
            }
            }elseif( $result4->side =='buy'){
            if ($result4->status=='new') {
                $ostatus = '1';
            } elseif ($result4->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result4->status=='filled') {
                $ostatus = '1';
            } }
            
            if (!empty($result4->error)) { } else { 

            /////
            //insert order
            // this !empty need cause [status] => new - order placed but no trade report in json result
            // will be resolved with the partially filled update add-on
            
                $sqlinsert4 = "INSERT IGNORE INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote) 
                VALUES ('', 
                        '".$result4->id."', 
                        '".$result4->clientOrderId."',
                        '".$ostatus."',
                        '".$result4->status."',
                        '".$result4->symbol."',
                        '".$result4->side."',
                        '".$result4->type."',
                        '".$result4->timeInForce."',
                        '".$result4->quantity."',
                        '".$result4->cumQuantity."',
                        '".$sellprice6."',
                        '".$result4->createdAt."',
                        '".$qtyinc."',
                        '".$base."',
                        '".$quote."'); ";
            // update order id
                            // must be placed in the foreach array of insert
                            $sqloidup4 = "UPDATE stat set botorderid=botorderid +1";
                            $resultoid44 = $connection->query($sqloidup4);
                            $resultoid444 = $connection->query($sqlinsert4);
                            
                        }
            
             
             
            
             
                
            #####################
            #####################
    echo  "3% : ".$sellprice9."<br>";
            #####################
            #####################
              
            $ch2 = curl_init();
            //do a post
            curl_setopt($ch2,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
            curl_setopt($ch2, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
            curl_setopt($ch2, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
            curl_setopt($ch2,CURLOPT_POSTFIELDS,"symbol=$sdf&side=buy&price=$sellprice9&quantity=$quantity3&type=limit&timeInForce=GTC");
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER,1);
            //return the result of curl_exec,instead
            //of outputting it directly
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array('accept: application/json'));
            //curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            $result2=curl_exec($ch2);
            curl_close($ch2);
            $result2=json_decode($result2);
            echo"<pre>";
            print_r($result2);
            //order end
            
            if( $result2->side =='sell'){
            if ($result2->status=='new') {
                $ostatus = '1';
            } elseif ($result2->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result2->status=='filled') {
                $ostatus = '2';
            }
            }elseif( $result2->side =='buy'){
            if ($result2->status=='new') {
                $ostatus = '1';
            } elseif ($result2->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result2->status=='filled') {
                $ostatus = '1';
            } }
            
            if (!empty($result2->error)) { } else { 

            /////
            //insert order
            // this !empty need cause [status] => new - order placed but no trade report in json result
            // will be resolved with the partially filled update add-on
            
                $sqlinsert2 = "INSERT IGNORE INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote) 
                VALUES ('', 
                        '".$result2->id."', 
                        '".$result2->clientOrderId."',
                        '".$ostatus."',
                        '".$result2->status."',
                        '".$result2->symbol."',
                        '".$result2->side."',
                        '".$result2->type."',
                        '".$result2->timeInForce."',
                        '".$result2->quantity."',
                        '".$result2->cumQuantity."',
                        '".$sellprice9."',
                        '".$result2->createdAt."',
                        '".$qtyinc."',
                        '".$base."',
                        '".$quote."'); ";
            // update order id
                            // must be placed in the foreach array of insert
                            $sqloidup2 = "UPDATE stat set botorderid=botorderid +1";
                            $resultoid22 = $connection->query($sqloidup2);
                            $resultoid222 = $connection->query($sqlinsert2);
                            
                        }
            
             
             
            
             
                
            #####################
            #####################
    echo  "4% : ".$sellprice12."<br>";
            #####################
            #####################
              
            $ch5 = curl_init();
            //do a post
            curl_setopt($ch5,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
            curl_setopt($ch5, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
            curl_setopt($ch5, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
            curl_setopt($ch5,CURLOPT_POSTFIELDS,"symbol=$sdf&side=buy&price=$sellprice12&quantity=$quantity3&type=limit&timeInForce=GTC");
            curl_setopt($ch5, CURLOPT_RETURNTRANSFER,1);
            //return the result of curl_exec,instead
            //of outputting it directly
            curl_setopt($ch5, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch5, CURLOPT_HTTPHEADER, array('accept: application/json'));
            //curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            $result5=curl_exec($ch5);
            curl_close($ch5);
            $result5=json_decode($result5);
            echo"<pre>";
            print_r($reresult5sult4);
            //order end
            
            if( $result5->side =='sell'){
            if ($result5->status=='new') {
                $ostatus = '1';
            } elseif ($result5->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result5->status=='filled') {
                $ostatus = '2';
            }
            }elseif( $result5->side =='buy'){
            if ($result5->status=='new') {
                $ostatus = '1';
            } elseif ($result5->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result5->status=='filled') {
                $ostatus = '1';
            } }
            
            if (!empty($result5->error)) { } else { 

            /////
            //insert order
            // this !empty need cause [status] => new - order placed but no trade report in json result
            // will be resolved with the partially filled update add-on
            
                $sqlinsert5 = "INSERT IGNORE INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote) 
                VALUES ('', 
                        '".$result5->id."', 
                        '".$result5->clientOrderId."',
                        '".$ostatus."',
                        '".$result5->status."',
                        '".$result5->symbol."',
                        '".$result5->side."',
                        '".$result5->type."',
                        '".$result5->timeInForce."',
                        '".$result5->quantity."',
                        '".$result5->cumQuantity."',
                        '".$sellprice12."',
                        '".$result5->createdAt."',
                        '".$qtyinc."',
                        '".$base."',
                        '".$quote."'); ";
            // update order id
                            // must be placed in the foreach array of insert
                            $sqloidup5 = "UPDATE stat set botorderid=botorderid +1";
                            $resultoid55 = $connection->query($sqloidup5);
                            $resultoid555 = $connection->query($sqlinsert5);
                            
                        }
            
             
             
            
             
                
            #####################
            #####################
    echo  "5% : ".$sellprice15."<br>";
             #####################
            #####################
              
            $ch6 = curl_init();
            //do a post
            curl_setopt($ch6,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
            curl_setopt($ch6, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
            curl_setopt($ch6, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
            curl_setopt($ch6,CURLOPT_POSTFIELDS,"symbol=$sdf&side=buy&price=$sellprice15&quantity=$quantity3&type=limit&timeInForce=GTC");
            curl_setopt($ch6, CURLOPT_RETURNTRANSFER,1);
            //return the result of curl_exec,instead
            //of outputting it directly
            curl_setopt($ch6, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch6, CURLOPT_HTTPHEADER, array('accept: application/json'));
            //curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            $result6=curl_exec($ch6);
            curl_close($ch6);
            $result6=json_decode($result6);
            echo"<pre>";
            print_r($result6);
            //order end
            
            if( $result6->side =='sell'){
            if ($result6->status=='new') {
                $ostatus = '1';
            } elseif ($result6->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result6->status=='filled') {
                $ostatus = '2';
            }
            }elseif( $result6->side =='buy'){
            if ($result6->status=='new') {
                $ostatus = '1';
            } elseif ($result6->status=='partiallyFilled') {
                $ostatus = '1';
            } elseif ($result6->status=='filled') {
                $ostatus = '1';
            } }
            
            if (!empty($result6->error)) { } else { 

            /////
            //insert order
            // this !empty need cause [status] => new - order placed but no trade report in json result
            // will be resolved with the partially filled update add-on
            
                $sqlinsert2 = "INSERT IGNORE INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote) 
                VALUES ('', 
                        '".$result6->id."', 
                        '".$result6->clientOrderId."',
                        '".$ostatus."',
                        '".$result6->status."',
                        '".$result6->symbol."',
                        '".$result6->side."',
                        '".$result6->type."',
                        '".$result6->timeInForce."',
                        '".$result6->quantity."',
                        '".$result6->cumQuantity."',
                        '".$sellprice15."',
                        '".$result6->createdAt."',
                        '".$qtyinc."',
                        '".$base."',
                        '".$quote."'); ";
            // update order id
                            // must be placed in the foreach array of insert
                            $sqloidup6 = "UPDATE stat set botorderid=botorderid +1";
                            $resultoid66 = $connection->query($sqloidup6);
                            $resultoid666 = $connection->query($sqlinsert6);
                            
                        }
            
             
             
            
             
                
            #####################
            #####################


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
