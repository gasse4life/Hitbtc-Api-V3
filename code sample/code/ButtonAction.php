single drop down button      
             <div class="btn-group">
                    <button type="button" class="btn btn-default">Action</button>
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#">Something else here</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                  </div>






multi drop down button  



                 

                <div class='btn-group'>
                <button type='button' class='btn btn-success'>Copy</button>
                <button type='button' class='btn btn-success dropdown-toggle dropdown-hover dropdown-icon' data-toggle='dropdown'>
                <span class='sr-only'>Toggle Dropdown</span>
                </button>
                <div class='dropdown-menu' role='menu'>
                <a class='dropdown-item' href='pushorderB.php?id=" . $row['clientOrderId'] . "&quantity=" . $row['quantity'] . "&symbol=" . $row['symbol'] . "&type=market&side=buy'>Market</a>
                <a class='dropdown-item' href='pushorderB.php?id=" . $row['clientOrderId'] . "&quantity=" . $row['quantity'] . "&symbol=" . $row['symbol'] . "&type=limit&side=buy&pricebuy=" . $roww['bid'] . "'>Limit</a>
                <span class='right badge badge-danger'>Soon</span><a class='dropdown-item' href='#'>Manual Order</a>
               <div class='dropdown-divider'></div>
              <a class='dropdown-item' href='#'>Info</a>
                </div>
                 </div>

                 <div class='btn-group'>
                 <button type='button' class='btn btn-danger'>Sell</button>
                 <button type='button' class='btn btn-danger dropdown-toggle dropdown-hover dropdown-icon' data-toggle='dropdown'>
                 <span class='sr-only'>Toggle Dropdown</span>
                </button>
                <div class='dropdown-menu' role='menu'>
                <a class='dropdown-item' href='pushorderS.php?id=" . $row['clientOrderId'] . "&quantity=" . $row['quantity'] . "&symbol=" . $row['symbol'] . "&type=market&side=sell'>Market</a>
               <a class='dropdown-item' href='pushorderS.php?id=" . $row['clientOrderId'] . "&quantity=" . $row['quantity'] . "&symbol=" . $row['symbol'] . "&type=limit&side=sell&pricebuy=" . $roww['ask'] . "'>Limit</a>
                <span class='right badge badge-danger'>Soon</span><a class='dropdown-item' href='#'>Manual Order</a>
                
                <div class='dropdown-divider'></div>
                <p class='dropdown-item'>Info</p>
                </div>

                </div>

                </div>