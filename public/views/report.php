
<?php require_once './layouts/head-main.inc.php'; ?>

<?php \Core\Auth::store_event(\Core\Auth::EVT_PAGE_VIEW,'Page B'); ?>


<main class="container" data-page="page-b">

    <button id="down" name="down" class="btn btn-success" style="margin:200px auto;width:200px;">Download</button>

</main>

<?php require_once './layouts/feet-foot.inc.php'; ?>