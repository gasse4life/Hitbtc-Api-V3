<?php 
##CREATE TABLE IF NOT EXISTS `cron` (
##    `seq` int(255) NOT NULL AUTO_INCREMENT,
##    `file` varchar(255) DEFAULT NULL,
##    `execf` varchar(255) DEFAULT NULL,
##    `noneednow` varchar(255) DEFAULT NULL,
##    PRIMARY KEY (`seq`)
##  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

include "module/connect.php";
   
   $sql = "SELECT * FROM `cron` WHERE execf = '0'  LIMIT 1";
   

   if($sql = mysqli_query($connection, $sql)){
            if(mysqli_num_rows($sql) > 0){ 

                echo "<table border='1'>";
                        
                while($rowp = mysqli_fetch_array($sql)){
echo "<tr><td>";
                   echo $rowp['file'];
                   echo "<br> executing files";
echo "</tr></td>";
                }

    }else{    
            echo "<tr><td>";
            /////////////////////    reset of cron check up  
            $sqlreset = "UPDATE cron SET execf='0'";
            $reset = mysqli_query($connection, $sqlreset);
            mysqli_free_result($reset);
            echo "</tr></td>";
        }
    }
 

        ## each files have her own execution time, so i cant cron every minute etc....
        ##  --­>  i need to refresh page only when page is fully load, <--
        ##  i tried
        ##  header('Location: ...'); 
        ##  window.location.href='enter_your_url_here.php';
        ## but navigator give error cause too many redirect.



   # this is the primary cronjob source
    # this primary
    //$cron_jobs = [
     //   'cron_balance.php',     # calling balance-api from api.hitbtc.com and update balance db
     //   'cron_ticker.php',      # calling ticker-api from api.hitbtc.com and saving to db
     ///   'bot_buy_1.php',        # calling order-api from api.hitbtc.com , getorders and add xinfo
        # ...
 //   ];

//    foreach( $cron_jobs as $cron_filename )
 //   {
 //       if(empty($cron_filename)) continue;
 //       include($cron_filename);
 //   }