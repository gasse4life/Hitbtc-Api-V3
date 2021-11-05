<?php
            //////////////////
 //////////// BOT BUY #1 ////////////////
           //////////////////   

include "module/connect.php";
  
?>    
    
     

      <!-- Default box -->
      <?php
   

 // Attempt select query execution
  $sql = "SELECT * FROM `bot_buy_1` WHERE `active` ='1' ORDER BY `symbol` ASC";
  if($sql = mysqli_query($connection, $sql)){
    if(mysqli_num_rows($sql) > 0){
	 
      $num_rows = mysqli_num_rows($sql);
      echo "Open Deal : " . $num_rows . "<br>";
       echo "";
      echo "<table border='1'>";
                  
        while($rowp = mysqli_fetch_array($sql)){

###################
 


// price Data From Ticker table (update every minute by cron job)
$sdf = $rowp['symbol'];
$sqlact = "SELECT * FROM ticker where symbol='".$sdf."'";
$resultact = mysqli_query($connection, $sqlact);
$rowwp = mysqli_fetch_array($resultact);
 
//currency base info
$urlbase = "SELECT * FROM symbol where id='".$sdf."'"; ###
$resurl = mysqli_query($connection, $urlbase);
$dataubase = mysqli_fetch_array($resurl);

$base=$dataubase['baseCurrency']; // 'DOGE'btc
$quote=$dataubase['quoteCurrency']; // doge'BTC'
$qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol
$tickSize=$dataubase['tickSize'];
$tick=strpos(strrev($tickSize), ".");
  
echo "<tr>";
echo "<td>Symbol to buy : " . $rowp['symbol'] . "<br></td>";
echo "<td>Next step : " . $rowp['nextstep'] . "<br></td>";
echo "<td>Percent : " . $rowp['percent'] . " %<br></td>";
echo "<td><img src='img/delete.png' width='25px'></td>";
echo "</tr>";
 
             echo "<tr><td>";
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
 if($rowwp['ask']<=$rowp['nextstep']) {  

 // Data get from link 
 $getSide = 'buy';
 $getType = 'limit'; 
 

     if($quote=='USD'){
     $amountperstep = $rowp['aps'];
     $aps=$amountperstep;  // format string

     }
     if($quote=='BTC'){
      $amountperstep = $rowp['aps'];
      $aps=$amountperstep;  // format string
   
     }
     if($quote=='EOS'){ 
      $amountperstep = $rowp['aps'];
      $aps=$amountperstep;  // format string
       
     }
     echo "Amount to buy per step : ".$aps."<br>";  
             
 //order on
 // data to push to the API and database
 $symbol=$rowp['symbol'];
 $side =$getSide;
 $type =$getType;
 $price=number_format((float)$rowwp['ask'],$tick,".","");
//quantity format
  $quantity4=$rowp['aps'];
  
 $timeInForce= 'GTC'; 
 $date = Date("Y-m-d H:i:s");
 echo "price to buy now : ".$price;

 
  $ch = curl_init();
 //do a post
 curl_setopt($ch,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
 curl_setopt($ch, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
 curl_setopt($ch, CURLOPT_POST,1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); 
 curl_setopt($ch,CURLOPT_POSTFIELDS,"symbol=$symbol&side=$side&price=$price&quantity=$quantity4&type=$type&timeInForce=$timeInForce");
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
 echo"end printr";
 //order end
 
    
     
  
 if (!empty($result->error)) { 
  foreach($result as $item) {  

                                               $errorbbt = "INSERT IGNORE INTO error(seq, error) 
                                                VALUES ('', 'ERROR: not able to execute. bot_buy_1.php <br>".$symbol."<br>".$item->code."<br>".$item->message."<br>".$price."<br>')";                    
                                                        $resultbbt = $connection->query($errorbbt);
                                                        mysqli_free_result($resultbbt);
  }

                } elseif (!empty($result->id)) { 
                          // set unactive if cronmin lower than result->price
                          if($rowwp['ask']<=$rowp['cronmin']) {
                            $unact = "UPDATE bot_buy_1 set active='0' WHERE seq='".$rowp['seq']."'";
                            $active = $connection->query($unact);    
                            mysqli_free_result($active);                   
                          }
                        // calcul percent for next buy step down 
                        //Format - % 
                        $nextprice1=$result->price*$rowp['percent']/100;  // % profit
                        $nextprice2=$result->price-$nextprice1; // price buy - %
                        $nextprice3=number_format((float)$nextprice2,$tick);  // format string
                         echo "<br> next price set to : ".$nextprice3 . '---'.$tick;
   
  
              $sqlinsert = "INSERT IGNORE INTO getorders(id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, timestamp, qtyinc, base, quote, autosell, percent, howto) 
             VALUES ('', 
             '".$result->id."', 
             '".$result->clientOrderId."',
             '1',
             '".$result->status."',
             '".$result->symbol."',
             '".$result->side."',
             '".$result->type."',
             '".$result->timeInForce."',
             '".$result->quantity."',
             '".$result->cumQuantity."',
             '".$result->price."',
             '".$result->createdAt."',
             '".$qtyinc."',
             '".$base."',
             '".$quote."',
             '1',
             '".$rowp['pnl']."',
             'b1'); ";
                 // update order id
                   // must be placed in the foreach array of insert
                    $sqloidup = "UPDATE stat set botorderid=botorderid +1";
                    $resultoid2 = $connection->query($sqloidup);
                    $resultoid3 = $connection->query($sqlinsert);
                     $sqlup2 = "UPDATE bot_buy_1 set nextstep='$nextprice3' WHERE seq='".$rowp['seq']."'";
                    $resultoid5 = $connection->query($sqlup2);
                    $deal = "UPDATE bot_buy_1 set deal=deal +1 WHERE seq='".$rowp['seq']."'";
                    $resultdeal = $connection->query($deal);
                    mysqli_free_result($resultdeal);
                    mysqli_free_result($resultoid2);
                    mysqli_free_result($resultoid3);
                    mysqli_free_result($resultoid5);
                    

                      // put warn of the sale in db 
                      $spent=$result->quantity*$result->price;
                      $sqlinsert2 = "INSERT IGNORE INTO xinfo(warn) 
                      VALUES ('B-Bot 1 Just Bought ".$result->quantity."x ".$result->symbol.", ".$spent." ".$quote;" spent ')";         
                      $spent2 = $connection->query($sqlinsert2);

             } ## end if no error
 
                  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
              echo "</td></tr>";
             
           
                  mysqli_free_result($resultact);
               mysqli_free_result($resultnext);
 
      }
          

 
 


###################

        }
        echo "</table>";
        $sqlupcron = "UPDATE cron_time SET time  = NOW(), numbera=numbera +1 WHERE cron_name='botb1'";
        $resultoidcron = $connection->query($sqlupcron);    

        mysqli_free_result($sql);

    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
}
 
 
mysqli_close($connection);



?>

      <!-- /.default -->
 
