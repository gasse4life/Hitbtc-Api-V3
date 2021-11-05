 
<style type=”text/css”>
code {
    background-color: #eeeeee;
    border-radius: 3px;
    font-family: courier, monospace;
    padding: 0 3px;
}
</style>
 
<u>SQL</u>

<p>
    <code> 
    how much order<br>
    SELECT clientOrderId, COUNT(clientOrderId) FROM `getorders` GROUP BY clientOrderId<br>
    HAVING COUNT(clientOrderId)>1 <br>
    </code>
</p>
<br><br>

<p>
    <code>
    select SUM <br>
    SELECT SUM(Quantity) AS TotalItemsOrdered FROM OrderDetails;<br>
    </code>
</p>
<br><br>
<p>
    <code> 
        add / remove this 2 lines if you use web server / wamp  <br>
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);<br>
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false); <br>
    </code>
</p>
<br><br>
<p>
    <code> 
    You can run this: <br>
    <br>
set_time_limit(0); <br>
ignore_user_abort(true); <br>
while (1) <br>
{ <br>
    //your code here.... <br>
    sleep($timetowait); <br>
} <br>
<br>
****** <br>
You can close your browser the script will continue <br>
<br>
set_time_limit(0); make your script work with no time limitation <br>
<br>
sleep($timetowait); determine the time to wait before executing the next loop of while() <br>
<br>
ignore_user_abort(true); let the script continue even if browser is closed <br>
<br>
while(1) is an infinite loop, so this will never stop until you exit wamp. <br>
    </code>
</p>
<br><br>

<p>
    <code> 
    if (!empty($result->error)) { <br>
                                                        foreach($result as $item) { <br> 
                                                        if($item->code = '20001') { <br>
                                                          $errorfund = "INSERT IGNORE INTO warning(seq, error) <br>
                                                          VALUES ('', 'ERROR: LOW BALANCE ....".$inSymbol."....".$item->code."....".$item->message."....".$item->description."....')"; <br>                   
                                                                  $result2t = $connection->query($errorfund);<br>
                                                                  mysqli_free_result($result2t);  }<br>
                                                         $errorbbt = "INSERT IGNORE INTO error(seq, error) <br>
                                                          VALUES ('', 'ERROR: Could not able to execute. bot_cryptomaker_add.php ....".$inSymbol."....".$item->code."....".$item->message."....')";  <br>                  
                                                                  $resultbbt = $connection->query($errorbbt);<br>
                                                                  mysqli_free_result($resultbbt);<br>
                                                              }<br>
                                                              <br>
                } else {<br>
    </code>
</p><br><br>

<p>
    <code> 
    if(mysqli_multi_query($connection, $query)
    </code>
</p><br><br>

<p>
    <code> 
    $totreceived=number_format($totrec,11,".","");  // format string
    </code>
</p><br><br>

<p>
    <code> 
       possible fault of bad API price return,<br>
       must adjust tickness ot af price.   0.00000 or 0.0000000<br>
       must float number<br>
        
    </code>
</p><br><br>

<p>
    <code> 
        
    </code>
</p><br><br>

<p>
    <code> 
        
    </code>
</p><br><br>

<p>
    <code> 
        
    </code>
</p><br><br>

<p>
    <code> 
        
    </code>
</p><br><br>

