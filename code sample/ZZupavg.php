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
 
 
 // Attempt select query execution
$sqlget = "SELECT * FROM `getorders` WHERE astatus = 'filled' AND AvgPrice = '' ORDER BY `seq` DESC LIMIT 100";
if($resultget = mysqli_query($connection, $sqlget)){
    if(mysqli_num_rows($resultget) > 0){
	 
        echo "<table border='1'>";
            echo "<tr>";
            echo "<th>seq</th>";
            echo "<th>orderId</th>";
            echo "<th>clientOrderId</th>";
            echo "<th> Price</th>";
            echo "<th>Avg Price</th>";
            echo "<th>avg Price</th>";
            echo "<th>clientOrderId</th>";
            echo "</tr>";
               // fetch array
        while($row = mysqli_fetch_array($resultget)){
  
// extract data from those extract before
          //////////////////
//////////// status call ////////////////
           //////////////////

           include "connect.php"; 

           $curlSecondavg = curl_init();
           curl_setopt_array($curlSecondavg, [
               CURLOPT_URL => 'https://api.hitbtc.com/api/2/history/order?limit=100&clientOrderId='.$row['clientOrderId'].'',    // max limit = 1000
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_HTTPHEADER => ['Authorization: Basic ' . base64_encode($userName . ':' . $password)],
           ]);
           
           $responseavg = curl_exec($curlSecondavg);
           curl_close($curlSecondavg);
           $arrayavg =  json_decode($responseavg, true);  //Convert JSON String into PHP Array
                    
            // echo $responseavg;
                     foreach($arrayavg as $roww) //Extract the Array Values by using Foreach Loop
                     {
            // ID as OrderID
                         echo "<tr>";
                 //        echo "<td>" . $row['seq'] . "</td>";
                 //        echo "<td>" . $row['orderId'] . "</td>";
                 //        echo "<td>" . $row['clientOrderId'] . "</td>";
                 //        echo "<td>" . $row['price'] . "</td>";
                 //        echo "<td>" . $row['AvgPrice'] . "</td>";
                 //        echo "<td>" . $roww['avgPrice'] . "</td>"; 
                 //       echo "<td>" . $roww['clientOrderId'] . "</td>";
                        echo "</tr>";    
                         $sqlupp = "UPDATE `getorders` SET AvgPrice = '" . $roww['avgPrice'] . "', price = '" . $roww['price'] . "' WHERE seq = '" . $row['seq'] . "'";
                       
 
                    }
                       
                     if(mysqli_multi_query($connection, $sqlupp)) //Run Mutliple Insert Query
                    {
                  echo '<br /><span class="right badge badge-success">New price & aVg imported in database</span>';
                 } else { echo "<span class='right badge badge-warning'>Error UPDATE price & aVg into database : </span>" . $connection->error;
                        } 
  
                      // close conn after insert data
                      mysqli_close($connection);
             
// end extract data
 
            // end fetch array
        }
        echo "</table>";
  
    } else{
        echo "No records matching your query were found--price & aVg.";
    }
} else{
    echo "ERROR: Could not able to execute -- price & aVg" . mysqli_error($connection);
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
