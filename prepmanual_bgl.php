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
            <h1 class="m-0">Make your selection (BGL)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Make your selection</li>
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
   
$symbol = $_GET['symbol'];
$sts = $_GET['symbol'];
?>


<table align="center" width="80%">
<tr>
<td align="left">

<?php
 
// select order # in stat
$sqloid = "SELECT * FROM stat";
$resultoid = $connection->query($sqloid);
$oid = mysqli_fetch_array($resultoid);
$oidpush1 = $oid['botorderid']-10000000;
$oidpush = $oidpush1;
 
//currency base info
$urlbase = "https://api.hitbtc.com/api/2/public/symbol/". $sts ."";
$dataubase = json_decode(file_get_contents($urlbase), true);
$base=$dataubase['baseCurrency']; // 'DOGE'btc
$quote=$dataubase['quoteCurrency']; // doge'BTC'
$qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol

echo "Symbol : ".$sts."<br>";     //  DOGEBTC
echo "Base : ".$base."<br>";      //  DOGE
echo "Quote : ".$quote."<br>";     //  BTC
echo "Qty Increment : ".$qtyinc."<br>";  //   increment - order min 
echo "Order # : ".$oidpush."<br>"; //  # of next order  
 
//bid-ask price
$url = "https://api.hitbtc.com/api/2/public/ticker/". $sts ."";
$dataticker = json_decode(file_get_contents($url), true);
//$symbol=$dataticker['symbol'];
$bid=$dataticker['bid']; // buy price
$ask=$dataticker['ask']; // sell price
?>
<br><br>
<u>Live Data</u><br>
Bid: <?php echo $bid; ?> <br>
Ask: <?php echo $ask; ?>
</td>
<td  align="left">
 

 <?php

  /////////
////////
///////
if(isset($_POST['update']))
{
  //  not define in this page but i leave then just in case
              
   // header("location:orders_side.php?Side=buy&Status=1"); // redirects to active records page
   // exit;
}
///////
//////symbol, nextstep, aps, pnl, step1, loss
///////

?>
 
        <form action="pushordermanual_bgl.php" method="post">
        
            <table>
            <tr>
            <td>Symbol : </td><td><?php echo $base. " → " .$quote; ?><input type="hidden" name="symbol" value="<?php echo $symbol; ?>"><input type="hidden" name="base" value="<?php echo $base; ?>"><input type="hidden" name="quote" value="<?php echo $quote; ?>"></td>
            </tr>
            <tr>
            <td>Price Buy : </td><td><input class="custom-select form-control-border border-width-2" type="text" name="price" value="<?php echo $ask; ?>" required></td>
            </tr>  
            <tr>
            <td>Take Profit % :</td><td><select name="percent" id="percent" required><br><br>
            <option value="5">5</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="25">25</option>
            <option value="30">30</option>
            <option value="35">35</option>
            <option value="40">40</option>
            <option value="45">45</option>
            <option value="50">50</option>
            <option value="55">55</option>
            <option value="60">60</option>
            <option value="65">65</option>
            <option value="70">70</option>
            <option value="75">75</option>
            <option value="80">80</option>
            <option value="85">85</option>
            <option value="90">90</option>
            <option value="95">95</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="300">300</option>
            <option value="500">500</option>
            <option value="1000">1000</option>

                  </select>
            </td>
            </tr>
            <tr>
            <td>Step Activation : </td><td><input class="custom-select form-control-border border-width-2" type="text" name="step1" value="7" required></td>
            </tr>
            <tr>
            <td>Loss when active : </td><td><input class="custom-select form-control-border border-width-2" type="text" name="loss" value="5" required></td>
            </tr>
            <tr>
            <td>Quantity : <br>Min: <?php echo $qtyinc; ?></td><td><input class="custom-select form-control-border border-width-2" type="text" name="qty" value="<?php echo $qtyinc; ?>" required></td>
            </tr>
            <tr>
            <td>Side : </td><td><input type="hidden" name="side" value="buy" required>Buy</td>
            </tr>
            <tr>
            <td></td><td><input type="hidden" name="qtyinc" value="<?php echo $qtyinc; ?>" required></td>
            </tr>
            <tr>
            <td>Type : </td><td><select name="type" id="type" required><br><br>
                    <option value="limit">limit</option>
                    <option value="market">market</option>
                  </select>
            </td>
            </tr>
            <tr>
            <td>Time In Force : </td><td><select name="timeInForce" id="timeInForce" required><br><br>
                    <option value="GTC">Good To Cancel</option>
                    <option value="FOK">Fill Or Kill</option>
                    <option value="IOC">Immediate Or Cancel</option>
                  </select>
            </td>
            </tr>
            <tr>
            <td>Auto Sell : </td><td><select name="autosell" id="autosell" required><br><br>
            <option value="1">Active</option>
            <option value="0">Unactive</option>
            <option value="3">Lock</option>
                  </select>
            </td>
           
            </table>
         
            <br><input type="submit" value="Call Order">
        </form>
          
        
</td>
</tr>
</table>


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
