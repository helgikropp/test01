<?php unset($_SESSION['user']); ?>
<?php require_once './layouts/head-single.inc.php'; ?>
<main class="container" data-page="register">
  <div class="row tst-login-row">
    <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-7 col-11 tst-login-wrap">
      <form id="signup-form" class="w-100" method="post" action="/routes.php" novalidate onsubmit="return false;">
        <input type="hidden" name="cmd" value="cmd_register">
        <h2>Sign Up</h2>

        <div class="mb-3">
          <label for="uname" class="form-label">Username</label>
          <input id="uname" name="uname" type="text" class="form-control" value="" required maxlength="30">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input id="email" name="email" type="email" class="form-control" value="" required maxlength="50">
        </div>

        <div class="mb-3">
        <label for="pwd1" class="form-label">Password</label>
          <input id="pwd1" name="pwd1" type="password" class="form-control" value="" required maxlength="30">
        </div>

        <div class="mb-3">
          <label for="pwd2" class="form-label">Password (repeat) </label>
          <input id="pwd2" name="pwd2" type="password" class="form-control" value="" required maxlength="30">
        </div>

        <div class="form-check mb-5">
          <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            I agree to the <a href="#" target="_blank" title="Terms and Licenses">End User License Agreement</a> 
            and the <a href="#" target="_blank" title="Privacy Policy">Privacy Policy</a>
          </label>
        </div>

        <div class="mb-1">
          <button id="send" type="button" class="btn btn-success w-100">Just do it!</button>
        </div>

      </form>          
    </div>  

  </div>
</main>
<?php require_once './layouts/feet-single.inc.php'; ?>
