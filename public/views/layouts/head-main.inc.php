<?php 
  require_once "../../../inc/init.inc.php";

  use \Core\Auth; 
  if(!Auth::is_authenticated()) {
    header('Location: /views/login.php');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="uk">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="<?=gmdate("D,d M Y H:i:s")?>">
    <meta http-equiv="Last-Modified" content="<?=gmdate("D,d M Y H:i:s")?>">
    
    <meta name="author" content="Oleg Didenko">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, proxy-revalidate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Telegroup Ukraine Clients Area">
    <meta name="theme-color" content="#3f51b5">
    <meta name="application-name" content="test01">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/css/lib/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css">
    <link href="/css/lib/font-awesome.min.css" media="screen" rel="stylesheet" type="text/css">
    <link href="/css/lib/sweetalert2.min.css" media="screen" rel="stylesheet" type="text/css">
    <link href="/css/const.css" media="screen" rel="stylesheet" type="text/css">
    <link href="/css/app.css" media="screen" rel="stylesheet" type="text/css">
    <script>
      var gLng = "uk";
    </script>
    <script src="/js/lib/bootstrap.bundle.min.js"></script>
    <script src="/js/lib/sweetalert2.all.min.js"></script>
    <script src="/js/lib/FileSaver.min.js"></script>
    <title>test01</title>
  </head>
  <body>
    <header class="container">
        <div class="row">
            <div class="col-auto">
                <!-- img src="{{ mix('images/tgu-logo-h.png') }}" -->
            </div>
            <h5 class="col-auto text-muted">Тестове<br>завдання</h5>  
            <div class="col"></div>  
            <!-- div class="col-auto cab-lng-switch">
                <a href="/lng/uk">UK</a>
                <a href="/lng/en">EN</a>
                <a href="/lng/ru">RU</a>
            </div -->  
            <div class="col-auto">
                <a id="logout" href="/routes.php">
                    <i class="fa fa-sign-out text-muted" style="font-size:32px;margin-top:6px;" title="Exit"></i>
                </a>
            </div>  
        </div>
    </header>
    <nav class="container navbar navbar-expand-sm navbar-light bg-light">
        <div class="container-fluid">
          <div class="row">  
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="col-auto collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                          <a class="nav-link" aria-current="page" href="page-a.php">Page A</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="page-b.php">Page B</a>
                      </li>
                    <?php if(Auth::is_admin_session()) { ?>
                      <li class="nav-item">
                          <a class="nav-link" href="/routes.php" data-cmd="cmd_stat">Stat</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="/routes.php" data-cmd="cmd_report">Report</a>
                      </li>
                    <?php /* } else { ?>
                      <li class="nav-item">
                          <a class="nav-link" href="#">Stat</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link disabled" href="#">Report</a>
                      </li>
                    <?php */ } ?>
                  </ul>
              </div>
          </div>
        </div>
    </nav>
  </div>
