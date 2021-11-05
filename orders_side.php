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
            <h1 class="m-0">Orders Side</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Orders Side</li>
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
          /// autosell switch
          if(isset($_POST['autosell'])){
          $upautosell ="UPDATE `getorders` SET `autosell` = '".$_POST['autos']."' WHERE `seq` = '".$_POST['seq']."'";
          $updas = $connection->query($upautosell);
          } 
          /// end switch
  ?>
 
 
 
        
           <!-- Default box -->
           <style type="text/css">
.blink-bg{
		color: #fff;
		padding: 1px;
		display: inline-block;
		border-radius: 5px;
		animation: blinkingBackground 2s infinite;
	}
	@keyframes blinkingBackground{
		0%		{ background-color: #10c018;}
		25%		{ background-color: #1056c0;}
		50%		{ background-color: #ef0a1a;}
		75%		{ background-color: #254878;}
		100%	        { background-color: #04a1d5;}
	}
.sold-bg{
		color: #fff;
		background-color: #7f7f7f;
	}
    table.blueTable {
  border: 1px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 13px;
}
table.blueTable tr:nth-child(even) {
  background: #D0E4F5;
}
table.blueTable thead {
  background: #1C6EA4;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 2px solid #444444;
}
table.blueTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  border-left: 2px solid #D0E4F5;
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot {
  font-size: 14px;
  font-weight: bold;
  color: #FFFFFF;
  background: #D0E4F5;
  background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  border-top: 2px solid #444444;
}
table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}
</style>
 
 <?php

 echo "<img src='img/warnico.png' width='20px'>Some Data are Update every minute.<br> ";
 //include "connect.php"; 
 ///// 
 $getSide = $_GET['Side'];
 $getStatus = $_GET['Status'];
  
/* Begin Paging Info */
$pdo = new PDO("mysql:host=localhost;dbname=$db", "$dbuser", "$dbpass");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
$page = 1;
  if (isset($_GET['page'])) {
    $page = filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT);
  }
$per_page = 50;
$sqlcount = "select count(*) as total_records from getorders";
$stmt = $pdo->prepare($sqlcount);
$stmt->execute();
$row = $stmt->fetch();
$total_records = $row['total_records'];  // total orders count
$total_pages = ceil($total_records / $per_page); // format # of page
$offset = ($page-1) * $per_page;
/* End Paging Info */

// Attempt select query 
if ($_GET['Side']=='buy') {
  $sql = "SELECT * FROM `getorders` WHERE side = '$getSide' AND ostatus = '$getStatus' AND astatus = 'filled' ORDER BY `seq` DESC LIMIT $offset, $per_page";
} 
if ($_GET['Side']=='new') {
  $sql = "SELECT * FROM `getorders` WHERE astatus = 'new' ORDER BY `seq` DESC LIMIT $offset, $per_page";
} 
if ($_GET['Side']=='partiallyFilled') {
  $sql = "SELECT * FROM `getorders` WHERE astatus = 'partiallyFilled' ORDER BY `seq` DESC LIMIT $offset, $per_page";
} 
if ($_GET['Side']=='canceled') {
   $sql = "SELECT * FROM `getorders` WHERE astatus = 'canceled' ORDER BY `seq` DESC LIMIT $offset, $per_page";
}  
if ($_GET['Side']=='lock') {
   $sql = "SELECT * FROM `getorders` WHERE autosell = '3' AND ostatus = '1' ORDER BY `seq` DESC LIMIT $offset, $per_page";
} 

  $stmt = $pdo->prepare($sql);
  $stmt->execute(['offset'=>$offset, 'per_page'=>$per_page]);

  
  $aactive = "SELECT * FROM `getorders` WHERE ostatus = '1'";
  $resaac = mysqli_query($connection, $aactive);

  if($result = mysqli_query($connection, $sql)){
    $num_rows = mysqli_num_rows($resaac);
      echo $num_rows . " Active Orders <hr> 
      <form action='' method='POST'>
      Set all orders autosell - Enter % amount : <input type='text' name='percent' size='3'> 
<input type='submit' name='btn1' value='Set' class='btn btn-default'/>
</form>
 ";

if(isset($_POST['btn1'])){
  //execute mysql query
  // autosell!="3" cause autosell locked on number 3
  $setallautosell = "UPDATE `getorders` SET percent = '".$_POST['percent']."', autosell='1' WHERE side='buy' AND ostatus='1' AND autosell!='3'";
  $ressetsell = $connection->query($setallautosell);
   }
 

    if(mysqli_num_rows($result) > 0){

      if ($_GET['Status']=='1' and $_GET['Side']=='buy') {
		// LEGEND
        include "module/legende.php"; 
        //END LEGEND
      }

        if ($page-1 >= 1) {
          echo " <a href=".$_SERVER['REQUEST_URI']."&page=".($page - 1)."><img src='img/prev.png' width='100'></a> ";
        }
        if ($page+1 <= $total_pages) {
          echo " <a href=".$_SERVER['REQUEST_URI']."&page=".($page + 1)."><img src='img/next.png' width='100'></a> ";
        }

        
        echo "
        <div class='card'> 
        <div class='card-body p-0'>
        <div class='table-responsive'>";
        
        echo "<div class='card'> 
        <div class='card-body p-0'>
        <div class='table-responsive'>
        <table class='table m-0'>";

        while($row = mysqli_fetch_array($result)){
//Format bought price (Buy price + makers fee ) 
$buyprice1=$row['price']*3/1000;  // makers fee 
$buyprice2=$row['price']+$buyprice1; // price buy + maker
$buyprice=number_format($buyprice2,11,".","");  // format string
$fee=number_format($buyprice1,11,".","");  // format string
//Format profit price 3% 
$sellprice4=$row['price']*3/100;  // 3% profit
$sellprice5=$row['price']+$sellprice4; // price buy + 3%
$sellprice6=number_format($sellprice5,11,".","");  // format string
//Format profit price 5% 
$sellprice7=$row['price']*5/100;  // 5% profit
$sellprice8=$row['price']+$sellprice7; // price buy + 5%
$sellprice9=number_format($sellprice8,11,".","");  // format string
//Format profit price 10% 
$sellprice10=$row['price']*10/100;  // 10% profit
$sellprice11=$row['price']+$sellprice10; // price buy + 10%
$sellprice12=number_format($sellprice11,11,".","");  // format string
//Format profit price 50% 
$sellprice13=$row['price']*50/100;  // 50% profit
$sellprice14=$row['price']+$sellprice13; // price buy + 50%
$sellprice15=number_format($sellprice14,11,".","");  // format string


//Format sub total amount 
$subtotal1=$row['price']*$row['quantity'];  //  
$subtotal=number_format($subtotal1,11,".","");  // format string
 //Format total amount 
$total1=$subtotal+$row['fee'];  //  
$totalb=$row['price']*$row['quantity'];  // format string



    if($row['quote']=='USD'){ 
      $total=number_format($totalb,3,".","");  // format string
      }elseif($row['quote']=='BTC'){
        $total=number_format($totalb,11,".","");  // format string
        }elseif($row['quote']=='EOS'){
          $total=number_format($totalb,8,".","");  // format string
          }elseif($row['quote']=='ETH'){
            $total=number_format($totalb,8,".","");  // format string  tick must be adjust
            }


// Live Data From Ticker table
$sdf = $row['symbol'];
$sqlact = "SELECT * FROM ticker where symbol='".$sdf."'";
if($resultact = mysqli_query($connection, $sqlact)){
$roww = mysqli_fetch_array($resultact);
  
 
                echo "<tr>
                <td>
                <table align='center'>";


// Status Markup active/closed/canceled
if( $row['ostatus'] =='1'){
  echo "# ".$row['seq']."&nbsp;&nbsp;<span class='right badge badge-success'>ACTIVE</span>";
} elseif( $row['ostatus'] =='2'){
  echo "# ".$row['seq']."&nbsp;&nbsp;<span class='right badge badge-danger'>Closed</span>";
  $pnlshow = "SELECT * from calculprofit WHERE pnlin = '".$row['seq']."'";
  $sqlpnl = mysqli_query($connection, $pnlshow);
  $pnlrdy = mysqli_fetch_array($sqlpnl);
        if($row['quote']=='USD'){ 
        $pnl=number_format($pnlrdy['total'],3,".","");  // format string
        }elseif($row['quote']=='BTC'){
        $pnl=number_format($pnlrdy['total'],11,".","");  // format string
        }elseif($row['quote']=='EOS'){
          $total=number_format($totalb,8,".","");  // format string
          }elseif($row['quote']=='ETH'){
            $total=number_format($totalb,8,".","");  // format string  tick must be adjust
            }
  echo "&nbsp;&nbsp;Profit : ". $pnl ." ". $row['quote'] ;
  
} 
 
if( $row['astatus'] =='new'){
  $astatuss = "<span class='right badge badge-warning'>Wainting Order</span>";
} elseif( $row['astatus'] =='suspended'){
  $astatuss = "<span class='right badge badge-danger'>Suspended</span>";
} elseif( $row['astatus'] =='filled'){
  $astatuss = "<span class='right badge badge-success'>Filled</span>";
} elseif( $row['astatus'] =='canceled'){
  $astatuss = "<span class='right badge badge-primary'>Canceled</span>";
} elseif( $row['astatus'] =='expired'){
  $astatuss = "<span class='right badge badge-primary'>Expired</span>";
} elseif( $row['astatus'] =='partiallyFilled'){
  $astatuss = "<span class='right badge badge-warning'>partiallyFilled</span>&nbsp;&nbsp;&nbsp;" . $row['cumQuantity'] . "";
} 

            if($row['howto'] =='0' || $row['howto'] =='manual'){
              // hand img
              echo "&nbsp;&nbsp;&nbsp;<img src='img/hand.png' width='30px'>";
            }else{
              // bot img
              echo "&nbsp;&nbsp;&nbsp;<img src='img/bot.png' width='30px'>&nbsp;&nbsp;[" . $row['howto'] . "]";
            }
            // End Markup 

             ///////////// percentage p&l
             $b1=$roww['bid'] - $row['price'];
             $b2=($b1 / $roww['bid']) * 100;
             $value2=number_format($b2,2,".","");
             if($value2 > 0){
              $value ="<span class='right badge badge-success'>" . $value2 . " %</span>";
             }elseif($value2 < 0){
              $value ="<span class='right badge badge-danger'>" . $value2 . " %</span>";
             }else{
              $value ="<span class='right badge badge-default'>" . $value2 . " %</span>";
             }              ///////////// END percentage p&l
// SHOW p&l
echo "&nbsp;&nbsp;&nbsp; [P&L set at ".$row['percent']." %&nbsp;&nbsp;&nbsp; ".$value."]";
 
 

            // SHOW autosell 
            if($row['side']=='buy'){
                      if($row['autosell']=='1'){
                        $onoff= " <form action='' method='POST'>
                          <input type='hidden' name='autos' value='0'> 
                          <input type='hidden' name='seq' value='".$row['seq']."'> 
                          <label for='autosell'> 
                          <input type='submit' style='width:35px,height:10px' name='autosell' value='On' class='btn btn-block btn-outline-success btn-xs'/>
                          </label>
                          </form>";
                      }else{
                        $onoff= " <form action='' method='POST'>
                        <input type='hidden' name='autos' value='1'> 
                        <input type='hidden' name='seq' value='".$row['seq']."'> 
                        <label for='autosell'> 
                        <input type='submit' style='width:35px,height:10px' name='autosell' value='Off' class='btn btn-block btn-outline-danger btn-xs'/>
                        </label>
                        </form>";                     
                       }
                echo "&nbsp;&nbsp;&nbsp; [AutoSell ".$onoff."]";
             }


///////
///////
///////
  
//////
//////



if ($_GET['Status']=='1' and $_GET['Side']=='buy') {
include "module/ColorByProfit.php"; 
} else {$bgcolor = '';$bgclass='';} // unset color
                echo "<tr>
                <td align='left'>Order " . $row['side'] . " # " . $row['clientOrderId'] . "<br>" . $row['symbol'] . "&nbsp;&nbsp;&nbsp;" . $astatuss . "<br>".$row['quantity']." ".$row['base']." @ " . $row['AvgPrice'] . " " . $row['quote'] . "<br>Total Cost: " . $total . " " . $row['quote'] . "</td>";
                // show order details if sold
                echo "<td>";
                                          if (!empty($row['soldby'])) {
                                            // format selling price
                                            $sqlsell = "SELECT * FROM getorders where clientOrderId='" . $row['soldby'] . "'";
                                            if($resultsell = mysqli_query($connection, $sqlsell)){
                                            $sellsql = mysqli_fetch_array($resultsell);
                                            $totrec = $sellsql['price']*$sellsql['quantity'];
                                            $totreceived=number_format($totrec,11,".","");  // format string
                                            if( $sellsql['astatus'] =='new'){
                                              $astatus = "<span class='right badge badge-warning'>Wainting Order</span>";
                                            } elseif( $sellsql['astatus'] =='suspended'){
                                              $astatus = "<span class='right badge badge-danger'>Suspended</span>";
                                            } elseif( $sellsql['astatus'] =='filled'){
                                              $astatus = "<span class='right badge badge-success'>Filled</span>";
                                            } elseif( $sellsql['astatus'] =='canceled'){
                                              $astatus = "<span class='right badge badge-primary'>Canceled</span>";
                                            } elseif( $sellsql['astatus'] =='expired'){
                                              $astatus = "<span class='right badge badge-primary'>Expired</span>";
                                            } elseif( $sellsql['astatus'] =='partiallyFilled'){
                                              $astatus = "<span class='right badge badge-warning'>partiallyFilled</span>&nbsp;&nbsp;&nbsp;" . $sellsql['cumQuantity'] . "";
                                            } 
                                              echo "<td align='left'>Order " . $sellsql['side'] . " # " . $sellsql['clientOrderId'] . "<br>" . $sellsql['symbol'] . "&nbsp;&nbsp;&nbsp;" . $astatus . "<br>" . $sellsql['quantity'] . " ".$sellsql['base']." @ " . $sellsql['price'] . " " . $sellsql['quote'] . "<br>Total Received: ". $totreceived ." " . $sellsql['quote'] . "</td>";
                                          } 
                                        } 
              echo "</td>
                
                <td>
                    <table align='center'>
                    <tr>
                    <td align='center' style='".$bgcolor."'><div class='".$bgclass."'>Market Price</div><br>Bid : " . $roww['bid'] . " " . $row['quote'] . "<br>Ask : " . $roww['ask'] . " " . $row['quote'] . "</td></tr>
                    <tr>
                    <td align='center'>

                    <div class='btn-group'>
                    <button type='button' class='btn-xs btn-success'>Copy</button>
                    <button type='button' class='btn-xs btn-success dropdown-toggle dropdown-hover dropdown-icon' data-toggle='dropdown'>
                    <span class='sr-only'>Toggle Dropdown</span>
                    </button>
                    <div class='dropdown-menu' role='menu'>
                    <a class='dropdown-item' href='pushorder.php?id=" . $row['clientOrderId'] . "&quantity=" . $row['quantity'] . "&symbol=" . $row['symbol'] . "&type=market&side=buy'>Market</a>
                    <a class='dropdown-item' href='pushorder.php?id=" . $row['clientOrderId'] . "&quantity=" . $row['quantity'] . "&symbol=" . $row['symbol'] . "&type=limit&side=buy&price=" . $roww['ask'] . "'>Limit</a>
                    <div class='dropdown-divider'></div>
                    <p class='dropdown-item' href='#'>Set up Price</p>
                    </div>
                    </div>";
                   // desactivated for now, partFilled need update
                   // if ($row['astatus']=='new'||$row['astatus']=='partiallyFilled') {
                      if ($row['astatus']=='new') {
                        echo "<div class='btn-group'>
                      <button type='button' class='btn-xs btn-danger'>Cancel</button>
                      <button type='button' class='btn-xs btn-danger dropdown-toggle dropdown-hover dropdown-icon' data-toggle='dropdown'>
                      <span class='sr-only'>Toggle Dropdown</span>
                      </button>
                      <div class='dropdown-menu' role='menu'>
                      <a class='dropdown-item' href='orders_side_cancel.php?clientOrderId=".$row['clientOrderId']."' target='new'>Cancel Now</a>
                       </div>
                      </div>";
                    }
                    if($_GET['Side'] =='buy' AND $row['ostatus'] =='1'){
                      if ($row['soldby']=='') {
                        if ($row['astatus']=='filled') {
                          echo "<div class='btn-group'>
                    <button type='button' class='btn-xs btn-danger'>Sell</button>
                    <button type='button' class='btn-xs btn-danger dropdown-toggle dropdown-hover dropdown-icon' data-toggle='dropdown'>
                    <span class='sr-only'>Toggle Dropdown</span>
                    </button>
                    <div class='dropdown-menu' role='menu'>
                    <a class='dropdown-item' href='pushorder.php?id=" . $row['clientOrderId'] . "&quantity=" . $row['quantity'] . "&symbol=" . $row['symbol'] . "&type=market&side=sell'>Market</a>
                    <a class='dropdown-item' href='pushorder.php?id=" . $row['clientOrderId'] . "&quantity=" . $row['quantity'] . "&symbol=" . $row['symbol'] . "&type=limit&side=sell&price=" . $roww['bid'] . "'>Limit</a>
                    <div class='dropdown-divider'></div>
                    <p class='dropdown-item'>Info</p>
                    </div>
                    </div>";
                  }
                }
              }
              echo "</div>
                    
                    </td>
                    </tr>
                    </table>
                </td>
                </tr>
                </table>
                ";
                
    }  
                echo "</tr>";

        }



        echo "</table>
              </div><!-- /.table-responsive -->
              </div><!-- /.card-body -->
              </div>";


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
 
if ($page-1 >= 1) {
  echo " <a href=".$_SERVER['REQUEST_URI']."&page=".($page - 1)."><img src='img/prev.png' width='100'></a> ";
}
if ($page+1 <= $total_pages) {
  echo " <a href=".$_SERVER['REQUEST_URI']."&page=".($page + 1)."><img src='img/next.png' width='100'></a> ";
} 

?>

      <!-- /.default -->

         

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
