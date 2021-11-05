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
            <h1 class="m-0">Bot BGL Create order</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Create order</li>
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
    <!-- Main content -->
  
<?php 
if(isset($_POST['b1'])){
// Data get from link
// data to push to the API and database
$inSymbol = $_POST['symbol'];
$inPrice = $_POST['nextstep'];
$tick= $_POST['tick'];
//$a= $_POST['price']*10/100;
//$b= $_POST['price']+$a;
//$inSellPrice = number_format($b,$tick);
$type = $_POST['type'];
$side = $_POST['side'];
$base = $_POST['base'];
$quote = $_POST['quote'];
$aps = $_POST['aps'];
$step1 = $_POST['step1'];
$loss = $_POST['loss'];
$date = Date("Y-m-d H:i:s");
 /////
                //insert setting  in database - bgl_bot_2 table
                //$nextin = $_POST['nextstep']-($_POST['nextstep']*$_POST['percent']/100);
                $nextin = $_POST['nextstep'];
                $nextins = number_format($nextin,$tick);
                $sqlinsert = "INSERT IGNORE INTO bgl_bot_2(symbol, nextstep, aps, pnl, step1, loss) 
                VALUES ('".$inSymbol."',  
                        '".$nextins."', 
                        '".$_POST['aps']."', 
                        '".$_POST['pnl']."',
                        '".$_POST['step1']."',
                        '".$_POST['loss']."')";
 
                $resultoid3 = $connection->query($sqlinsert);
   
 echo $inSymbol . " successfully added to bot BGL.";
  
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
$ask01=$ask-($ask*0.1/100); 
$ask5=$ask-($ask*5/100); 
$ask10=$ask-($ask*10/100); 
$ask15=$ask-($ask*15/100); 
$ask20=$ask-($ask*20/100);
$goal10=$ask+($ask*10/100);
//////////////////////////


if ($quote=='USD'){ 
/////////*///////*/**/*/*/*/* */   else if per base/quote  see bgl_bot_2
$qtymin1=$dataubase['quantityIncrement']*$ask;  
$qtymin2=number_format($qtymin1,$tick);  
$qtymin3=number_format($qtymin1,3);  
$qtymin=$qtymin2;  
/////////*///////*/**/*/*/*/* */
}else{
 //   $ppp=$quote."USD";
  //                          $sqlq = "SELECT * FROM `ticker_daily` WHERE `symbol` = '$ppp'";
  //                          $resultq = mysqli_query($connection, $sqlq);
  //                          $qqq = mysqli_fetch_array($resultq);
 //   $dbase=($dataubase['quantityIncrement']*$ask)*$qqq['ask'];
  //  $qtymin=$qqq['ask'];   
     $qtymin="";   
}

 ?>


            <!-- -->
            <!-- -->
            <!-- -->
            <table align="center" width="90%">
            <tr>
            <td>This Bot activate option when selected % reached. <br></td>
            </tr> 
            <tr>
            <td> 

                                    <table align="center" width="90%">
                                    <tr>
                                    <td align="left">
                                    <!--left side -->
                                    <form action='' method='POST'>
                                    Symbol to buy : <?php echo $symbol; ?> <br>
                                    Enter amount to buy : <input type='text' name='aps' size='5' value='<?php echo $dataubase['quantityIncrement'];?>'> 
                                     <br> Qty Min/Increment : (<?php echo $dataubase['quantityIncrement'] . " " .$base. ") " .$qtymin3 . " " . $quote; ?><br>
                                    Enter price to buy : <input type='text' name='nextstep' size='11' value='<?php echo "$ask"?>'> <br>
                                    P&L Take Profit : <input type='text' name='pnl' size='11' value='15'> %<br>
                                    Active option at : <input type='text' name='step1' size='11' value='7'> %<br>
                                    option Take loss : <input type='text' name='loss' size='11' value='5'> %<br>

                                        <br>
                                    <input type='hidden' name='symbol' value='<?php echo $symbol ?>'> 
                                    <input type='hidden' name='base' value='<?php echo $base ?>'> 
                                    <input type='hidden' name='quote' value='<?php echo $quote ?>'> 
                                    <input type='hidden' name='side' value='buy'> 
                                    <input type='hidden' name='type' value='limit'> 
                                    <input type='hidden' name='tick' value='<?php echo $tick ?>'> 
                                    <input type='submit' name='b1' value='Send Order'/>
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
                                    echo "<br>(-0.1%) " .number_format($ask01,$tick);
                                    echo "<br>(-05%) " .number_format($ask5,$tick);
                                    echo "<br>(-10%) " .number_format($ask10,$tick);
                                    echo "<br>(-15%) " .number_format($ask15,$tick);
                                    echo "<br>(-20%) " .number_format($ask20,$tick);
                                    ?>
 
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
