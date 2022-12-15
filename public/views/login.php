<?php unset($_SESSION['user']); ?>
<?php require_once './layouts/head-single.inc.php'; ?>
<main class="container" data-page="login">
  <div class="row tst-login-row">
    <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-7 col-11 tst-login-wrap">
      <form id="login-form" class="w-100" method="post" action="/routes.php" novalidate onsubmit="return false;">
        <input type="hidden" name="cmd" value="cmd_logon">
        <span class="pb-3 tst-login-title">
            Тестове завдання
        </span>

        <div class="tst-md-input-group">
          <input id="uname" name="uname" type="text" class="form-control" value="" required autocomplete="section-logon username" maxlength="30">
          <label for="uname" class="tst-md-label tst-control-label">Логін</label>
          <span class="tst-md-input-line"></span>
        </div>

        <div class="tst-md-input-group">
          <input id="pwd" name="pwd" type="password" class="form-control" value="" required autocomplete="section-logon current-password" maxlength="30">
          <label for="pwd" class="tst-md-label tst-control-label">Пароль</label>
          <i class="fa fa-eye tst-login-pwd-btn"></i>
          <span class="tst-md-input-line"></span>
        </div>

        <div class="mt-2">
          <button type="submit" class="btn btn-primary w-100">
            Вхід
          </button>
        </div>

        <div class="mt-2 text-end small">
          <a href="/views/register.php">Register</a>
        </div>

        <div class="mt-3 text-center">
          <small style="font-size:10px; padding-top:5px;">© 2022 Тестове завдання</small>
        </div>

      </form>          
    </div>  

  </div>
</main>
<?php require_once './layouts/feet-single.inc.php'; ?>
