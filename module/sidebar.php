
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Crypto Exchanger </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
       
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Menu Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>


<?php

$sqlusd = "SELECT * FROM `balance` WHERE currency = 'USD'";
$sqlbtc = "SELECT * FROM `balance` WHERE currency = 'BTC'";
$sqleos = "SELECT * FROM `balance` WHERE currency = 'EOS'";
$sqleth = "SELECT * FROM `balance` WHERE currency = 'EOS'";
$resultusd = mysqli_query($connection, $sqlusd);
$resultbtc = mysqli_query($connection, $sqlbtc);
$resulteos = mysqli_query($connection, $sqleos);
$resulteth = mysqli_query($connection, $sqleth);
$balanceusd = mysqli_fetch_array($resultusd);
$balancebtc = mysqli_fetch_array($resultbtc);
$balanceeos = mysqli_fetch_array($resulteos);
$balanceeth = mysqli_fetch_array($resulteth);
$formatusd=number_format((float)$balanceusd,2,".","");  // format string
$formatbtc=number_format((float)$balancebtc,11,".","");  // format string
$formateos=number_format((float)$balanceeos,4,".","");  // format string
$formateth=number_format((float)$balanceeth,8,".","");  // format string
mysqli_free_result($resultusd);
mysqli_free_result($resultbtc);
mysqli_free_result($resulteos);
mysqli_free_result($resulteth);

?>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library 
               <a href="#" class="nav-link active"> -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class=""><img src="img/wallet.png" width="25px"></i>
              <p> Balance 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                <i class=""><img src="img/usd.png" width="25px"></i>
                  <p> <?php echo $balanceusd["available"]; ?> USD <br> Reserved : <?php echo $balanceusd["reserved"]; ?></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                <i class=""><img src="img/btc.png" width="25px"></i>
                  <p> <?php echo $balancebtc["available"]; ?> BTC <br> Reserved : <?php echo $balancebtc["reserved"]; ?></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                <i class=""><img src="img/eos.png" width="25px"></i>
                  <p> <?php echo $balanceeos["available"]; ?> EOS <br> Reserved : <?php echo $balanceeos["reserved"]; ?></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                <i class=""><img src="img/eth2.png" width="25px"></i>
                  <p> <?php echo $balanceeth["available"]; ?> ETH <br> Reserved : <?php echo $balanceeth["reserved"]; ?></p>
                </a>
              </li>
              <li class="nav-item">
              <a href="balance.php?hidezero=1" class="nav-link">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p> All Available Crypto </p>
                </a>
              </li>
              <li class="nav-item">
              <a href="balance_free.php" class="nav-link">
              <i class=""><img src="img/freecash.png" width="25px"></i>
                  <p> Free Zone</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p> Statistics
               </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class=""><img src="img/hand.png" width="25px"></i>
              <p> Manual Trading
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="manual.php?base=USD" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create an order</p>
                </a>
              </li> 
            </ul>
            
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class=""><img src="img/bot.png" width="25px"></i>
              <p> Bot Trading
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="strategies.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Choose Strategies</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="bot_cryptomaker.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crypto Maker Bot</p>
                </a>
                </li> 
                <li class="nav-item">
                  <a href="bot_buying_1.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Buying Bot
                    </p>
                  </a>
                </li> 
            </ul>
          </li>

                                                          <li class="nav-item">
                                                            <a href="#" class="nav-link">
                                                                <i class="nav-icon fas fa-copy"></i>
                                                                <p> Orders & History
                                                                <i class="fas fa-angle-left right"></i>
                                                              </p>
                                                            </a>
                                                            <ul class="nav nav-treeview">
                                                                <li class="nav-item"> 
                                                                <li class="nav-item">
                                                            <a href="#" class="nav-link">
                                                            <i class="nav-icon fas fa-copy"></i>
                                                              <p> Basic + Manual
                                                                <i class="fas fa-angle-left right"></i>
                                                              </p>
                                                            </a>
                                                            <ul class="nav nav-treeview">
                                                            <li class="nav-item">
                                                                <a href="orders_side.php?Side=buy&Status=1" class="nav-link">
                                                                  <i class="far fa-circle nav-icon"></i>
                                                                  <p>Active Orders</p>
                                                                </a>
                                                              </li> 
                                                              <li class="nav-item">
                                                                <a href="orders_side.php?Side=new&Status=1" class="nav-link">
                                                                  <i class="far fa-circle nav-icon"></i>
                                                                  <p>New Orders</p>
                                                                </a>
                                                              </li>
                                                              <li class="nav-item">
                                                                <a href="orders_side.php?Side=partiallyFilled&Status=1" class="nav-link">
                                                                  <i class="far fa-circle nav-icon"></i>
                                                                  <p>Partially Filled Orders</p>
                                                                </a>
                                                              </li>
                                                              <li class="nav-item">
                                                                <a href="orders_side.php?Side=lock" class="nav-link">
                                                                  <i class="far fa-circle nav-icon"></i>
                                                                  <p>Locked Orders</p>
                                                                </a>
                                                              </li>
                                                              <li class="nav-item">
                                                              <a href="orders_side.php?Side=buy&Status=2" class="nav-link">
                                                                  <i class="far fa-circle nav-icon"></i>
                                                                  <p>Closed Orders</p>
                                                                </a>
                                                              </li>
                                                              <li class="nav-item">
                                                              <a href="orders_side.php?Side=canceled&Status=2" class="nav-link">
                                                                  <i class="far fa-circle nav-icon"></i>
                                                                  <p>Canceled</p>
                                                                </a>
                                                              </li>
                                                            </ul>
                                                          </li>
                                                                </li>

                                                                                        <li class="nav-item">
                                                                                                                                                  <li class="nav-item">
                                                                                    <a href="#" class="nav-link">
                                                                                    <i class="nav-icon fas fa-copy"></i>
                                                                                      <p> BGL Gain - Loss
                                                                                        <i class="fas fa-angle-left right"></i>
                                                                                      </p>
                                                                                    </a>
                                                                                    <ul class="nav nav-treeview">
                                                                                    <li class="nav-item">
                                                                                        <a href="orders_side_bgl.php?Side=buy&Status=1" class="nav-link">
                                                                                          <i class="far fa-circle nav-icon"></i>
                                                                                          <p>Active Orders</p>
                                                                                        </a>
                                                                                      </li> 
                                                                                      <li class="nav-item">
                                                                                        <a href="orders_side_bgl.php?Side=new&Status=1" class="nav-link">
                                                                                          <i class="far fa-circle nav-icon"></i>
                                                                                          <p>New Orders</p>
                                                                                        </a>
                                                                                      </li>
                                                                                      <li class="nav-item">
                                                                                        <a href="orders_side_bgl.php?Side=partiallyFilled&Status=1" class="nav-link">
                                                                                          <i class="far fa-circle nav-icon"></i>
                                                                                          <p>Partially Filled Orders</p>
                                                                                        </a>
                                                                                      </li>
                                                                                      <li class="nav-item">
                                                                                        <a href="orders_side_bgl.php?Side=lock" class="nav-link">
                                                                                          <i class="far fa-circle nav-icon"></i>
                                                                                          <p>Locked Orders</p>
                                                                                        </a>
                                                                                      </li>
                                                                                      <li class="nav-item">
                                                                                      <a href="orders_side_bgl.php?Side=buy&Status=2" class="nav-link">
                                                                                          <i class="far fa-circle nav-icon"></i>
                                                                                          <p>Closed Orders</p>
                                                                                        </a>
                                                                                      </li>
                                                                                      <li class="nav-item">
                                                                                      <a href="orders_side_bgl.php?Side=canceled&Status=2" class="nav-link">
                                                                                          <i class="far fa-circle nav-icon"></i>
                                                                                          <p>Canceled</p>
                                                                                        </a>
                                                                                      </li>
                                                                                    </ul>
                                                                                  </li>        
                                                                                        </li> 
                
                <li class="nav-item">
                  
                </li> 
            </ul>
          </li>



          <li class="nav-item">
            <a href="liverate.php" class="nav-link">
            <i class=""><img src="img/liverate.png" width="25px"></i>
              <p>  Live Rate Data </p>
            </a>
          </li>

<li class="nav-item">
  <a href="#" class="nav-link">
  <i class=""><img src="img/setting.png" width="25px"></i>
    <p> Configuration 
    <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  
  <ul class="nav nav-treeview">
      <li class="nav-item">
      <a href="cron_balance.php" class="nav-link">
      <i class=""><img src="img/setting.png" width="25px"></i>
        <p> Update balance </p>
      </a>
      </li>  
  </ul>
  <ul class="nav nav-treeview">
      <li class="nav-item">
      <a href="cron_ticker_daily.php" class="nav-link">
      <i class=""><img src="img/setting.png" width="25px"></i>
        <p> Update ticker daily </p>
      </a>
      </li>  
  </ul>
</li>   

<li class="nav-item">
  <a href="code_sample.php" class="nav-link" target="_new">
  <i class=""><img src="img/php.png" width="25px"></i>
    <p> Sample Code 
     </p>
  </a>    
</li>   
         
    
<li class="nav-item">
  <a href="#" class="nav-link">
  <i class=""><img src="img/setting.png" width="25px"></i>
    <p> To Do 
    <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  
  <ul class="nav nav-treeview">
      <li class="nav-item">
      <a href="#" class="nav-link">
      <i class=""><img src="img/setting.png" width="25px"></i>
        <p> Follow Mode </p>
      </a>
      </li>
      <li class="nav-item">
      <a href="#" class="nav-link">
      <i class=""><img src="img/setting.png" width="25px"></i>
        <p> All Stats page </p>
      </a>
      </li> 
      <li class="nav-item">
      <a href="#" class="nav-link">
      <i class=""><img src="img/setting.png" width="25px"></i>
        <p> Ticker banner page </p>
      </a>
      </li> 
      <li class="nav-item">
      <a href="#" class="nav-link">
      <i class=""><img src="img/setting.png" width="25px"></i>
        <p> split ticker cron by quote BTC-USD-ETH etc.... </p>
      </a>
      </li> 
      <li class="nav-item">
      <a href="#" class="nav-link">
      <i class=""><img src="img/setting.png" width="25px"></i>
        <p>Create an exclusion table to lock XXXUSD </p>
      </a>
      </li> 
      <li class="nav-item">
      <a href="#" class="nav-link">
      <i class=""><img src="img/setting.png" width="25px"></i>
        <p>update daily ticker </p>
      </a>
      </li>       
  </ul>
</li> 
         
          
          
          
           
        </ul>
      </nav><br><br>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
 