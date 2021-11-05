<?php
//error_reporting(E_ALL);
    //error_reporting(E_ALL & ~E_NOTICE);
//ini_set("display_errors", 1);
 ?>
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">

      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

    <li class="nav-item">
                                            <!--  -->
                                            <!--  -->
                                            <style>
                                              [data-component="slideshow"] .slide {
                                              display: none;
                                              text-align: center;               }
                                              [data-component="slideshow"] .slide.active {
                                              display: block;                         }
                                            </style>
                                            <!--   Just create this div-->
                                            <div id="slideshow-example" data-component="slideshow">
                                          <div role="list">
                                            <?php 
                                                  function getPercentageChange($oldNumber, $newNumber){
                                                    $decreaseValue = $oldNumber - $newNumber;
                                                
                                                    return ($decreaseValue / $oldNumber) * 100;
                                                  }
                                            $sql1 = "SELECT * FROM `slideshow`";
                                            $resul1 = mysqli_query($connection, $sql1);
                                            while($tt1 = mysqli_fetch_array($resul1)){
                                               ///////
                                               $bb=$tt1['symbol'];
                                               $sql2 = "SELECT * FROM `ticker` WHERE `symbol` = '$bb'";
                                               $resul2 = mysqli_query($connection, $sql2);
                                               $tt2 = mysqli_fetch_array($resul2);

                                               $sql3 = "SELECT * FROM `ticker_daily` WHERE `symbol` = '$bb'";
                                               $resul3 = mysqli_query($connection, $sql3);
                                               $tt3 = mysqli_fetch_array($resul3);

                                               $value2=number_format(getPercentageChange($tt2['ask'], $tt3['ask']),2);
                                               
                                              ?>
                                              <div class="slide">
                                                <?php  
                                                if($value2 > 0){
                                                  echo "<td>".$tt1['symbol']." » <span class='right badge badge-success'>" . $value2 . " %</span></td>";
                                                }
                                                elseif($value2 < 0){
                                                  echo "<td>".$tt1['symbol']." » <span class='right badge badge-danger'>" . $value2 . " %</span></td>";
                                                }else{
                                                  echo "<td>".$tt1['symbol']." » <span class='right badge badge-default'>" . $value2 . " %</span></td>";
                                                }
                                                ?>
                                              </div>
                                            <?php
                                            }
                                            mysqli_free_result($resul2);
                                            mysqli_free_result($resul3);

                                            ?>

                                          </div>
                                          </div> 
                                          <script> 
                                          var slideshows = document.querySelectorAll('[data-component="slideshow"]');
                                          slideshows.forEach(initSlideShow);
                                          function initSlideShow(slideshow) {
                                            var slides = document.querySelectorAll(`#${slideshow.id} [role="list"] .slide`);
                                            var index = 0, time = 3000;
                                            slides[index].classList.add('active');
                                            setInterval( () => {
                                              slides[index].classList.remove('active');
                                              index++;
                                              if (index === slides.length) index = 0;
                                              slides[index].classList.add('active');
                                            }, time);
                                          }
                                          </script>
                                            <!--  -->
                                            <!--  -->
      </li>

      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
                                          








                                                    <?php
                                                    ////////////////////////
                                                    if(!empty($_GET['winfo'])){
                                                      $reset = "TRUNCATE TABLE winfo";
                                                      $goreset = $connection->query($reset);
                                                      }elseif(!empty($_GET['error'])){
                                                        $reset = "TRUNCATE TABLE error";
                                                        $goreset = $connection->query($reset);
                                                      }elseif(!empty($_GET['xinfo'])){
                                                        $reset = "TRUNCATE TABLE xinfo";
                                                        $goreset = $connection->query($reset);
                                                      }elseif(!empty($_GET['zinfo'])){
                                                        $reset = "TRUNCATE TABLE warning";
                                                        $goreset = $connection->query($reset);
                                                      } 

                                                      //if(!isset($_POST['eraseall'])){
                                             //           elseif(!isset($_GET['eraseall'])){
                                             //             $reset ="";
                                             //         $goreset = $connection->query($reset);
                                             //         } 


                                                       
                                                      ///////////////////////////////////////////
                                                      $aaa = "SELECT COUNT(seq) AS report FROM `winfo`";
                                                      $resultaaa = $connection->query($aaa);
                                                      $report = mysqli_fetch_array($resultaaa);
                                                      ///////////////////////////////////////////
                                                      $cscc = "SELECT COUNT(seq) AS report FROM `xinfo`";
                                                      $resultccc = $connection->query($cscc);
                                                      $reporttc = mysqli_fetch_array($resultccc);
                                                      ///////////////////////////////////////////
                                                      $bbb = "SELECT COUNT(seq) AS reportb FROM `error`";
                                                      $resultbbb = $connection->query($bbb);
                                                      $reporttb = mysqli_fetch_array($resultbbb);
                                                      ///////////////////////////////////////////
                                                      $zsddd = "SELECT COUNT(seq) AS report FROM `warning`";
                                                      $resultzb = $connection->query($zsddd);
                                                      $reportzb = mysqli_fetch_array($resultzb);
                                                    ////////////////////////  
                                                      $total_notif=$report['report']+$reporttb['reportb']+$reporttc['report']+$reportzb['report']; //   total notif
                                                    ////////////////////////
                                                    ?>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><?php echo $total_notif; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?php echo $total_notif; ?> Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> <?php echo $reporttb['reportb']; ?> code source error
            <span class="float-right text-muted text-sm"><a href='?error=reset'>Reset</a></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> <?php echo $reporttc['report']; ?> new deal Buying Bot #1
            <span class="float-right text-muted text-sm"><a href='?xinfo=reset'>Reset</a></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> <?php echo $report['report']; ?> new deal Crypto Maker
            <span class="float-right text-muted text-sm"><a href='?winfo=reset'>Reset</a></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> <?php echo $reportzb['report']; ?> Funds Alerts
            <span class="float-right text-muted text-sm"><a href='?zinfo=reset'>Reset</a></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Erase All Notifications</a>
        </div>
      </li>




      <!-- full screen -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- control-sidebar -->
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>