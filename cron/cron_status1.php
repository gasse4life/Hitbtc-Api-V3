<?php
 include "connect.php"; 
///// 
 #################
#################
#################
#################
#################
//////////// status call ////////////////
           //////////////////
 // Attempt select query execution
$selectql = "SELECT * FROM `getorders` WHERE astatus = 'expired' OR astatus = 'partiallyFilled' OR astatus = 'new' OR AvgPrice='0' ORDER BY `seq` DESC";
if($result = mysqli_query($connection, $selectql)){
    if(mysqli_num_rows($result) > 0){
	 
        echo "<table border='1'>";
            echo "<tr>";
            echo "<th>seq</th>";
              echo "<th>orderId</th>";
              echo "<th>clientOrderId</th>";
            echo "<th>Qty</th>";
            echo "<th>Status</th>";
                echo "<th>Side</th>";
                echo "<th>New Status</th>";
                echo "<th>cumQty</th>";
                echo "<th>ID as OrderID</th>";
                echo "<th>Sold By</th>";
                echo "<th>Sold For</th>";
               echo "</tr>";
               // fetch array
        while($row = mysqli_fetch_array($result)){
  
           $chupst = curl_init();
           curl_setopt_array($chupst, [
               CURLOPT_URL => 'https://api.hitbtc.com/api/2/history/order?limit=100&clientOrderId='.$row['clientOrderId'].'',    // max limit = 1000
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_SSL_VERIFYHOST => 2, 
               CURLOPT_SSL_VERIFYPEER => false, 
               CURLOPT_HTTPHEADER => ['Authorization: Basic ' . base64_encode($userName . ':' . $password)],
           ]);
           
           $responsech = curl_exec($chupst);
           curl_close($chupst);
           $arraych =  json_decode($responsech, true);  //Convert JSON String into PHP Array
                    
            echo $responsech;
                     foreach($arraych as $roww) //Extract the Array Values by using Foreach Loop
                     {
            // ID as OrderID
                        echo "<tr>";
                        echo "<td>" . $row['seq'] . "</td>";
                        echo "<td>" . $row['orderId'] . "</td>";
                        echo "<td>" . $row['clientOrderId'] . "</td>";
                        echo "<td>" . $roww['quantity'] . "</td>";//
                        echo "<td>" . $row['astatus'] . "</td>";
                        echo "<td>" . $row['side'] . "</td>";
                        echo "<td>" . $roww['status'] . "</td>";
                        echo "<td>" . $roww['cumQuantity'] . "</td>"; //
                        echo "<td>" . $roww['id'] . "</td>";
                        echo "<td>" . $row['soldby'] . "</td>";
                        echo "<td>" . $row['soldfor'] . "</td>";
                        echo "</tr>";    

                  if ($roww['status']=='new') {
                  $sqlup = "UPDATE getorders SET astatus = '" . $roww['status'] . "', price = '" . $roww['price'] . "', cumQuantity = '" . $roww['cumQuantity'] . "' WHERE seq = '" . $row['seq'] . "'";
                  if(mysqli_multi_query($connection, $sqlup))  {  echo '<br /><br />New status updated<br />';  } else { echo "<br /><br />Error importing ostatus into database : " . $connection->error; } 
                      }  

                  if ($roww['status']=='expired') {
                  $sqlup = "UPDATE getorders SET ostatus = '1', astatus = 'expired', AvgPrice = '" . $roww['price'] . "', quantity = '" . $roww['cumQuantity'] . "' WHERE seq = '" . $row['seq'] . "'";
                  if(mysqli_multi_query($connection, $sqlup))  {  echo '<br /><br />New status updated<br />';  } else { echo "<br /><br />Error importing ostatus into database : " . $connection->error; } 
                      } 
                 
                  if ($roww['status']=='partiallyFilled') {
                      $sqlup = "UPDATE getorders SET astatus = '" . $roww['status'] . "', price = '" . $roww['price'] . "', cumQuantity = '" . $roww['cumQuantity'] . "' WHERE seq = '" . $row['seq'] . "'";
                    if(mysqli_multi_query($connection, $sqlup))  {  echo '<br /><br />New status updated<br />';  } else { echo "<br /><br />Error importing ostatus into database : " . $connection->error; } 
                  }
                   
                  if ($roww['status']=='filled') {
                    if ($roww['side']=='sell' & $roww['status']=='filled') { $ostatus='2'; 
                      $sqlup4 = "UPDATE getorders set ostatus='2' WHERE clientOrderId='".$row['soldfor']."'";
                      $resultoid7 = $connection->query($sqlup4);
                      mysqli_free_result($resultoid7);
                    }


                      if ($roww['side']=='buy') { $ostatus='1'; }
    
                      // ID as OrderID
                      echo "<tr>";
              echo "<th>id</th>";
               echo "<th>clientOrderId</th>";
                   echo "<th>qty</th>";
                  echo "<th>price</th>";
                  echo "<th>fee</th>";
                  echo "</tr>";
                                   echo "<tr>";
                                   echo "<td>" . $roww['id'] . "</td>";
                                    echo "<td>" . $roww['clientOrderId'] . "</td>";
                                    echo "<td>" . $roww['quantity'] . "</td>";
                                   echo "<td>" . $roww['price'] . "</td>";
                                   echo "<td>" . $roww['avgPrice'] . "</td>";
                                    echo "<td>" . $ostatus . "</td>";
                                     echo "</tr>";   
                                     
  $sqlinsert = "UPDATE getorders set ostatus='".$ostatus."', astatus='".$roww['status']."', quantity='".$roww['quantity']."', cumQuantity = '" . $roww['cumQuantity'] . "', price='".$roww['price']."', AvgPrice='".$roww['avgPrice']."' WHERE seq = '" . $row['seq'] . "'";
  $resultins = $connection->query($sqlinsert);
  mysqli_free_result($resultins);

                
                  }
  
                    }
                  
// end extract data
  
            // end fetch array
        }
        echo "</table>";
      
    } else{
        echo "No records matching your query were found.";
    }

    mysqli_free_result($result);

} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($connection);
}
#################
#################
#################
#################
#################
#################

$sqlupcron = "UPDATE cron_time SET time  = NOW(), numbera=numbera +1 WHERE cron_name='status'";
$resultoidcron = $connection->query($sqlupcron);
mysqli_close($connection);
header('Location: http://localhost/v3/cron/cron_status2.php');


?>