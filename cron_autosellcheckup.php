   <!-- v2.0.1 -->
 
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        
           <!-- Default box -->
          
 <?php

 echo "<img src='img/warnico.png' width='20px'>Some Data are Update every minute.<br>";
 include "module/connect.php"; 
 ///// 
 // $getSide = $_GET['Side'];
 // $getStatus = $_GET['Status'];
  
/* Begin Paging Info */
 
//$sqlcount = "select count(*) as total_records from getorders";
//$total_records = $rowas['total_records'];  // total orders count
 

// Attempt select query 
   $sqll = "SELECT * FROM `getorders` WHERE autosell='1' AND side = 'buy' AND ostatus = '1' AND astatus = 'filled' AND checkup = '0' LIMIT 700";
  
 

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

//Format bought price (Buy price + makers fee ) 
$buyprice1=$rowas['price']*3/1000;  // makers fee 
$buyprice2=$rowas['price']+$buyprice1; // price buy + maker
$buyprice=number_format($buyprice2,11,".","");  // format string
$fee=number_format($buyprice1,11,".","");  // format string
//Format profit price (% define by database) 
$sellprice4=$rowas['price']*$rowas['percent']/100;  // price * % = X (amount to add to buy price)
$sellprice5=$rowas['price']+$sellprice4; // price buy + X = price to sell
$sellprice6=number_format($sellprice5,$tick,".","");  // format string




//Format sub total amount 
$subtotal1=$rowas['price']*$rowas['quantity'];  //  
$subtotal=number_format($subtotal1,11,".","");  // format string
 //Format total amount 
$total1=$subtotal+$rowas['fee'];  //  
$total=number_format($total1,11,".","");  // format string

// Live Data From Ticker table
$sdf = $rowas['symbol'];
$sqlactasc = "SELECT * FROM ticker where symbol='".$sdf."'";
$resasc = mysqli_query($connection, $sqlactasc);
$rowws = mysqli_fetch_array($resasc);
  

  
            echo "<tr>
                <td align='left'>Order " . $rowas['side'] . " # " . $rowas['clientOrderId'] . "
                <br>" . $rowas['symbol'] . "
                <br>".$rowas['quantity']." ".$rowas['base']." @ " . $rowas['price'] . " " . $rowas['quote'] . "
                <br>Total Cost: " . $rowas['price'] . " " . $rowas['quote'] . "
                <br>live price: " . $rowws['bid'] . " " . $rowas['quote'] . "
                </td></tr>";
 
                // here if % reach 
                 // set rdy to sell status to 1
            echo "<tr><td>";
            if($rowws['bid'] >= $sellprice6){
                $sqlsetready = "UPDATE getorders SET rdytosell='1', checkup='1', pricetosell='".$sellprice6."' where seq='".$rowas['seq']."'";
                $gosell = mysqli_query($connection, $sqlsetready);

                echo "ready to sell, rdytosell set to 1";
               }else{
// else only set check up status to 1 
                $sqlsetcheckup = "UPDATE getorders SET checkup='1' where seq='".$rowas['seq']."'";
                $checkup = mysqli_query($connection, $sqlsetcheckup);

                echo "NO, checkup set to 1,";
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
        $sqlreset = "UPDATE getorders SET checkup='0'";
                $reset = mysqli_query($connection, $sqlreset);
                mysqli_free_result($reset);

        echo "No records matching your query were found.<br>Check up status reset";
    } 
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($connection);
    $err = mysqli_error($connection);
    $errorasc = "INSERT INTO werror(seq, warn) 
    VALUES ('', 
            'ERROR: Could not able to execute. Autosellcheckup.php - ".$err."'); ";                    
            
            $resultasc = $connection->query($errorasc);
            mysqli_free_result($resultasc);

}
$sqlupcron = "UPDATE cron_time SET time  = NOW(), numbera=numbera +1 WHERE cron_name='sellcheck'";
                  $resultoidcron = $connection->query($sqlupcron);
 
mysqli_close($connection);


?>
      <!-- /.default -->

         
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
   
  <!-- /.content-wrapper -->
 