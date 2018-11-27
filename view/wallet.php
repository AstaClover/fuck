<?php if (!defined("IN_WALLET")) { die("Auth Error!"); } ?>
<?php
if (!empty($error)) {
    echo "<p style='font-weight: bold; color: red;'>" . $error['message']; "</p>";
}
?>


<div class="container hidden-xs desktop-view">
   <div class="row">

         <div class="mdl-tabs vertical-mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-grid mdl-grid--no-spacing">
               <div class="col-sm-3">
                <h3 class="text-center text-black"><?php echo $fullname; ?></h3>
                  <img class="me" src="<?php echo $server_url;?>wallet/assets/img/btclogo.png" alt="" />
                  <h4 class="text-center text-black"><?php echo $user_session; ?></h4>
                  <div class="mdl-tabs__tab-bar">
                    <?php if ($admin) { ?>
                    <a href="#tab0-panel" class="mdl-tabs__tab">
                     <span class="hollow-circle"></span>
                     Admin
                     </a>
                     <?php } ?>
                     <a href="#tab1-panel" class="mdl-tabs__tab is-active">
                     <span class="hollow-circle"></span>
                     My Wallet
                     </a>
                     <a href="#tab2-panel" class="mdl-tabs__tab">
                     <span class="hollow-circle"></span>
                     Expenses
                     </a>
                     <a href="#tab3-panel" class="mdl-tabs__tab">
                     <span class="hollow-circle"></span>
                     Send Funds
                     </a>
                     <a href="#tab4-panel" class="mdl-tabs__tab">
                     <span class="hollow-circle"></span>
                     Profile
                     </a>
                     <div class="group" style="padding-top:25px; margin:0 auto;">
                      <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="logout" />
                        <input type="submit" class="button logout" value="Logout">
                      </form>
                      </div>
                      
                  </div>
               </div>
               <div class="col-sm-9">
                <h3 class="text-black" style="padding-left:30px;">Balance</h3>
                <p class="text-black price" style="padding-left:30px;"><?php echo satoshitize($balance); ?><strong> <?=$short?></strong></p>
                <?php 
                  $total = $balance * $usd; 
                  $balanceUsd = round($total, 2); 
                ?>
                <?php if($listing === true) { ?>
                <p class="text-black price" style="padding-left:30px;"><strong>&#36;&nbsp;</strong><?=$balanceUsd; ?></p>
                <small style="padding-left:30px;">(1&nbsp;<?=$short ?> = <?=$usd;?>&nbsp;USD )</small>
                <?php } ?>
                <?php if ($admin) { ?>
                <div class="mdl-tabs__panel" id="tab0-panel">
                     <a href="?a=home" class="btn btn-default">Admin Dashboard</a>
                  </div>
                  <?php } ?>
                  <div class="mdl-tabs__panel is-active" id="tab1-panel">
                     <div class="sign-in-htm">
                        <div class="group">

                          <form action="index.php" method="POST">
                          <form>
                          <input type="hidden" name="action" value="authgen" />
                          <button type="submit" class="button">Enable 2 Factor Auth</button>
                          </form><p>
                          <form action="index.php" method="post">
                          <form>
                          <input type="hidden" name="action" value="disauth" />
                          <button type="submit" class="button">Disable 2 Factor Auth</button>
                          </form>

                           <form action="index.php" method="POST" class="refresh newaddressform" style="padding-top:10px;">
                              <input type="hidden" name="action" value="new_address" />
                              <input type="submit" class="button" value="Get a new address">
                           </form>

                           <table class="table table-bordered table-striped" id="alist">
                              <thead>
                              <tr>
                              <td class="text-black" >Address</td>
                              <td class="text-black hidden-xs" >QR Code</td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                              foreach ($addressList as $address)
                              {
                              echo "<tr><td>".$address."</t>";?>
                              <td class="hidden-xs"><a href="<?php echo $server_url;?>wallet/qrgen/?address=<?php echo $address;?>">
                                <img src="<?php echo $server_url;?>wallet/qrgen/?address=<?php echo $address;?>" alt="QR Code" style="width:42px;height:42px;border:0;"></td><tr>
                              <?php
                              }
                              ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="mdl-tabs__panel" id="tab2-panel">
                     <div class="transaction">
                        <div class="col-sm-12">
                           <div class="row">
                              <div class="col-md-2 hidden-sm">
                                 <p>Date</p>
                              </div>
                              <div class="col-sm-8 col-md-6">
                                 <p>Address</p>
                              </div>
                              <div class="col-sm-2">
                                 <p>Amount</p>
                              </div>
                              <div class="col-sm-2">
                                 <p>Info</p>
                              </div>
                           </div>
                        </div>

                              <?php
                                 $bold_txxs = "";
                                 foreach($transactionList as $transaction) {
                                 if($transaction['category']=="send") { $tx_type = 'style="color: #FF0000;"'; } else { $tx_type = 'style="color: #01DF01;"'; }
                                 echo '<div class="col-sm-12 tx-table"><div class="row">
                                       <div class="col-md-2 hidden-sm"><p>'.date('n/j/Y h:i a',$transaction['time']).'</p></div>
                                       <div class="col-sm-8 col-md-6"><p>'.$transaction['address'].'</p></div>
                                       <div class="col-sm-2"><strong '.$tx_type.'>'.abs($transaction['amount']).'&nbsp;'.$short.'</strong></div>
                                       <div class="col-sm-2"><a href="' . $blockchain_tx_url,  $transaction['txid'] . '" target="_blank">Info</a></div></div></div>';
                                 }
                              ?>

                     </div>

                  </div>
                  <div class="mdl-tabs__panel" id="tab3-panel">
                     <div class="sign-in-htm">
                      <form action="index.php" method="POST" class="clearfix refresh withdrawform">
                        <input type="hidden" name="action" value="withdraw" />
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                        <div class="group">
                           <input type="text" class="input" name="address" placeholder="Address">
                        </div>
                        <div class="group">
                           <input type="text" class="input" name="amount" placeholder="Amount">
                        </div>
                        <div class="group">
                           <input type="submit" class="button" value="Send">
                        </div>
                      </form>
                      <p id="withdrawmsg"></p>
                     </div>
                  </div>
                  <div class="mdl-tabs__panel" id="tab4-panel">
                     <div class="sign-in-htm">
                      <form action="index.php" method="POST" class="clearfix refresh pwdform">
                        <input type="hidden" name="action" value="password" />
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                        <div class="group">
                           <input type="password" class="input" name="oldpassword" placeholder="Current Password">
                        </div>
                        <div class="group">
                           <input type="password" class="input" name="newpassword" placeholder="New Password">
                        </div>
                        <div class="group">
                           <input type="password" name="confirmpassword" class="input" placeholder="Confirm New Password">
                        </div>
                        <div class="group">
                           <input type="submit" class="button" value="Update Password">
                        </div>
                      </form>
                      <p id="pwdmsg"></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>

   </div>
</div>

<div class="container visible-xs">
   <div class="row">
      
      <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
         <div class="mdl-grid mdl-grid--no-spacing">

            <div id="mobile" class="mdl-tabs__tab-bar">
               <div class="col-xs-3 text-center">
                  <a href="#tab2-panel" class="mdl-tabs__tab is-active">
                  <span class="hollow-circle"></span>
                  <i class="fas fa-home"></i>
                  </a>
               </div>
               <div class="col-xs-3 text-center">
                  <a href="#tab1-panel" class="mdl-tabs__tab">
                  <span class="hollow-circle"></span>
                  <i class="fas fa-user"></i>
                  </a>
               </div>
               <div class="col-xs-3 text-center">
                  <a href="#tab3-panel" class="mdl-tabs__tab">
                  <span class="hollow-circle"></span>
                  <i class="fas fa-arrow-right"></i>
                  </a>
               </div>
               <div class="col-xs-3 text-center">
                  <a href="#tab4-panel" class="mdl-tabs__tab">
                  <span class="hollow-circle"></span>
                  <i class="fas fa-cog"></i>
                  </a>
               </div>

            </div>

            <div class="col-xs-12 text-black">
               <h3 class="text-center">Balance</h3>
               <h3 class="text-center"><?php echo satoshitize($balance); ?><strong> <?=$short?></strong></h3>
               <?php if($listing === true) { ?>
               <h3 class="text-center" style="padding-left:30px;"><strong>&#36;&nbsp;</strong><?=$balanceUsd; ?></h3>
               <p class="text-center">(1&nbsp;<?=$short ?> = <?=$usd;?>&nbsp;USD )</p>
               <?php } ?>
            </div>
            
            <div class="col-xs-12">
               <div class="mdl-tabs__panel is-active" id="tab2-panel">
                  <div class="transaction-mobile text-black" style="padding-top:20px;">
                     <div class="row">
                        <div class="col-xs-10">
                           <p>Address</p>
                        </div>
                        <div class="col-xs-2">
                           <p>Amount</p>
                        </div>
                     </div>

                     <?php
                        $bold_txxs = "";
                        foreach($transactionList as $transaction) {
                        if($transaction['category']=="send") { $tx_type = 'style="color: #FF0000;"'; } else { $tx_type = 'style="color: #01DF01;"'; }
                          echo '<div class="row mobile-transaction">
                                <div class="col-xs-10"><strong>'.$transaction['address'].'</strong></div>
                                <div class="col-xs-2"><strong '.$tx_type.'>'.abs($transaction['amount']).'&nbsp;'.$short.'</strong></div>
                                </div>';
                          }
                      ?>
                  </div>
               </div>
            </div>

            <div class="col-xs-12">
               <div class="mdl-tabs__panel" id="tab1-panel">
                  <div class="sign-in-htm">
                     <div class="group">
                        <form action="index.php" class="refresh newaddressform" method="POST">
                            <input type="hidden" name="action" value="new_address" />
                            <input type="submit" class="button" value="Get a new address">
                        </form>
                        <table class="table table-bordered table-striped" id="alist">
                              <thead>
                              <tr>
                              <td class="text-black" >Address</td>
                              <td class="text-black hidden-xs" >QR Code</td>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                              foreach ($addressList as $address)
                              {
                              echo "<tr><td>".$address."</t>";?>
                              <td class="hidden-xs"><a href="<?php echo $server_url;?>wallet/qrgen/?address=<?php echo $address;?>">
                                <img src="<?php echo $server_url;?>wallet/qrgen/?address=<?php echo $address;?>" alt="QR Code" style="width:42px;height:42px;border:0;"></td><tr>
                              <?php
                              }
                              ?>
                              </tbody>
                          </table>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xs-12">
               <div class="mdl-tabs__panel" id="tab3-panel">
                  <div class="sign-in-htm">
                     <div class="group">
                      <form action="index.php" method="POST" class="clearfix refresh withdrawform">
                        <input type="hidden" name="action" value="withdraw" />
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                        <div class="group">
                           <input type="text" class="input" name="address" placeholder="Address">
                        </div>
                        <div class="group">
                           <input type="text" class="input" placeholder="Amount">
                        </div>
                        <div class="group">
                           <input type="submit" class="button" value="Send">
                        </div>
                      </form>
                      <p id="withdrawmsg"></p>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xs-12">
               <div class="mdl-tabs__panel" id="tab4-panel">
                  <div class="sign-in-htm">
                     <div class="group">
                      <form action="index.php" method="POST" class="clearfix refresh pwdform">
                        <input type="hidden" name="action" value="password" />
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                        <div class="group">
                           <input type="password" class="input" name="oldpassword" placeholder="Current Password">
                        </div>
                        <div class="group">
                           <input type="password" class="input" name="newpassword" placeholder="New Password">
                        </div>
                        <div class="group">
                           <input type="password" name="confirmpassword" class="input" placeholder="Confirm New Password">
                        </div>
                        <div class="group">
                           <input type="submit" class="button" value="Update Password">
                        </div>
                      </form>
                      <p id="pwdmsg"></p>
                      <div class="group" style="padding-top:25px;">
                      <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="logout" />
                        <input type="submit" class="button" value="Logout">
                      </form>
                      </div>
                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div>

   </div>
</div>


<script type="text/javascript">

$(".popup_inner i").click(function(){
        $(".popup_main").remove();
    });

var blockchain_tx_url = "<?=$blockchain_tx_url?>";
$(".withdrawform input[name='action']").first().attr("name", "jsaction");
$(".newaddressform input[name='action']").first().attr("name", "jsaction");
$(".pwdform input[name='action']").first().attr("name", "jsaction");
$("#donate").click(function (e){
  $("#donateinfo").show();
  $(".withdrawform input[name='address']").val("<?=$donation_address?>");
  $(".withdrawform input[name='amount']").val("0.01");
});
$(".withdrawform").submit(function(e)
{
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {
            var json = $.parseJSON(data);
            if (json.success)
            {
              $(".withdrawform input.form-control").val("");
               $("#withdrawmsg").text(json.message);
               $("#withdrawmsg").css("color", "green");
               $("#withdrawmsg").show();
               updateTables(json);
            } else {
               $("#withdrawmsg").text(json.message);
               $("#withdrawmsg").css("color", "red");
               $("#withdrawmsg").show();
            }
            if (json.newtoken)
            {
              $('input[name="token"]').val(json.newtoken);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //ugh, gtfo    
        }
    });
    e.preventDefault();
});
$(".newaddressform").submit(function(e)
{
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {
            var json = $.parseJSON(data);
            if (json.success)
            {
               $("#newaddressmsg").text(json.message);
               $("#newaddressmsg").css("color", "green");
               $("#newaddressmsg").show();
               updateTables(json);
            } else {
               $("#newaddressmsg").text(json.message);
               $("#newaddressmsg").css("color", "red");
               $("#newaddressmsg").show();
            }
            if (json.newtoken)
            {
              $('input[name="token"]').val(json.newtoken);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //ugh, gtfo    
        }
    });
    e.preventDefault();
});
$(".pwdform").submit(function(e)
{
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {
            var json = $.parseJSON(data);
            if (json.success)
            {
               $(".pwdform input.form-control").val("");
               $("#pwdmsg").text(json.message);
               $("#pwdmsg").css("color", "green");
               $("#pwdmsg").show();
            } else {
               $("#pwdmsg").text(json.message);
               $("#pwdmsg").css("color", "red");
               $("#pwdmsg").show();
            }
            if (json.newtoken)
            {
              $('input[name="token"]').val(json.newtoken);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //ugh, gtfo    
        }
    });
    e.preventDefault();
});

function updateTables(json)
{
   $("#balance").text(json.balance.toFixed(8));
   $("#alist tbody tr").remove();
   for (var i = json.addressList.length - 1; i >= 0; i--) {
      $("#alist tbody").prepend("<tr><td>" + json.addressList[i] + "</td></tr>");
   }
   $("#txlist tbody tr").remove();
   for (var i = json.transactionList.length - 1; i >= 0; i--) {
      var tx_type = '<b style="color: #01DF01;">Received</b>';
      if(json.transactionList[i]['category']=="send")
      {
         tx_type = '<b style="color: #FF0000;">Sent</b>';
      }
      $("#txlist tbody").prepend('<tr> \
               <td>' + moment(json.transactionList[i]['time'], "X").format('l hh:mm a') + '</td> \
               <td>' + json.transactionList[i]['address'] + '</td> \
               <td>' + tx_type + '</td> \
               <td>' + Math.abs(json.transactionList[i]['amount']) + '</td> \
               <td>' + (json.transactionList[i]['fee']?json.transactionList[i]['fee']:'') + '</td> \
               <td>' + json.transactionList[i]['confirmations'] + '</td> \
               <td><a href="' + blockchain_tx_url.replace("%s", json.transactionList[i]['txid']) + '" target="_blank">Info</a></td> \
            </tr>');
   }
}
$(document).ready(function() {
    $('.refresh').on('submit', function(evt) {
          evt.preventDefault();
          setTimeout(function() {
               window.location.reload();
          },0);
          this.submit();
    });
});
</script>