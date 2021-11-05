<?php
 include "module/connect.php"; 
///// 
  
           //////////////////   <!-- v2.0.1 -->

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
 
###################
###################
###################
###################
###################

//////////// status call BGL ////////////////
           //////////////////
 // Attempt select query execution
 $selectql = "SELECT * FROM `bgl_getorders` WHERE astatus = 'expired' OR astatus = 'partiallyFilled' OR astatus = 'new' OR AvgPrice='0' ORDER BY `seq` DESC";
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
                   $sqlup = "UPDATE bgl_getorders SET astatus = '" . $roww['status'] . "', price = '" . $roww['price'] . "', cumQuantity = '" . $roww['cumQuantity'] . "' WHERE seq = '" . $row['seq'] . "'";
                   if(mysqli_multi_query($connection, $sqlup))  {  echo '<br /><br />New status updated<br />';  } else { echo "<br /><br />Error importing ostatus into database : " . $connection->error; } 
                       }  
 
                   if ($roww['status']=='expired') {
                   $sqlup = "UPDATE bgl_getorders SET ostatus = '1', astatus = 'expired', AvgPrice = '" . $roww['price'] . "', quantity = '" . $roww['cumQuantity'] . "' WHERE seq = '" . $row['seq'] . "'";
                   if(mysqli_multi_query($connection, $sqlup))  {  echo '<br /><br />New status updated<br />';  } else { echo "<br /><br />Error importing ostatus into database : " . $connection->error; } 
                       } 
                  
                   if ($roww['status']=='partiallyFilled') {
                       $sqlup = "UPDATE bgl_getorders SET astatus = '" . $roww['status'] . "', price = '" . $roww['price'] . "', cumQuantity = '" . $roww['cumQuantity'] . "' WHERE seq = '" . $row['seq'] . "'";
                     if(mysqli_multi_query($connection, $sqlup))  {  echo '<br /><br />New status updated<br />';  } else { echo "<br /><br />Error importing ostatus into database : " . $connection->error; } 
                   }
                    
                   if ($roww['status']=='filled') {
                     if ($roww['side']=='sell' & $roww['status']=='filled') { $ostatus='2'; 
                       $sqlup4 = "UPDATE bgl_getorders set ostatus='2' WHERE clientOrderId='".$row['soldfor']."'";
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
                                      
   $sqlinsert = "UPDATE bgl_getorders set ostatus='".$ostatus."', astatus='".$roww['status']."', quantity='".$roww['quantity']."', cumQuantity = '" . $roww['cumQuantity'] . "', price='".$roww['price']."', AvgPrice='".$roww['avgPrice']."' WHERE seq = '" . $row['seq'] . "'";
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

 



echo "Upadating Status Crypto Maker Bot <br><br>";

 $sql = "SELECT * FROM coincreator WHERE status='partiallyFilled' OR status='new'";
$result = mysqli_query($connection, $sql);
// extract of each order
while($row = mysqli_fetch_array($result)){
 
echo "" . $row['seq'] . " " . $row['symbol'] . " " . $row['price'] . " <br>";

$cryptomaker = curl_init();
            curl_setopt_array($cryptomaker, [
                CURLOPT_URL => 'https://api.hitbtc.com/api/2/history/order?clientOrderId='.$row['clientOrderId'].'',    // max limit = 1000
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 2, 
                CURLOPT_SSL_VERIFYPEER => false, 
                CURLOPT_HTTPHEADER => ['Authorization: Basic ' . base64_encode($userName . ':' . $password)],
            ]);
            
            $responsecm = curl_exec($cryptomaker);
            curl_close($cryptomaker);
            $arraycm =  json_decode($responsecm, true);  //Convert JSON String into PHP Array
                    
            //echo $responsecm;
            print_r($responsecm);

                    foreach($arraycm as $rowcm) //Extract the Array Values by using Foreach Loop
                      {
                        if ($rowcm['status']=='new') {
                          $sqlup = "UPDATE coincreator SET status = '" . $rowcm['status'] . "', cumQuantity = '" . $rowcm['cumQuantity'] . "' WHERE seq = '" . $row['seq'] . "'";
                        if(mysqli_multi_query($connection, $sqlup))  {  echo '<br /><br />New status updated<br />';  } else { echo "<br /><br />Error importing ostatus into database : " . $connection->error; } 
                      } 
                     
                      if ($rowcm['status']=='partiallyFilled') {
                          $sqlup = "UPDATE coincreator SET status = '" . $rowcm['status'] . "', cumQuantity = '" . $rowcm['cumQuantity'] . "' WHERE seq = '" . $row['seq'] . "'";
                        if(mysqli_multi_query($connection, $sqlup))  {  echo '<br /><br />New status updated<br />';  } else { echo "<br /><br />Error importing ostatus into database : " . $connection->error; } 
                      }
                      
                      if ($rowcm['status']=='filled') {
                          
                      $sqlcm = "UPDATE coincreator set status='".$rowcm['status']."', cumQuantity = '" . $rowcm['cumQuantity'] . "' WHERE seq = '" . $row['seq'] . "'";
                      if(mysqli_multi_query($connection, $sqlcm))  {  echo '<br /><br />New status updated<br />';  } else { echo "<br /><br />Error importing ostatus into database : " . $connection->error; } 

     
                      }

                    // end foreach arraycm
                    }

// end extract

echo "<hr>";
}

////
////
////

 // update number in cron time
 $sqlupp = "UPDATE `cron_time` SET time  = NOW(), numbera = numbera +1 WHERE cron_name = 'cryptomaker'";
                                  $resultsqlupp = $connection->query($sqlupp); 
                                  mysqli_free_result($resultsqlupp);
/////
/////
/////

echo "Autosell if Ready<br><br>";


$sqlas = "SELECT * FROM coincreator WHERE status='filled'";
$resultas = mysqli_query($connection, $sqlas);
// extract of each order
while($rowas = mysqli_fetch_array($resultas)){

echo $rowas['symbol']."<br>Price buy: ".$rowas['pricebuy']."<br>Goal10: ".$rowas['goal10']."<br>";
                    
                    //bid price
                    $url = "https://api.hitbtc.com/api/2/public/ticker/". $rowas['symbol'] ."";
                    $dataticker = json_decode(file_get_contents($url), true);
                    $bid=$dataticker['bid']; // buy price
                    echo "Market Price:".$bid;
                 // if price buy < market price   
                 if($rowas['goal10'] <= $bid){
                                                                                            // perform if ready to sell
                                                                                            // data to push to the API and database
                                                                                            $timeInForce = 'GTC'; 
                                                                                            $inSymbol = $rowas['symbol'];
                                                                                            $inQty = $rowas['qty']-($rowas['qty']*10/100);
                                                                                            $inPrice = $bid;
                                                                                            $type = 'limit';
                                                                                            $side = 'sell';
                                                                                                                                                                                        
                                                                                            $ch = curl_init();
                                                                                            //do a post
                                                                                            curl_setopt($ch,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
                                                                                            curl_setopt($ch, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
                                                                                            curl_setopt($ch, CURLOPT_POST,1);
                                                                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
                                                                                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
                                                                                            curl_setopt($ch,CURLOPT_POSTFIELDS,"symbol=$inSymbol&side=$side&price=$inPrice&quantity=$inQty&type=$type&timeInForce=$timeInForce");
                                                                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                                                                                            //return the result of curl_exec,instead
                                                                                            //of outputting it directly
                                                                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                                                                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
                                                                                            //curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
                                                                                            $result=curl_exec($ch);
                                                                                            curl_close($ch);
                                                                                            $result=json_decode($result);
                                                                                            echo"<pre>";
                                                                                            print_r($result);
                                                                                            //order end
                                                                                            
                                                                                            ///####################
                                                                                                            if (!empty($result->error)) { 
                                                                                                              foreach($result as $item) {  
                                                                                                                 $errorbbt = "INSERT IGNORE INTO error(seq, error) 
                                                                                                                  VALUES ('', 'ERROR: Could not able to execute. cron_status_cm <br>".$symbol."<br>".$item->code."<br>".$item->message."<br>')";                    
                                                                                                                          $resultbbt = $connection->query($errorbbt);
                                                                                                                          mysqli_free_result($resultbbt);
                                                                                                                      } 
                                                                                                            } else { 
                                                                                                                // set status to sold (truncate)
                                                                                                                   $delete="DELETE FROM `coincreator` WHERE `seq` = ".$rowas['seq']."";
                                                                                                                   $resultdel = mysqli_query($connection, $delete);
                                                                                                                // update order id in stat
                                                                                                                   $sqloidup = "UPDATE stat set botorderid=botorderid +1";
                                                                                                                   $resultoid2 = $connection->query($sqloidup);
                                                                                                                // add the 10% to free zone in database
                                                                                                                   $free=$rowas['qty']*10/100;
                                                                                                                   $sqlinsert = "INSERT IGNORE INTO freezone(createdBy, symbol, qty, pricebuy) 
                                                                                                                   VALUES ('Crypto Maker Bot', 
                                                                                                                        '".$rowas['symbol']."', 
                                                                                                                        '".$free."', 
                                                                                                                        '".$rowas['pricebuy']."'); ";
                                                                                                                   $resultoid3 = $connection->query($sqlinsert);
                                                                                                                // put warn of the sale in db
                                                                                                                   $free=$rowas['qty']*10/100;
                                                                                                                   $sqlinsert2 = "INSERT IGNORE INTO winfo(warn) 
                                                                                                                   VALUES ('CM-Bot Just Sold ".$result->quantity."x ".$result->symbol.", ".$free." coin inserted in the free zone ')";         
                                                                                                                   $spent2 = $connection->query($sqlinsert2);

                                                                                                                   }
                                        
                 }else{
                     echo "<br> Not Ready";
                 }

echo "<hr>";
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

?>


