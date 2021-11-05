
<?php
 include "module/connect.php"; 


   if(isset($_POST['mergeall'])){
   /*
    //// order #
    // select order # in stat
    $sqloid = "SELECT * FROM stat";
    $resultoid = $connection->query($sqloid);
    $oid = mysqli_fetch_array($resultoid);
    $aaa = $oid['botorderid']+1;
    $bbb = "m";
    $oidpush =$bbb.$aaa;
    $date = Date("Y-m-d H:i:s");
    $ccc=$_POST['symbol'];
    $qtyinc=$_POST['qtyinc'];
    $base=$_POST['base'];
    $quote=$_POST['quote'];

            /////// truncate/delete
            $sqlcurr = "SELECT * FROM `getorders` WHERE `symbol` = '".$ccc."' AND ostatus='1' AND side='buy' AND astatus='filled' ORDER BY `seq` DESC";
            $stmt = $connection->query($connection, $sqlcurr);
            if($resultcurr = $connection->query($sqlcurr)){
                if(mysqli_num_rows($resultcurr) > 0){
                    while($curr = mysqli_fetch_array($resultcurr)){
                        ///// go truncate 
                        $reset = "DELETE FROM getorders WHERE seq = '".$curr['seq']."'";
                        $goreset = $connection->query($reset);
                        echo $curr['seq'] . " Deleted !<br>";
                    }
                }
            } 

            echo "now going to delete old orders!!<br>";

            //// Merge all button    
            $sqlinsert = "INSERT INTO getorders(howto, id, orderId, clientOrderId, ostatus, astatus, symbol, side, atype, timeInForce, quantity, cumQuantity, price, AvgPrice, autosell, percent, timestamp, qtyinc, base, quote) 
            VALUES ('manual', 
                    '', 
                    '".$oidpush."', 
                    '".$oidpush."',
                    '1',
                    'filled',
                    '".$_POST['symbol']."',
                    'buy',
                    'limit',
                    'GTC',
                    '".$_POST['qty']."',
                    '".$_POST['qty']."',
                    '".$_POST['average']."',
                    '".$_POST['average']."',
                    '1', 
                    '".$_POST['autosell']."', 
                    '".$date."', 
                    '".$qtyinc."', 
                    '".$base."', 
                    '".$quote."'); ";
                        // update order id
                        // must be placed in the foreach array of insert
                        //$sqloidup = "UPDATE stat set botorderid=botorderid +1";
                        //$resultoid2 = $connection->query($sqloidup);
                        $resultoid3 = $connection->query($sqlinsert);
                            echo "New order inserted !!<br>";
                               */

    }else{

    
            /////main page
            $getcurr = $_GET['curr'];
            $postsymbol = $_GET['curr'].$_GET['quote'];

                        
                        // symbol config
                        //currency base info
                        $urlbase = "https://api.hitbtc.com/api/2/public/symbol/". $postsymbol ."";
                        $dataubase = json_decode(file_get_contents($urlbase), true);
                        $base=$dataubase['baseCurrency']; // 'DOGE'btc
                        $quote=$dataubase['quoteCurrency']; // doge'BTC'
                        $qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol
                        $tickSize=$dataubase['tickSize'];
                        $tick=strpos(strrev($tickSize), ".");

            echo "// " . $_GET['quote'] . " //<br><br>";
        
            
            $sqlcurr = "SELECT * FROM `getorders` WHERE `symbol` = '".$postsymbol."' AND ostatus='1' AND side='buy' AND astatus='filled' ORDER BY `seq` DESC";
            //$stmt = $connection->query($connection, $sqlcurr);
            $total = 0;
            $totalqty = 0;
            if($resultcurr = $connection->query($sqlcurr)){
                if(mysqli_num_rows($resultcurr) > 0){
                
                    echo "<table border='1'>";
                        echo "<tr>";
                        echo "<th>Seq</th>";
                        echo "<th>Client Order id</th>";
                        echo "<th>Symbol</th>";
                            echo "<th>Quantity</th>";
                            echo "<th>Price</th>";
                            echo "<th>Total</th>";
                        echo "</tr>";

                        
                    while($curr = mysqli_fetch_array($resultcurr)){
                        $tot = $curr['quantity']*$curr['AvgPrice'];
                        echo "<tr>";
                        echo "<td>".$curr['seq']."</td>";
                        echo "<td>".$curr['clientOrderId']."</td>";
                        echo "<td>".$curr['symbol']."</td>";
                        echo "<td>".$curr['quantity']."</td>";
                        echo "<td>".$curr['AvgPrice']."</td>";
                        echo "<td>".number_format($tot,$tick)."</td>";
                    echo "</tr>";

                
                    $total += $tot;
                    $totalqty += $curr['quantity'];


                    }

                    $avg = $total/$totalqty;
                    $avgf = number_format($avg,$tick);  // format string    

                    // balance
                    $sdfe = $getcurr;
                    $balance = "SELECT * FROM balance where currency='$sdfe'";
                    $gobalance = mysqli_query($connection, $balance);
                    $rowb = mysqli_fetch_array($gobalance);
                    // free
                    $totalfree = 0;
                    $sdff = $getcurr."%";
                    $free = "SELECT * FROM freezone WHERE symbol LIKE '$sdff'";
                    $gofree = mysqli_query($connection, $free);
                    while($rowf = mysqli_fetch_array($gofree)){
                        $totalfree += $rowf['qty'];
                    }
                    // freebot
                    $totalfreeb = 0;
                    $sdffb = $getcurr."%";
                    $freeb = "SELECT * FROM coincreator WHERE symbol LIKE '$sdffb'";
                    $gofreeb = mysqli_query($connection, $freeb);
                    while($rowfb = mysqli_fetch_array($gofreeb)){
                        $totalfreeb += $rowfb['cumQuantity'];
                    }


                    $totbalance=$rowb['available']-$totalfree-$totalfreeb;
  
                    echo "Total Cost ".number_format($total,$tick)." ".$_GET['quote']." <br>";
                    echo "Amount Bought (Declared ".$totalqty.")/(must have ".$totbalance.")*-*-*(available ".$rowb['available'].")/(freezone ".$totalfree.")/(freezone bot ".$totalfreeb.")<br>";
                    echo "Average price buy  = ".$avgf."<br>";

                    // Live Data From Ticker table
                    $sdf = $postsymbol;
                    $sqlact = "SELECT * FROM ticker where symbol='".$sdf."'";
                    $resultact = mysqli_query($connection, $sqlact);
                    $roww = mysqli_fetch_array($resultact);

                    echo "Live Price -> [".$roww['bid']."] -- [".$roww['ask']."]<br>";
                    echo "Ready to sell ? -> must be define<br>";
    
                    echo"
                    <table>
    
                    <tr>
                    <td>
                                    <form action='' method='POST'>
                                    <input type='hidden' name='tick' value='".$tick."'> 
                                    <input type='hidden' name='base' value='".$base."'> 
                                    <input type='hidden' name='quote' value='".$quote."'> 
                                    <input type='hidden' name='qtyinc' value='".$qtyinc."'> 
                                    <input type='hidden' name='symbol' value='".$postsymbol."'> 
                                    <input type='hidden' name='qty' value='".$totalqty."'> 
                                    <input type='hidden' name='average' value='".$avgf."'> 
                                    AutoSell <input type='text' name='autosell' value='5' size='3'> % 
                                    <input type='submit' name='mergeall' value='Merge All Order'/>
                                    </form>
                    </td>
                    <td>
                                    <form action='prepmanual.php' method=''> 
                                    Place An Order <input type='submit' name='symbol' value='".$postsymbol."'/>
                                    </form>
                    </td>
                    </tr>
                    </table>";

                
                    }else{echo"No transaction to show.";}
           }
 }

echo "<br><br><br>must add here transaction of the crypto maker bot.";


?>