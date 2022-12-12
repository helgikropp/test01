
<?php require_once './layouts/head-main.inc.php'; ?>

<?php \Core\Auth::store_event(\Core\Auth::EVT_PAGE_VIEW,'Page A'); ?>

<main class="container" data-page="page-a">

<div class="row" style="margin-top:50px;">
  <div class="col-4"></div>  
  <div class="col-4">
    <button id="cow" name="cow" class="btn btn-success w-100">By a cow</button>

    <div id="txt" class="alert alert-success" role="alert" hidden>Thank You!</div>
  </div>  
  <div class="col-4"></div>  
</div>

</main>

<?php require_once './layouts/feet-main.inc.php'; ?>
