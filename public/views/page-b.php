
<?php require_once './layouts/head-main.inc.php'; ?>

<?php \Core\Auth::store_event(\Core\Auth::EVT_PAGE_VIEW,'Page B'); ?>


<main class="container" data-page="page-b">

<div class="row" style="margin-top:50px;">
  <div class="col-4"></div>  
  <div class="col-4">
      <button id="down" name="down" class="btn btn-warning w-100">Download</button>
  </div>  
  <div class="col-4"></div>  
</div>


</main>

<?php require_once './layouts/feet-main.inc.php'; ?>
