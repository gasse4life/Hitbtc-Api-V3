<!DOCTYPE html>
<html lang="en">
<?php  include "module/head.php"; ?>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  

 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
   

    <!-- Main content -->
    <section class="content">

















      <!-- Default box -->
      <?php
 include "connect.php"; 
///// 
 //// must rename declaration
 
 // Attempt select query execution
 $sqlget = "SELECT * FROM `getorders` WHERE pnl = '' AND ostatus='2' AND side='buy' ORDER BY `seq` DESC LIMIT 10";
 if($resultget = mysqli_query($connection, $sqlget)){
    if(mysqli_num_rows($resultget) > 0){
	 
        echo "<table border='1'>";
            echo "<tr>";
            echo "<th>seq</th>";
             echo "<th>clientOrderId</th>";
             echo "<th>Avg Price</th>";
             echo "<th>Fee</th>";
             echo "<th>Sold By</th>";
             echo "<th>&nbsp&nbsp&nbsp&nbsp&nbsp--->&nbsp&nbsp&nbsp&nbsp&nbsp</th>";
             echo "<th>seq2</th>";
             echo "<th>clientOrderId 2</th>";
             echo "<th>Avg Price 2</th>";
             echo "<th>Fee 2</th>";
             echo "<th>Sold For</th>";
             echo "</tr>";
             echo "</table>";
             echo "<table border='1'>";

               // fetch array
                                        
        while($row = mysqli_fetch_array($resultget)){
            $sqlget2 = "SELECT * FROM `getorders` WHERE clientOrderId = " . $row['soldby'] . "";
            $resultget2 = mysqli_query($connection, $sqlget2);
            $row2 = mysqli_fetch_array($resultget2);
 
            $amount1 = $row['quantity']*$row['AvgPrice'];  
            $amount2 = $row2['quantity']*$row2['AvgPrice']; 
            $pnltot0 = $amount2-$amount1;
            $pnltot=number_format($pnltot0,11);  // format string
           // if($row2['fee']=='') {} else {
            // ID as OrderID 
            echo "<tr>";
            echo "<td>" . $row['seq'] . "</td>";
            echo "<td>" . $row['clientOrderId'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>"; 
            echo "<td>" . $row['AvgPrice'] . "</td>"; 
            echo "<td>" . $row['quote'] . "</td>"; 
             echo "<td>" . $row['soldby'] . "</td>"; 
            echo "<td>&nbsp&nbsp&nbsp&nbsp&nbsp--->&nbsp&nbsp&nbsp&nbsp&nbsp</td>"; 
 
                         echo "<td>" . $row2['seq'] . "</td>";
                         echo "<td>" . $row2['clientOrderId'] . "</td>";
                         echo "<td>" . $row2['quantity'] . "</td>"; 
                         echo "<td>" . $row2['AvgPrice'] . "</td>"; 
                          echo "<td>" . $row2['soldfor'] . "</td>"; 
                          echo "</tr>";    
                          echo "<tr>";    
                          echo "<td>(qty1 * avGprice1 = ". $amount1 .")</td>";    
                          echo "<td>&nbsp;&nbsp; - &nbsp;&nbsp;</td>";    
                          echo "<td>(qty2 * avGprice2 = ". $amount2 .")</td>";    
                          echo "<td>= ". $pnltot . $row['quote'] ."</td>";    
                          echo "</tr>"; 

                          echo "<tr>";    
                          echo "<td><br> </td>";    
                          echo "</tr>";    
 
                          $sqlinsert = "INSERT INTO calculprofit(symbol, pnlin, pnlout, total, quote) 
                          VALUES ('". $row['symbol'] ."', 
                                  '". $row['seq'] ."', 
                                  '". $row2['seq'] ."', 
                                  '". $pnltot ."', 
                                  '". $row['quote'] ."'); ";

                                         $resultoid3 = $connection->query($sqlinsert);


                         $sqlupp = "UPDATE `getorders` SET pnl = 'OK' WHERE seq = '" . $row['seq'] . "'";
                      if(mysqli_multi_query($connection, $sqlupp)) //Run Mutliple Insert Query
                    {
                  echo '<br /><span class="right badge badge-success">pnl1 update in database</span>';
                 } else { echo "<span class='right badge badge-warning'>Error UPDATE pnl1 update into database : </span>" . $connection->error;
                        } 

                             $sqlupp2 = "UPDATE `getorders` SET pnl = 'OK' WHERE seq = '" . $row2['seq'] . "'";
                      if(mysqli_multi_query($connection, $sqlupp2)) //Run Mutliple Insert Query
                    {
                 echo '<br /><span class="right badge badge-success">pnl2 update in database</span>';
                 } else { echo "<span class='right badge badge-warning'>Error UPDATE pnl2 update into database : </span>" . $connection->error;
                        } 
  
               
            //  }  
          
        }
        echo "</table>";
  
    } else{
        echo "No records matching your query were found--   P&L.";
    }
} else{
    echo "ERROR: Could not able to execute --    P&L." . mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
  
?>

      <!-- /.default -->



















    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   
 
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

 
<?php include "module/script.php"; ?>

</body>
</html>
