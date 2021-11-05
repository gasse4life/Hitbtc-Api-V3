<?php  include "module/connect.php"; 

$sql = "SELECT * FROM bot_buy_1 ORDER BY `seq` DESC";
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
    <td>".$row['symbol']."</td>
    <td>Next Step => ".$row['nextstep']."</td>
    <td>Percent => ".$row['percent']."%</td>
    <td>P&L => ".$row['pnl']."%</td>
    <td>Amount to buy <br> each step => ".$row['aps']."</td>
    <td>Stop Price => ".$row['cronmin']."</td>
    <td>1= Active 0= Not Active => ".$row['active']."</td>
    <td>Number of deal done => ".$row['deal']."</td>
    </tr>
    </table>
    ";

    echo "<hr width='50%'>
    ";

}

?>