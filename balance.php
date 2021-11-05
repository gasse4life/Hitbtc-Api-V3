   <!--   v2.0.1 -->

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
            <h1 class="m-0">Balance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Balance</li>
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
// include "connect.php"; 
///// 
                                                if(isset($_POST['balancecheck'])){
                                                  $kll=$_POST['symbol'];
                                                  $blset = "INSERT INTO `balance_check` (`seq`,`symbol`) VALUES (NULL,'$kll');";
                                                  $goblset = $connection->query($blset);
                                                  }
 
 // Attempt select query execution
//$sql = "SELECT * FROM `balance` WHERE available > 0 OR reserved > 0 ORDER BY `currency` ASC";
$hidezero = $_GET['hidezero'];
$reserved = $_GET['reserved'];

////////////////////
if($hidezero=='1'){
$sql = "SELECT * FROM `balance` WHERE available>0 ORDER BY `currency` ASC";
}elseif($reserved=='1'){
  $sql = "SELECT * FROM `balance` WHERE reserved>0 ORDER BY `currency` ASC";
  }else{
    $sql = "SELECT * FROM `balance` ORDER BY `currency` ASC";
    }

if($result = mysqli_query($connection, $sql)){
    if(mysqli_num_rows($result) > 0){
	 echo "<table>
          <tr>
          <td>";
          if($hidezero=='1'){
            echo "<a href='?hidezero=0'>Show Zero Balance</a> &nbsp;&nbsp;&nbsp;";
          }else{
              echo "<a href='?hidezero=1'>Hide Zero Balance</a> &nbsp;&nbsp;&nbsp;";
            }
   echo  "</td>
          <td>";
          if($reserved=='1'){
            echo "<a href='balance.php'>Show All</a>";
          }else{
              echo "<a href='?reserved=1'>Show Only Reserved</a>";
            } 
   echo  "</td>
          </tr>
        </table>";
////////////////////

        echo "<table border='1'>";
            echo "<tr>";
                echo "<th> Currency </th>";
                echo "<th></th>";
                echo "<th> Availble </th>";
                echo "<th> Reserved </th>";
                echo "<th> See All Orders </th>";
                echo "<th> Crypto Maker Bot </th>";
            echo "</tr>";
        //** ******** */   
        while($row = mysqli_fetch_array($result)){
                                                            /////// free coin amount query
                                                            $sts=$row["currency"];
                                                            $qtysum="SELECT SUM(qty) AS qty FROM freezone WHERE symbol like '$sts%'";
                                                            $qtysum2 = mysqli_query($connection, $qtysum);
                                                            $qtysum3 = mysqli_fetch_array($qtysum2);
                                                            ///////

                                                            //************** */
                                                            $bbb="SELECT * FROM coincreator WHERE symbol like '$sts%'";
                                                            $bbbb = mysqli_query($connection, $bbb);
                                                            $bbbbb = mysqli_fetch_array($bbbb);
                                                            $sqlopen = "SELECT COUNT(seq) AS open FROM `coincreator` WHERE symbol like '$sts%'";
                                                            $resultopen = $connection->query($sqlopen);
                                                            $oidopen = mysqli_fetch_array($resultopen);
                                                             
                                                            if(mysqli_num_rows($bbbb) > 0) {
                                                              $aaa = " <span class='right badge badge-success'>".$oidopen['open']."</span>";
                                                            }
                                                            else{
                                                              $aaa = " <span class='right badge badge-danger'>X</span>";
                                                            } 
                                                            //************** */

                                      //// bg color for balance check up                      
                                      $blc="SELECT * FROM balance_check WHERE symbol like '$sts'";
                                      $goblc = mysqli_query($connection, $blc);
                                      $resblc = mysqli_fetch_array($goblc);
                                      if(mysqli_num_rows($goblc) > 0) {
                                        $tdstyle = "<td style='background-color : green'>";
                                      }
                                      else{
                                        $tdstyle = "<td>";
                                      } 
                                      //// END BG
            echo "<tr>";
                echo "".$tdstyle."" . $row['currency'] . "</td>";
                echo "<td>
                        <form action='' method='POST'>
                        <input type='hidden' name='symbol' value='".$row['currency']."'> 
                        <input type='submit' style='width:35px,height:10px' name='balancecheck' value='+' class='btn btn-block btn-outline-default btn-xs'/>
                        </form>
                     </td>";
                echo "<td>" . $row['available'] . "</td>";
                echo "<td>" . $row['reserved'] . "</td>";
                echo "<td align='center'><a href='balance_details.php?curr=" . $row['currency'] . "&quote=USD' target='new'>See Details</a></td>";
                echo "<td align='center'>" . $aaa ." &nbsp;&nbsp; " . $qtysum3['qty'] ."</td>";
                
            echo "</tr>";
        }
        //** ******** */ 
        
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
