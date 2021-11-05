  <?php
  
 
  include "module/connect.php"; 

 // Attempt select query execution
  $sql = "SELECT * FROM `bgl_getorders` WHERE ostatus = '1' AND rdytosell = '1' ORDER BY `timestamp` DESC";
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
   

// Live Data From Ticker table
$sdf = $rowp['symbol'];
$sqlact = "SELECT * FROM ticker where symbol='".$sdf."'";
$resultact = mysqli_query($connection, $sqlact);
$rowwp = mysqli_fetch_array($resultact);
  

  
            echo "<tr>
                <td align='left'>Order " . $rowp['side'] . " # " . $rowp['clientOrderId'] . "
                <br>" . $rowp['symbol'] . "&nbsp;&nbsp;&nbsp;" . $astatuss . "
                <br>".$rowp['quantity']." ".$rowp['base']." @ " . $buyprice . " " . $rowp['quote'] . "
                 <br>live price: " . $rowwp['bid'] . " " . $rowp['quote'] . "<br><br>
                 
                 stop gain     ".$rowp['stopgain']."    <br>
                 go step    ".$rowp['gostep']."    <br>
                 stop loss    ".$rowp['stoploss']."    <br>
                </td></tr>";
 
             echo "<tr><td>";
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($rowwp['bid'] >= $rowp['stopgain']){
  ///////////////MAXX sell it
                                        ////////////////
                                        ///////////////
                                        //////////////
                                      
                                        ////////////////
                                        ///////////////
                                        //////////////

}elseif($rowwp['bid'] >= $rowp['gostep']){
  ///////////////higher but not max, so update new data
                                        ////////////////
                                        ///////////////
                                        //////////////

                                        ////////////////
                                        ///////////////
                                        //////////////



}elseif($rowwp['bid'] <= $rowp['stoploss']){
  ///////////////will be sell if the stop loss reached
                                        ////////////////
                                        ///////////////
                                        ////////////// 
                                        
                                        //////////////
                                        /////////////
                                        /////////////
}else{
  echo "waiting move but ready to sell";
}
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
 