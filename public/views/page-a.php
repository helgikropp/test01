
<?php require_once './layouts/head-main.inc.php'; ?>

<?php \Core\Auth::store_event(\Core\Auth::EVT_PAGE_VIEW,'Page A'); ?>

<main class="container" data-page="page-a">

  <button id="cow" name="cow" class="btn btn-success" style="margin:200px auto;width:200px;">By a cow</button>

  <!-- div id="txt" name="txt" class="hidden" style="margin:200px auto;width:200px;color:red;">Thank You!</div -->
  <div id="txt" class="hidden alert alert-success" style="margin-top:200px" role="alert">Thank You!</div>
</main>

<?php require_once './layouts/feet-foot.inc.php'; ?>
