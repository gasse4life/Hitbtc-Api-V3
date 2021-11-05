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
            <h1 class="m-0">Live Rate Data</h1>
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
 
 $sql = "SELECT * FROM `ticker` ORDER BY `symbol` ASC";
 if($result = mysqli_query($connection, $sql)){
     if(mysqli_num_rows($result) > 0){
 
        
     
          echo "
         <table border='1'>
         <tr>
         <th>Symbol</th>
         <th>Bid</th>
         <th>Ask</th>
         <th>Change since 00:00</th>
         <th>Manual Order</th>
          </tr>";
                           while($row = mysqli_fetch_array($result)){
                             $ttt=$row['symbol'];
                             $sqlttt = "SELECT * FROM `ticker_daily` WHERE `symbol` = '$ttt'";
                             $resulttt = mysqli_query($connection, $sqlttt);
                             $tttt = mysqli_fetch_array($resulttt);
                               echo "<tr>";
                                   echo "<td>" . $row['symbol'] . "</td>";
                                   echo "<td>" . $row['bid'] . "</td>";
                                   echo "<td>" . $row['ask'] . "</td>";
                                   $value=number_format(getPercentageChange($row['ask'], $tttt['ask']),2);
                                   if($value > 0){
                                   echo "<td><span class='right badge badge-success'>" . $value . " %</span></td>";
                                   }
                                   elseif($value < 0){
                                   echo "<td><span class='right badge badge-danger'>" . $value . " %</span></td>";
                                   }else{
                                   echo "<td><span class='right badge badge-default'>" . $value . " %</span></td>";
                                   }
                                   echo "<td><a href='prepmanual.php?symbol=" . $row['symbol'] . "' target='_new'>Make Order</a></td>";
 
                               echo "</tr>";
                   
                           }
         echo "</table>";
         // Free result set
         mysqli_free_result($result);
     } else{
         echo "No records matching your query were found.";
     }
 } else{
     echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
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
