 
 <?php

  include "module/connect.php"; 
  
// Attempt select query 
   $sqll = "SELECT * FROM `bgl_getorders` WHERE autosell='1' AND side = 'buy' AND ostatus = '1' AND astatus = 'filled' AND checkup = '0' LIMIT 700";
  
 

  if($resultas = mysqli_query($connection, $sqll)){
    if(mysqli_num_rows($resultas) > 0){

       
 
        echo "
        <div class='card'> 
        <div class='card-body p-0'>
        <div class='table-responsive'>";
        
        echo "<div class='card'> 
        <div class='card-body p-0'>
        <div class='table-responsive'>
        <table class='table m-0'>";

        while($rowas = mysqli_fetch_array($resultas)){

          //currency base info
 $urlbase = "https://api.hitbtc.com/api/2/public/symbol/". $rowas['symbol'] ."";
 $dataubase = json_decode(file_get_contents($urlbase), true);
 $base=$dataubase['baseCurrency']; // 'DOGE'btc
 $quote=$dataubase['quoteCurrency']; // doge'BTC'
 $qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol
 $tickSize=$dataubase['tickSize'];
 $tick=strpos(strrev($tickSize), ".");
 
//max price sell 
$sellprice4=$rowas['price']*$rowas['percent']/100;  // price * % = X (amount to add to buy price)
$sellprice5=$rowas['price']+$sellprice4; // price buy + X = price to activate option
$sellprice6=number_format($sellprice5,$tick,".","");  // format string 
  
//activation option price  
$optprice4=$rowas['price']*$rowas['step1']/100;   
$optprice5=$rowas['price']+$optprice4; //  
$optprice=number_format($optprice5,$tick,".","");  // format string 
   
//loss option price  
$optprice11=$rowas['price']*$rowas['loss']/100;  //  
$optprice12=$rowas['price']+$optprice11; //  
$optpriceloss=number_format($optprice12,$tick,".","");  // format string 
 

// Live Data From Ticker table
$sdf = $rowas['symbol'];
$sqlactasc = "SELECT * FROM ticker where symbol='".$sdf."'";
$resasc = mysqli_query($connection, $sqlactasc);
$rowws = mysqli_fetch_array($resasc);
  

  
            echo "<tr>
                <td align='left'>" . $rowas['symbol'] . " -- > Order # " . $rowas['clientOrderId'] . "
                 <br>".$rowas['quantity']." ".$rowas['base']." @ " . $rowas['price'] . " " . $rowas['quote'] . "
                 <br>live price: " . $rowws['bid'] . " " . $rowas['quote'] . "<br><br>
                 percent: ".$rowas['percent']."  <br>
                 loss    ".$rowas['loss']."    <br>
                </td></tr>";


 
/////////////        
//////////////      
/////////////    
echo "<tr><td>";

               //////////////      
               //////////////  option ready      
               //////////////      

               // here if % reach  activate option gain loss
               //  
               if($rowws['bid'] >= $sellprice6){
                 $sqlsetready = "UPDATE bgl_getorders SET rdytosell='1', checkup='5', stopgain='".$sellprice6."', gostep='".$optprice."', stoploss='".$optpriceloss."' where seq='".$rowas['seq']."'";
                 $gosell = mysqli_query($connection, $sqlsetready);

                echo "ready to activate,  ";


               //////////////      
               //////////////   option no ready   
               //////////////      

               }else{
                // else only set check up status to 1 
                 $sqlsetcheckup = "UPDATE bgl_getorders SET checkup='1' where seq='".$rowas['seq']."'";
                 $checkup = mysqli_query($connection, $sqlsetcheckup); 
                echo "NO, checkup set to 1 ";
                    }
 
echo "</td></tr>"; 
/////////////
//////////////      
/////////////         









         } // end while row 
        echo "</table>
              </div><!-- /.table-responsive -->
              </div><!-- /.card-body -->
              </div>";

 
    } else{

        /////// 
        /////////////////////    reset of check up  
        /////////////////////    reset of check up  
        /////////////////////    reset of check up  
         $sqlreset = "UPDATE bgl_getorders SET checkup='0' WHERE checkup!='5' ";
                 $reset = mysqli_query($connection, $sqlreset);
                mysqli_free_result($reset);

        echo "No records matching your query were found.<br>Check up status reset";
    } 
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($connection);
    $err = mysqli_error($connection);
    $errorasc = "INSERT INTO error(seq, warn) 
    VALUES ('', 
            'ERROR: Could not able to execute. Autosellcheckup_bgl.php - ".$err."'); ";                    
            
            $resultasc = $connection->query($errorasc);
            mysqli_free_result($resultasc);

}
$sqlupcron = "UPDATE cron_time SET time  = NOW(), numbera=numbera +1 WHERE cron_name='sellcheck_bgl'";
                  $resultoidcron = $connection->query($sqlupcron);
 
mysqli_close($connection);


?>
    