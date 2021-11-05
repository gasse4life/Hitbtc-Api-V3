
 <?php
    
    include "module/connect.php"; 
   ///// 
              //////////////////   <!-- v2.0.1 -->

   //////////// PNL call when orders are closed ////////////////
              ////////////////// 
    // Attempt select query execution
    $sqlget = "SELECT * FROM `getorders` WHERE pnl = '0' AND side='buy' AND ostatus='2' AND astatus='filled' AND AvgPrice != '0' ORDER BY `seq` ASC LIMIT 10";
    if($resultget = mysqli_query($connection, $sqlget)){
       if(mysqli_num_rows($resultget) > 0){
      
           echo "<table border='1'>";
               echo "<tr>";
                echo "<th>seq</th>";
                echo "<th>clientOrderId</th>";
                echo "<th>Qty</th>";
                echo "<th>Price</th>";
                echo "<th>quote</th>";
                  echo "<th>Sold By</th>";
                 echo "<th>&nbsp&nbsp&nbsp&nbsp&nbsp--->&nbsp&nbsp&nbsp&nbsp&nbsp</th>";
                 echo "<th>seq2</th>";
                 echo "<th>clientOrderId 2</th>";
                 echo "<th>Price 2</th>";
                  echo "<th>Sold For</th>";
                echo "</tr>";
                echo "</table>";
                echo "<table border='1'>";
   
                  // fetch array
                                           
           while($rowpl = mysqli_fetch_array($resultget)){
               $sqlget2 = "SELECT * FROM `getorders` WHERE clientOrderId = '" . $rowpl['soldby'] . "'";
               $resultget2 = mysqli_query($connection, $sqlget2);
               $row2 = mysqli_fetch_array($resultget2);
    
                $amount1 = $rowpl['quantity']*$rowpl['price'];  
               $amount2 = $row2['quantity']*$row2['price']; 
               $pnltot0 = $amount2-$amount1;
               $pnltot=number_format($pnltot0,11);  // format string
                // ID as OrderID 
               echo "<tr>";
               echo "<td>" . $rowpl['seq'] . "</td>";
               echo "<td>" . $rowpl['clientOrderId'] . "</td>";
               echo "<td>" . $rowpl['quantity'] . "</td>"; 
               echo "<td>" . $rowpl['price'] . "</td>"; 
               echo "<td>" . $rowpl['quote'] . "</td>"; 
                echo "<td>" . $rowpl['soldby'] . "</td>"; 
               echo "<td>&nbsp&nbsp&nbsp&nbsp&nbsp--->&nbsp&nbsp&nbsp&nbsp&nbsp</td>"; 
    
                            echo "<td>" . $rowpl['seq'] . "</td>";
                            echo "<td>" . $rowpl['clientOrderId'] . "</td>";
                            echo "<td>" . $rowpl['quantity'] . "</td>"; 
                            echo "<td>" . $rowpl['price'] . "</td>"; 
                             echo "<td>" . $rowpl['soldfor'] . "</td>"; 
                             echo "</tr>";    
                             echo "<tr>";    
                             echo "<td>(qty1 * price1 = ". $amount1 .")</td>";    
                             echo "<td>&nbsp;&nbsp; - &nbsp;&nbsp;</td>";    
                             echo "<td>(qty2 * price2 = ". $amount2 .")</td>";    
                             echo "<td>= ". $pnltot . $rowpl['quote'] ."</td>";    
                             echo "</tr>"; 
   
                             echo "<tr>";    
                             echo "<td><br> </td>";    
                             echo "</tr>";    
     
                             $sqlinsert = "INSERT INTO calculprofit(symbol, pnlin, pnlout, total, quote, date) 
                             VALUES ('". $rowpl['symbol'] ."', 
                                     '". $rowpl['seq'] ."', 
                                     '". $row2['seq'] ."', 
                                     '". $pnltot ."', 
                                     '". $rowpl['quote'] ."', 
                                     NOW()); ";
   
                                            $resultoid3 = $connection->query($sqlinsert);
   
   
                                 $sqlupp = "UPDATE `getorders` SET pnl = 'OK' WHERE seq = '" . $rowpl['seq'] . "'";
                                  $resultsqlupp = $connection->query($sqlupp); 
                                  mysqli_free_result($resultsqlupp);
                                  mysqli_free_result($resultoid3);

                     
              
           }
           echo "</table>";
           mysqli_free_result($resultget);
           mysqli_free_result($resultget2);


       } else{
           echo "No records matching your query were found--   P&L.";
       }
   } else{
       echo "ERROR: Could not able to execute --    P&L." . mysqli_error($connection);
       $err = mysqli_error($connection);
    $errorasc = "INSERT INTO error(seq, error) 
    VALUES ('', 
            'ERROR: Could not able to execute. pnl_cron.php - ".$err."'); ";                    
            
            $resultasc = $connection->query($errorasc);
   }




   $sqlupcron = "UPDATE cron_time SET time  = NOW(), numbera=numbera +1 WHERE cron_name='pnl'";
$resultoidcron = $connection->query($sqlupcron);
   mysqli_close($connection);

   ?>