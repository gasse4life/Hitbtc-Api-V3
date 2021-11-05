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
            <h1 class="m-0">Bot #1</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Bot #1</li>
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
 
    <table align="center">
        <tr>
        <td align="center"><a href="bot_buying_1.php?base=USD">USD</a><br><img src="img/usd.png" width="28px"></td><TD>&nbsp;&nbsp;&nbsp;</TD>
        <td align="center"><a href="bot_buying_1.php?base=BTC">BTC</a><br><img src="img/btc.png" width="28px"></td><TD>&nbsp;&nbsp;&nbsp;</TD>
        <td align="center"><a href="bot_buying_1.php?base=ETH">ETH</a><br><img src="img/eth.png" width="28px"></td><TD>&nbsp;&nbsp;&nbsp;</TD>
        <td align="center"><a href="bot_buying_1.php?base=EOS">EOS</a><br><img src="img/eos.png" width="28px"></td><TD>&nbsp;&nbsp;&nbsp;</TD>
        <td align="center"><a href="bot_buying_1.php?base=DAI">DAI</a><br><img src="img/dai.png" width="28px"></td><TD>&nbsp;&nbsp;&nbsp;</TD>
         </tr>
        </table>

    <?php
$sts = $_GET['base'];
$tickersel = "SELECT *  FROM `ticker` WHERE `symbol` LIKE '%".$sts."' ORDER BY `symbol` ";
$filter=$connection->query($tickersel);
$options=" "; 
while($row = mysqli_fetch_array($filter))
{
  $options .="<option value='" . $row['symbol'] . "'>" .  $row['symbol'] . " =­­> " .  $row['ask'] . "</option>";
}
   
?>
<select id="smb">
<?=$options?>
</select>
<script>

 function r1(){
  document.getElementById('iii').src='bot_buy_1_list.php'
} 

function r2(){
 document.getElementById('iii').src='bot_buy_1_add.php?symbol='+document.getElementById('smb').value+'&side=buy'
}

function r4(){
 document.getElementById('iii').src='bot_bgl_add.php?symbol='+document.getElementById('smb').value+'&side=buy'
}
 
 
 

</script>
<button onclick="r2()">Create Bot buy 1 Order</button>
<button onclick="r1()">See Active Orders</button>
<button onclick="r4()">Create Bot BGL Order</button>

 <hr>
  <iframe src="bot_buy_1_list.php" width="900px" height="1500px" style="border: none;" id="iii"></iframe> 

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

 
         
        