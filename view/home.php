
<?php if (!defined("IN_WALLET")) { die("Auth Error"); } ?>


<div class="row row2">

<?php
    if (!empty($error)) {
        echo "<p class='text-center hidden-sm' style='font-weight: bold; color: red;'>" . $error['message']; "</p>";
    }
?>


<div class="login-wrap">
   <div class="login-html">
      <div class="col-sm-10 col-sm-offset-1">
        <div class="thumbnail"><img src="<?php echo $server_url;?>wallet/assets/img/btclogo.png"></div>
        <h3 class="text-center h3-text"><strong><?php echo $fullname; ?> Wallet</strong></h3>
         <input id="tab-1" type="radio" name="tab" class="sign-in text-center" checked><label for="tab-1" class="tab">Sign In</label>
         <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
        
         <div class="login-form">
          <form action="index.php" method="POST" class="clearfix">
            <div class="sign-in-htm">
              <input type="hidden" name="action" value="login" />
               <div class="group">
                  <input type="text" class="input" name="username" placeholder="Username">
               </div>
               <div class="group">
                  <input type="password" name="password" class="input" placeholder="Password">
               </div>
               <div class="group">
                  <input type "text" class="input" name="auth" placeholder="2FA Auth Code">
               </div>
               <div class="group">
                  <input type="submit" type="submit" class="button" value="Sign In">
               </div>
            </div>
            </form>

            <form action="index.php" method="POST" class="clearfix">
            <div class="sign-up-htm">
              <input type="hidden" name="action" value="register" />
               <div class="group">
                  <input type="text" class="input" name="username" placeholder="Username">
               </div>
               <div class="group">
                  <input type="password" name="password" class="input" placeholder="Password">
               </div>
               <div class="group">
                  <input type="password" name="confirmPassword" class="input" placeholder="Repeat Password">
               </div>
               <div class="group">
                  <input type="text" class="input" name="email" placeholder="Email">
               </div>
               <div class="group">
                  <input type="submit" type="submit" class="button" value="Sign Up">
               </div>
            </div>
          </form>

         </div>
        

         <div class="clearfix"></div>

         <div class="flex-c-m">
            <a href="#" class="login100-social-item bg1" target="_blank">
              <i class="fab fa-bitcoin"></i>
            </a>

            <a href="#" class="login100-social-item bg2" target="_blank">
              <i class="fab fa-twitter"></i>
            </a>

            <a href="#" class="login100-social-item bg3" target="_blank">
              <i class="fab fa-discord"></i>
            </a>
            
          </div>

      </div>
   </div>
</div>
</div>

