////////////Buying order ////////////////<br><br>

<?php
include "connect.php";


//include "cron_balance.php";

// select order # in stat
$sqloid = "SELECT * FROM stat";
$resultoid = $connection->query($sqloid);
$oid = mysqli_fetch_array($resultoid);
$oidpush = $oid['botorderid']+1;
$oidpush2 = $oid['botorderid']+2;

//
//
//
$sts = 'KINUSD'; // will be define later with get method
//
//
//
//currency base info
$urlbase = "https://api.hitbtc.com/api/2/public/symbol/". $sts ."";
$dataubase = json_decode(file_get_contents($urlbase), true);
$base=$dataubase['baseCurrency']; // 'DOGE'btc
$quote=$dataubase['quoteCurrency']; // doge'BTC'
$qtyinc=$dataubase['quantityIncrement']; // qty increment of a symbol

// buy and sell price
echo "Symbol : ".$sts."<br>"; 
echo "Base : ".$base."<br>"; 
echo "Quote :".$quote."<br>";
echo "Qty Inc :".$qtyinc."<br>";
echo "Order #: ".$oidpush."<br>";
 


//bid-ask price
$url = "https://api.hitbtc.com/api/2/public/ticker/". $sts ."";
$dataticker = json_decode(file_get_contents($url), true);
$symbol=$dataticker['symbol'];
$bid=$dataticker['bid']; // buy price
$ask=$dataticker['ask']; // sell price

// buy and sell price
echo "Bid : ".$bid."<br>"; 
echo "Ask :".$ask."<br>";

//sellprice
$sellprice1=$bid*3/100; // calcul profit //  min -> 3/1000 (0.30%) to pay the fee
$sellprice2=$bid+$sellprice1;  // price buy + maker fee
$sellprice=number_format($sellprice2,8); // format string 

echo "Buy :".$bid."<br>";
echo "Sell Price :".$sellprice."<br>";

//BALANCE from our database
$sqlbal = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM balance where currency='$quote'"));
$id= $sqlbal['id'];
$currency=$sqlbal['currency'];
$available=$sqlbal['available'];
$reserved=$sqlbal['reserved'];
 echo "Symbol #  ". $id ."<br> Symbol ". $currency ."<br> Available ". $available ."<br> Reserved ". $reserved ."<br>";


$quantity0=$available/$bid; // Usd balance divide by price buy
$quantity3 =floor($quantity0 / $qtyinc) * $qtyinc;
        echo "Available divide by bid = X : ". $quantity0 ."<br>";  
        echo "( X / qty increment ) * qty increment : ". $quantity3 ."<br>";  
             
              

        
//BALANCE from our database
$sqlbal1 = "SELECT * FROM balance where currency='$quote'";
$result123 = $connection->query($sqlbal1);
if ($result123->num_rows > 0) {
    // output data of each row
    while($row = $result123->fetch_assoc()) {
        
      // echo "id: " . $row["id"]. " - Name: " . $row["currency"]. " -available " . $row["available"]." -reserved" .$row["reserved"]. "<br>";
       //echo "S.no ". $id; echo "<br>"; echo "Symbol ". $currency; echo "<br>"; echo "available ". $available; echo "<br>"; echo "reserved ". $reserved; echo "<br>";
 
//order on
// data to push to the API and database
$symbol=$sts;
$side = 'buy';
$type = 'limit';
$price=$bid;
$quantity=$quantity3;
$timeInForce= 'GTC'; 
$date = Date("Y-m-d H:i:s");
 

$ch = curl_init();
//do a post
curl_setopt($ch,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
curl_setopt($ch, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,"clientOrderId=$oidpush&symbol=$symbol&side=$side&price=$price&quantity=$quantity&type=$type&timeInForce=$timeInForce");
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



    }
} else {
    echo "0 results123";
}
?>
 <?php
$sqlupd = "SELECT * FROM balance where currency='$quote'";
$resultupd = $connection->query($sqlupd);
if ($resultupd->num_rows > 0) {
    // output data of each row
    while($rowupd = $resultupd->fetch_assoc()) {

$sql ="INSERT INTO trade (symbol,price,sellprice,side,type,quantity,quantity1,quantity2,clientOrderId,date) VALUES('$symbol', '$price','$sellprice','$side','$type','$quantity','$quantity','0','$oidpush','$date')";
if ($connection->query($sql) === TRUE) {
    echo "New record inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

    }
} else {
    echo "0 results balance low";
}


            //////////////////
//////////// SELL ORDER CODE ////////////////
           //////////////////

           
include "connect.php";
//delete executed order row
$sqldel = "DELETE FROM trade WHERE quantity1  <= 0";

if ($connection->query($sqldel) === TRUE) {
   echo "Record deleted successfully<br>";
} else {
 echo "Error deleting executed order record: " . $connection->error; 
}

//TRADE TABLE
//$sql = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM trade order by id asc limit 1"));
$sqlsell = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM trade where symbol='$sts' order by price desc limit 1"));
$idsell= $sqlsell['id'];
$symbolsell= $sqlsell['symbol'];
$pricesell= $sqlsell['price'];
$sidesell= $sqlsell['side'];
$typesell= $sqlsell['type'];
$quantitysell= $sqlsell['quantity'];
$quantity1sell= $sqlsell['quantity1'];
$quantity2sell= $sqlsell['quantity2'];
$sellpricesell= $sqlsell['sellprice'];
  
        echo "Order no. : ".  $idsell ."<br>";
        echo "symbol : ".  $symbolsell ."<br>"; 
        echo "price : ". $pricesell ."<br>";
        echo "side : ".  $sidesell ."<br>";
        echo "type  : ".  $typesell ."<br>";
        echo "quantity : ".  $quantitysell ."<br>";
        echo "quantity1 : ".  $quantity1sell ."<br>";
        echo "quantity2 : ".  $quantity2sell ."<br>";
        echo "sellprice : ".  $sellpricesell ."<br>";
        
     
// dumb method to set qty to 0
$quantity1update=$quantity1sell-$quantity1sell;
// 
$quantity2update=$quantity2sell+$quantity1sell;

 echo "Qty set to ". $quantity1update ." after transaction <br> Qty Sold ". $quantity2update ."<br><br><br>"; 
 
$sqlbal1sell = "SELECT * FROM balance where currency='$base'";
$result123sell = $connection->query($sqlbal1sell);
if ($result123sell->num_rows > 0) {
    // output data of each row
    while($rowsell = $result123sell->fetch_assoc()) {
        
       echo "id: " . $rowsell["id"]. " - Name: " . $rowsell["currency"]. " -available " . $rowsell["available"]." -reserved" .$rowsell["reserved"]. "<br>";
       //echo "S.no ". $id; echo "<br>"; echo "Symbol ". $currency; echo "<br>"; echo "available ". $available; echo "<br>"; echo "reserved ". $reserved; echo "<br>";
 
//order on
$symbolsell=$sts;
$sidesell = 'sell';
$typesell = 'limit';
$pricesell=$sellpricesell;
$quantitysell=$quantity1sell;
$timeInForcesell= 'GTC'; 

$ch1 = curl_init();
//do a post
curl_setopt($ch1,CURLOPT_URL,"https://api.hitbtc.com/api/2/order");
curl_setopt($ch1, CURLOPT_USERPWD, $userName . ':' . $password); // API AND KEY 
curl_setopt($ch1, CURLOPT_POST,1);
curl_setopt($ch1,CURLOPT_POSTFIELDS,"clientOrderId=$oidpush2&symbol=$symbolsell&side=$sidesell&price=$pricesell&quantity=$quantitysell&type=$typesell&timeInForce=$timeInForcesell");
curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1);
  //return the result of curl_exec,instead
  //of outputting it directly
curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch1, CURLOPT_HTTPHEADER, array('accept: application/json'));
//curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
$resultsell=curl_exec($ch1);
curl_close($ch1);
$resultsell=json_decode($resultsell);
echo"<pre>";
print_r($resultsell); 

//order end



    }
} else {
    echo "0 ". $sts ." sell order placed, ". $sts ." balance low";
}
?>
//update trade table
<?php
$sqlupd = "SELECT * FROM balance where currency='$base' AND available >= 10 ";
$resultupd = $connection->query($sqlupd);
if ($resultupd->num_rows > 0) {
    // output data of each row
    while($rowupd = $resultupd->fetch_assoc()) {
       // $sql3 ="UPDATE trade SET quantity1='$quantity1update' , quantity2='$quantity2update' WHERE id='$id' ";
        $sql3 ="UPDATE trade SET quantity1='$quantity1update' , quantity2='$quantity2update' WHERE id='$idsell' ";
if ($connection->query($sql3) === TRUE) {
    echo "". $sts ." record updated successfully";
} else {
    echo "Error: " . $sql3 . "<br>" . $connection->error;
}

    }
} else {
    echo "0 ". $sts ." balance low";
}


$sqloid = "UPDATE stat set botorderid=$oidpush2";
$resultoid = $connection->query($sqloid);
?>