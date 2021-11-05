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
            <h1 class="m-0">Free Zone</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Free Zone</li>
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
        <?php 
 
 
 // Attempt select query execution
//$sql = "SELECT * FROM `balance` WHERE available > 0 OR reserved > 0 ORDER BY `currency` ASC";
$hidezero = $_GET['hidezero'];
$reserved = $_GET['reserved'];

if($hidezero=='1'){
$sql = "SELECT * FROM `balance` WHERE available>0 ORDER BY `currency` ASC";
}elseif($reserved=='1'){
  $sql = "SELECT * FROM `balance` WHERE reserved>0 ORDER BY `currency` ASC";
  }else{
    $sql = "SELECT * FROM `freezone` ORDER BY `date` DESC";
    }

if($result = mysqli_query($connection, $sql)){
    if(mysqli_num_rows($result) > 0){
	 echo "<table>
          <tr>
          <td>";
          
   echo  "</td>
          <td>";
           
   echo  "</td>
          </tr>
        </table>";
        echo "<table border='1'>";
            echo "<tr>";
            echo "<th></th>";
            echo "<th> Currency </th>";
            echo "<th> Amount </th>";
                echo "<th> Value </th>";
               echo "<th> DATE </th>";
                echo "<th> Method  </th>";
                echo "</tr>";
        while($row = mysqli_fetch_array($result)){
  
            echo "<tr>";
            echo "<td> FREE </td>";
            echo "<td>" . $row['symbol'] . "</td>";
            echo "<td>" . $row['qty'] . "</td>";
                echo "<td>" . $row['pricebuy'] . "</td>";
                 echo "<td align='center'>" . $row['date'] . "</td>";
                echo "<td align='center'>" . $row['createdBy'] . "</td>";
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
