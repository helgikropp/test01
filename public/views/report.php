
<?php 
require_once './layouts/head-main.inc.php';

\Core\Auth::store_event(\Core\Auth::EVT_PAGE_VIEW,'Report');
$report = \Core\Stat::get_report();
?>

<main class="container" data-page="report">
<?php 
if(empty($report['chart'])) { 
?>

    <div class="row">
        <div class="alert alert-primary" role="alert" hidden>No data</div>
    </div>

<?php 
} else {  

    $charts = [];
    $charts['labels'] = array_keys(array_slice($report['chart'][0],1));
    $charts['items'] = [];
    foreach($report['chart'] as $chart) {
        $data = array_values(array_slice($chart,1));
        $charts['items'][] = [
            'action' => $chart['action'],
            'data'   => array_values(array_slice($chart,1)),
            'max'    => max($data) 
        ]; 
    }
?>
    <canvas id="chart" width="600" height="300" aria-label="Test 01" role="charts"></canvas>
    <template id="js"><?=base64_encode(json_encode($charts))?></template>

    <?php $fields = array_slice(array_keys($report['table'][0]),1); ?>    
    <div class="row mt-5">
        <div class="col-2"></div>
        <div class="col-8">
            <table class="table table-sm table-striped table-hover w-100 caption-top">
                <caption class="text-center fw-bold">Events</caption>
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                    <?php foreach($fields as $field) { ?>
                        <th scope="col"><?=$field?></th>
                    <?php } ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($report['table'] as $row) { ?>
                    <tr>
                        <th><?= $row['date'] ?></th>
                    <?php foreach($fields as $field) { ?>
                        <th><?= $row[$field] ?></th>
                    <?php } ?>
                    </tr>                    
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-2"></div>
    </div>

<?php 
} 
?>

</main>

<?php require_once './layouts/feet-main.inc.php'; ?>

