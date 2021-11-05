<?php  include "module/connect.php"; 

$sql = "SELECT * FROM coincreator ORDER BY `seq` DESC";
$result = mysqli_query($connection, $sql);
while($row = mysqli_fetch_array($result)){
    
// Live Data From Ticker table
$sdf = $row['symbol'];
$marketprice = "SELECT * FROM ticker where symbol='".$sdf."'";
$mp = mysqli_query($connection, $marketprice);
$rowmp = mysqli_fetch_array($mp);
 

 
    echo "
    <table align='center'>
    <tr>
    <td>".$row['base']." => ".$row['quote']."</td> 
    <td>&nbsp;&nbsp;&nbsp;</td> <td>x".$row['qty']."</td> 
    <td>&nbsp;&nbsp;&nbsp;</td> 
    <td>Status => ".$row['status']."</td>
    </tr>
    </table>
     <table align='center'>
    <tr>
    <td>At Price<br> ".$row['pricebuy']."</td> 
    <td>&nbsp;&nbsp;&nbsp;</td> 
    <td>Will be sold at<br> ".$row['goal10']."</td> 
    <td>&nbsp;&nbsp;&nbsp;</td> 
    <td>Market Price <br> ".$rowmp['bid']."</td>
    </tr>
    </table>
    ";

    echo "<hr width='50%'>
    ";

}

?>