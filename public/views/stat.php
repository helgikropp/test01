
<?php require_once './layouts/head-main.inc.php'; ?>

<?php \Core\Auth::store_event(\Core\Auth::EVT_PAGE_VIEW,'Stat'); ?>


<main class="container" data-page="stat">

    <button id="down" name="down" class="btn btn-success" style="margin:200px auto;width:200px;">Download</button>

</main>

<?php require_once './layouts/feet-ma.inc.php'; ?>
