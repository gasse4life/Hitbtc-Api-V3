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
 $sqlget = "SELECT * FROM `getorders` WHERE fee = '' AND astatus='filled' ORDER BY `seq` DESC LIMIT 10";
 if($resultget = mysqli_query($connection, $sqlget)){
    if(mysqli_num_rows($resultget) > 0){
	 
        echo "<table border='1'>";
            echo "<tr>";
            echo "<th>seq</th>";
             echo "<th>OrderId</th>";
            echo "<th>Fee</th>";
                echo "</tr>";
               // fetch array
        while($row = mysqli_fetch_array($resultget)){
             // extract data from those extract before
          //////////////////
//////////// status call ////////////////
           //////////////////

           include "connect.php"; 

           $curlSwitch = curl_init();
           curl_setopt_array($curlSwitch, [
               CURLOPT_URL => 'https://api.hitbtc.com/api/2/history/order/' . $row['orderId'] . '/trades',    //  
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_HTTPHEADER => ['Authorization: Basic ' . base64_encode($userName . ':' . $password)],
           ]);
           
           $responseSwitch = curl_exec($curlSwitch);
           curl_close($curlSwitch);
           $arraySwitch =  json_decode($responseSwitch, true);  //Convert JSON String into PHP Array
                    
          echo $responseSwitch;
          foreach($arraySwitch as $rowS) //Extract the Array Values by using Foreach Loop
          { 
            // ID as OrderID
                         echo "<tr>";
                         echo "<td>" . $rowS['seq'] . "</td>";
                         echo "<td>" . $rowS['orderId'] . "</td>";
                         echo "<td>" . $rowS['fee'] . "</td>"; 
                           echo "</tr>";     
          }
        
          //    $sqlupp = "UPDATE `getorders` SET fee = '" . $roww['fee'] . "' WHERE seq = '" . $row['seq'] . "'";
                      if(mysqli_multi_query($connection, $sqlupp)) //Run Mutliple Insert Query
                   {
                  echo '<br /><span class="right badge badge-success">Fee imported in database</span>';
                } else { echo "<span class='right badge badge-danger'>Error UPDATE fee into database : </span>" . $connection->error;
                        } 
  
                       mysqli_close($connection);
              
            
        }
        echo "</table>";
  
    } else{
        echo "No records matching your query were found--   Fee.";
    }
} else{
    echo "ERROR: Could not able to execute --    Fee." . mysqli_error($connection);
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
