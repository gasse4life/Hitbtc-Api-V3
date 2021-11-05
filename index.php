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
            <h1 class="m-0">Crypto Bot Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Crypto Bot Dashboard</li>
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
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">LIFETIME profit</span>
                <span class="info-box-number">
                  10
                  <small>%</small>
                 </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Open orders</span>
                <span class="info-box-number"><?php
// select order # in stat
$sqlopen = "SELECT COUNT(seq) AS open FROM `getorders` WHERE ostatus='1'";
$resultopen = $connection->query($sqlopen);
$oidopen = mysqli_fetch_array($resultopen);
echo number_format($oidopen['open'],0);
?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total of trade</span>
                <span class="info-box-number"><?php
// select order # in stat
$sqloid = "SELECT * FROM stat";
$resultoid = $connection->query($sqloid);
$oid = mysqli_fetch_array($resultoid);
echo number_format($oid['botorderid']-10000000,0);
?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Free coin total</span>
                <span class="info-box-number"><?php
  $tot_free = "SELECT SUM(qty) AS qty FROM freezone";
  $resulttf = $connection->query($tot_free);
  $ttf = mysqli_fetch_array($resulttf);
  $tfc=number_format($ttf['qty'],4);
  echo $tfc;
  ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
 

        <!-- Main row -->
        <!-- Main row -->
        <!-- Main row -->
        <!-- Main row -->
        <!-- Main row -->
        <!-- Main row -->
        <table align="center">

<tr>
<td align="center">
<?php  
$today = date("Y-m-d");
            $pnlselect = "SELECT SUM(total) AS todaypnl FROM calculprofit WHERE date(DATE)='$today' and quote='usd'";
            $resultpnl = mysqli_query($connection, $pnlselect);
            $pnltoday = mysqli_fetch_array($resultpnl); 
            $totusd = $pnltoday['todaypnl'];
            $totusd = number_format($totusd,3); // format string

            $pnlselectbtc = "SELECT SUM(total) AS todaybtcpnl FROM calculprofit WHERE date(DATE)='$today' and quote='btc'";
            $resultpnlbtc = mysqli_query($connection, $pnlselectbtc);
            $pnlbtctoday = mysqli_fetch_array($resultpnlbtc);
            $totbtc = $pnlbtctoday['todaybtcpnl'];
            $totbtc=number_format($totbtc,8);  // format string
            
            $pnlselecteos = "SELECT SUM(total) AS todayeospnl FROM calculprofit WHERE date(DATE)='$today' and quote='eos'";
            $resultpnleos = mysqli_query($connection, $pnlselecteos);
            $pnleostoday = mysqli_fetch_array($resultpnleos);
            $toteos = $pnleostoday['todayeospnl'];
            $toteos=number_format($toteos,7);  // format string
            
            $pnlselecteth = "SELECT SUM(total) AS todayethpnl FROM calculprofit WHERE date(DATE)='$today' and quote='eth'";
            $resultpnleth = mysqli_query($connection, $pnlselecteth);
            $pnlethtoday = mysqli_fetch_array($resultpnleth);
            $toteth = $pnlethtoday['todayethpnl'];
            $toteth=number_format($toteth,7);  // format string

?>
Todays Profit <br> <?php echo $totusd; ?> USD <br> <?php echo $totbtc; ?> BTC<br> <?php echo $toteos; ?> EOS<br> <?php echo $toteth; ?> ETH
</td> 
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="center">
<?php 
 $yesterday = date('y-m-d',strtotime("-1 days"));
            $pnlselecty = "SELECT SUM(total) AS ypnl FROM calculprofit WHERE date(DATE)='$yesterday' and quote='usd'";
            $resultpnly = mysqli_query($connection, $pnlselecty);
            $pnlyesterday = mysqli_fetch_array($resultpnly); 
            $totyest = $pnlyesterday['ypnl'];
            $totyest=number_format($totyest,3);  // format string

            $pnlselectybtc = "SELECT SUM(total) AS ybtcpnl FROM calculprofit WHERE date(DATE)='$yesterday' and quote='btc'";
            $resultpnlybtc = mysqli_query($connection, $pnlselectybtc);
            $pnlbtcyesterday = mysqli_fetch_array($resultpnlybtc); 
            $totbtcyest = $pnlbtcyesterday['ybtcpnl'];
            $totbtcyest=number_format($totbtcyest,8);  // format string
            
            $pnlselectyeos = "SELECT SUM(total) AS yeospnl FROM calculprofit WHERE date(DATE)='$yesterday' and quote='eos'";
            $resultpnlyeos = mysqli_query($connection, $pnlselectyeos);
            $pnleosyesterday = mysqli_fetch_array($resultpnlyeos); 
            $toteosyest = $pnleosyesterday['yeospnl'];
            $toteosyest=number_format($toteosyest,7);  // format string
            
            $pnlselectyeth = "SELECT SUM(total) AS yethpnl FROM calculprofit WHERE date(DATE)='$yesterday' and quote='eth'";
            $resultpnlyeth = mysqli_query($connection, $pnlselectyeth);
            $pnlethyesterday = mysqli_fetch_array($resultpnlyeth); 
            $totethyest = $pnlethyesterday['yethpnl'];
            $totethyest=number_format($totethyest,7);  // format string
?>
Yesterday Profit <br> <?php echo $totyest; ?> USD <br><?php echo $totbtcyest; ?> BTC<br><?php echo $toteosyest; ?> EOS <br><?php echo $totethyest; ?> ETH
</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="center">
<?php  
            $monthselect = "SELECT SUM(total) AS monthusd FROM calculprofit WHERE MONTH(date) = MONTH(now()) and quote='usd'";
            $resultmonth = mysqli_query($connection, $monthselect);
            $pnlmonth = mysqli_fetch_array($resultmonth); 
            $totmonth = $pnlmonth['monthusd'];
            $totmonth=number_format($totmonth,3);  // format string

            $monthselectbtc = "SELECT SUM(total) AS monthbtc FROM calculprofit WHERE MONTH(date) = MONTH(now()) and quote='btc'";
            $resultmonthbtc = mysqli_query($connection, $monthselectbtc);
            $pnlbtcmonth = mysqli_fetch_array($resultmonthbtc);
            $totbtcmonth = $pnlbtcmonth['monthbtc'];
            $totbtcmonth=number_format($totbtcmonth,8);  // format string 
            
            $monthselecteos = "SELECT SUM(total) AS montheos FROM calculprofit WHERE MONTH(date) = MONTH(now()) and quote='eos'";
            $resultmontheos = mysqli_query($connection, $monthselecteos);
            $pnleosmonth = mysqli_fetch_array($resultmontheos);
            $toteosmonth = $pnleosmonth['montheos'];
            $toteosmonth=number_format($toteosmonth,7);  // format string 
            
            $monthselecteth = "SELECT SUM(total) AS montheth FROM calculprofit WHERE MONTH(date) = MONTH(now()) and quote='eth'";
            $resultmontheth = mysqli_query($connection, $monthselecteth);
            $pnlethmonth = mysqli_fetch_array($resultmontheth);
            $totethmonth = $pnlethmonth['montheth'];
            $totethmonth=number_format($totethmonth,7);  // format string 
?>
Profit this month <br> <?php echo $totmonth; ?> USD <br><?php echo $totbtcmonth; ?> BTC<br><?php echo $toteosmonth; ?> EOS <br><?php echo $totethmonth; ?> ETH
</td>
</tr>

<tr>
<td align="center"> </td> 
<td align="center"></td>
<td align="center"></td>
</tr>

</table>
<tr>
<td align="center">nano_3k3fsmc9ifc39cipzgnkqamhkm5ztz5iuaweij5d1perkm5bd7ru3116rr5e</td> 
 </tr>
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
        <!-- /.row -->
        <br><br><br>
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
