    <!-- v2.0.1 -->

      <!-- Default box -->
      <?php
  
 
  include "module/connect.php"; 

 // Attempt select query execution
  $sql = "SELECT * FROM `getorders` WHERE ostatus = '1' AND rdytosell = '1' ORDER BY `timestamp` DESC";
  if($sql = mysqli_query($connection, $sql)){
    if(mysqli_num_rows($sql) > 0){
	 
      $num_rows = mysqli_num_rows($sql);
      echo $num_rows . "<br>";

                echo "<table border='1'>";
                  
        while($rowp = mysqli_fetch_array($sql)){

###################

//Format bought price (Buy price + makers fee ) 
$buyprice1=$rowp['price']*3/1000;  // makers fee 
$buyprice2=$rowp['price']+$buyprice1; // price buy + maker
$buyprice=number_format($buyprice2,11);  // format string
$fee=number_format($buyprice1,11);  // format string
  
//Format sub total amount 
$subtotal1=$rowp['price']*$rowp['quantity'];  //  
$subtotal=number_format($subtotal1,11);  // format string
 //Format total amount 
$total1=$subtotal+$rowp['fee'];  //  
$total=number_format($total1,11);  // format string

// Live Data From Ticker table
$sdf = $rowp['symbol'];
$sqlact = "SELECT * FROM ticker where symbol='".$sdf."'";
$resultact = mysqli_query($connection, $sqlact);
$rowwp = mysqli_fetch_array($resultact);
  

  
            echo "<tr>
                <td align='left'>Order " . $rowp['side'] . " # " . $rowp['clientOrderId'] . "
                <br>" . $rowp['symbol'] . "&nbsp;&nbsp;&nbsp;" . $astatuss . "
                <br>".$rowp['quantity']." ".$rowp['base']." @ " . $buyprice . " " . $rowp['quote'] . "
                <br>Total Cost: " . $total . " " . $rowp['quote'] . "
                <br>live price: " . $rowwp['bid'] . " " . $rowp['quote'] . "
                <br>  price to sell : " . $rowp['pricetosell'] . " 
                </td></tr>";
 
                // here if 10% reach 
                 // set rdy to sell status to 1
            echo "<tr><td>";
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
 // Data get from link
 $getId = $rowp['clientOrderId'];
 $getQty = $rowp['quantity'];
 $getSide = 'sell';
 $getType = 'limit';
 $getSellBuy = $rowp['pricetosell'];
 $sts = $rowp['symbol'];
 
 //currency base info
 $urlbase = "https://api.hitbtc.com/api/2/public/symbol/". $sts ."";
 $dataubase = json_decode(file_get_contents($urlbase), true);
 $base=$dataubase['baseCurrency']; // 'DOGE'btc
 $quote=$dataubase['quoteCurrency']; // doge'BTC'
 $qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol
    
 echo "Make sell at Price :".$getSellBuy." <br>";
    
 //order on
 // data to push to the API and database
 $price=number_format((float)$rowp['pricetosell'],$tick);
 $symbol=$sts;
 $side =$getSide;
 $type =$getType;
 $quantity=$getQty;
 $timeInForce= 'GTC'; 
 $date = Date("Y-m-d H:i:s");
   
  $ch = curl_init();
 //do a post
 curl_setopt($ch,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
 curl_setopt($ch, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
 curl_setopt($ch, CURLOPT_POST,1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
 curl_setopt($ch,CURLOPT_POSTFIELDS,"symbol=$symbol&side=$side&price=$price&quantity=$quantity&type=$type&timeInForce=$timeInForce");
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
 
    if ($result->status=='new') {
     $ostatus = '1';
   } elseif ($result->status=='partiallyFilled') {
     $ostatus = '1';
   } elseif ($result->status=='filled') {
     $ostatus = '2';
    }
  
  if (!empty($result->error)) {  
                                          foreach($result as $item) {   
                                            $errorbbt = "INSERT IGNORE INTO error(seq, error) 
                                              VALUES ('', 'API: Could not able to execute cron_Autosell.php <br>".$symbol."<br>".$item->code."<br>".$item->message."<br>')";                    
                                                      $resultbbt = $connection->query($errorbbt);
                                                      mysqli_free_result($resultbbt);
                                                                    } 
   
  } elseif (!empty($result->id)) { 
 
    
     $sqlinsert = "INSERT IGNORE INTO getorders(howto, id, orderId, clientOrderId, soldfor, ostatus, astatus, symbol, checkup, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, pnl, quote) 
     VALUES ('autosell', 
             '', 
             '".$result->id."', 
             '".$result->clientOrderId."',
             '".$getId."',
             '".$ostatus."',
             '".$result->status."',
             '".$result->symbol."',
             '',
             '".$result->side."',
             '".$result->type."',
             '".$result->timeInForce."',
             '".$result->quantity."',
             '".$result->cumQuantity."',
             '".$getSellBuy."',
             '".$result->createdAt."',
             '".$qtyinc."',
             '".$base."',
             'OK',
             '".$quote."'); ";
 // update order id
                   // must be placed in the foreach array of insert

                   // new or partially filled ostatus=1 ELSE ostatus=2 
                   
                   if ($result->status=='new') {
                    $ostatus='1';
                  }
                  if ($result->status=='partiallyFilled') {
                    $ostatus='1';
                  }
                  if ($result->status=='filled') {
                    $ostatus='2';
                  }
                  if ($result->status=='expired') {
                    $ostatus='1';
                  }

                    $sqloidup = "UPDATE stat set botorderid=botorderid +1";
                    $resultoid2 = $connection->query($sqloidup);
                    $resultoid3 = $connection->query($sqlinsert);
                     $sqlup2 = "UPDATE getorders set soldby='$result->clientOrderId', rdytosell='', checkup='', ostatus='$ostatus' WHERE clientOrderId='$getId'";
                    $resultoid5 = $connection->query($sqlup2);
                     //////
                     //////
                     //////
                     // if partially filled, buy deal is set to '2' unactive to avoid to be sell more than once, verify cancel button for partially filled sell deal 
                     // to set the buy deal ostatus to one if canceled/
                     //////
                     //////
                     //////
                     // put warn of the sale in db 
                     $spent=$result->quantity*$result->price;
                     $sqlinsert2 = "INSERT IGNORE INTO xinfo(warn) 
                     VALUES ('Autosell Bot Just Sold ".$result->quantity."x ".$result->symbol.", ".$spent." ".$quote;" Received.')";         
                     $spent2 = $connection->query($sqlinsert2);
                     
                    
             } ## end if no error
  
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
           echo "</td></tr>";
             
           
  
 
 
################### 

        }
        echo "</table>";
 
      
    } else{
        echo "No records matching your query were found.";
    }

} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
}
$sqlupcron = "UPDATE cron_time SET time  = NOW(), numbera=numbera +1 WHERE cron_name='sellready'";
$resultoidcron = $connection->query($sqlupcron);

  
  mysqli_close($connection);

?>

      <!-- /.default -->
 