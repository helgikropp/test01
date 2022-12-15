
<?php 
require_once './layouts/head-main.inc.php';
require_once __DIR__.'/../../vendor/jpgraph/jpgraph.php';
require_once __DIR__.'/../../vendor/jpgraph/jpgraph_bar.php';

//set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/../../vendor');

\Core\Auth::store_event(\Core\Auth::EVT_PAGE_VIEW,'Report');
$stat = \Core\Stat::get_report();
?>


<main class="container" data-page="report">
<?php 
/*
<div> $_SERVER['DOCUMENT_ROOT'] ||| <?= $_SERVER['DOCUMENT_ROOT'] ?></div>

<div> __DIR__ ||| <?= __DIR__ ?></div>
<div> dirname(__DIR__) ||| <?= dirname(__DIR__) ?></div>

<div> __DIR__.'/../../vendor' ||| <?= (__DIR__.'/../../vendor') ?></div>
<div> dirname(__DIR__.'/../../vendor/null') ||| <?= dirname(__DIR__.'/../../vendor/null') ?></div>
<div> realpath(__DIR__.'/../../vendor) ||| <?= realpath(__DIR__.'/../../vendor') ?></div>
<div> realpath(/../vendor) ||| <?= realpath('/../vendor') ?></div>

<div> $_SERVER['REQUEST_URI'] ||| <?= $_SERVER['REQUEST_URI'] ?></div>

<div> \parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ||| <?= \parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?></div>
*/ ?>
<?php
$qstr = <<<EOT
SELECT
GROUP_CONCAT(DISTINCT CONCAT(
  'SUM(
  CASE WHEN CONCAT(t.name,'' '',e.target) = ''', CONCAT(t.name,' ',e.target), ''' THEN 1 ELSE 0 END) 
  AS ', CONCAT('`',t.name,' ',e.target,'`'))
) AS pivot_sql
FROM events e
LEFT JOIN event_types t ON t.id = e.type_id
WHERE e.type_id IN (4,5) AND LEFT(e.target,1) IN ('B','D','P');
EOT;

$qstr = <<<EOT
SELECT CONCAT('SELECT DATE(e.date) AS `date`, ',
(SELECT
GROUP_CONCAT(DISTINCT CONCAT(
  'SUM(
  CASE WHEN CONCAT(t.name,'' '',e.target) = ''', CONCAT(t.name,' ',e.target), ''' THEN 1 ELSE 0 END) 
  AS ', CONCAT('`',t.name,' ',e.target,'`'))
) AS sub_sql
FROM events e
LEFT JOIN event_types t ON t.id = e.type_id
WHERE e.type_id IN (4,5) AND LEFT(e.target,1) IN ('B','D','P')
  ), 
  ' FROM events e',
  ' LEFT JOIN event_types t ON t.id = e.type_id',
  ' GROUP BY 1') AS pivot_sql;
;
EOT;
/*
$qstr = <<<EOT
SET @sql = NULL;
SELECT
GROUP_CONCAT(DISTINCT CONCAT(
  'SUM(
  CASE WHEN CONCAT(t.name,'' '',e.target) = ''', CONCAT(t.name,' ',e.target), ''' THEN 1 ELSE 0 END) 
  AS ', CONCAT('`',t.name,' ',e.target,'`'))
)
INTO @sql
FROM events e
LEFT JOIN event_types t ON t.id = e.type_id
WHERE e.type_id IN (4,5) AND LEFT(e.target,1) IN ('B','D','P');
 
SET @sql = CONCAT('SELECT DATE(e.date), ', @sql, 
  ' FROM events e',
  ' LEFT JOIN event_types t ON t.id = e.type_id',
  ' GROUP BY DATE(e.date)');

SELECT @sql;  
EOT;
*/
 /*
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
*/

$db = \Core\Db::get_instance();

$db->query($qstr);

//$db->get_connection()->next_result();
//while($db->get_connection()->next_result()) { $rc = $db->get_connection()->store_result();}
$res = $db->get_result_array();
$db->query($res[0]['pivot_sql']);
$res = $db->get_result_array();
//$res = $rc->fetch_all(MYSQLI_ASSOC);
var_dump($res);
$width = 600; $height = 200;
//$asd = array_values($res[0]);
//var_dump($asd);
//var_dump($c);//!!!!!!!!!!!!
/*
// Width and height of the graph
$width = 600; $height = 200;
 
// Create a graph instance
$graph = new Graph($width,$height);
 
// Specify what scale we want to use,
// int = integer scale for the X-axis
// int = integer scale for the Y-axis
$graph->SetScale('intint');
 
// Setup a title for the graph
$graph->title->Set('Sunspot example');
 
// Setup titles and X-axis labels
$graph->xaxis->title->Set('(dates)');
 
// Setup Y-axis title
$graph->yaxis->title->Set('(count)');
 
// Create the linear plot
//$lineplot=new LinePlot($ydata);
 
// Add the plot to the graph
//$graph->Add($lineplot);
 
// Display the graph
$graph->Stroke();
*/

$report = \Core\Stat::get_report();
//var_dump($asd['table']);
?>
<?php if(empty($report['chart'])) { ?>

    <div class="row">
        <div class="alert alert-primary" role="alert" hidden>No data</div>
    </div>

<?php } else { ?>

    <?php $fields = array_slice(array_keys($report['chart'][0]),1); ?>    

    <?php foreach($report['chart'] as $chart) { ?>
        <?php $title = $chart['action']; ?>    
        <?php $data = array_slice($chart,1); ?>    
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
<?php
    $xMax = max(array_values($data));     
    $graph = new Graph($width,$height);
    $graph->SetScale('textlin',0,$xMax);
    $graph->SetShadow();
    $graph->SetMargin(40,30,20,40);

    $graph->xaxis->SetTickLabels($fields);
    
    $bplot = new BarPlot($data);
 
    // Adjust fill color
    $bplot->SetFillColor('orange');
    $graph->Add($bplot);
    
    // Setup the titles
    $graph->title->Set($title);
    $graph->xaxis->title->Set('Dates');
    $graph->yaxis->title->Set('Count');
    
    $graph->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
    
    // Display the graph
    $graph->Stroke();    
?>
            </div>
            <div class="col-2"></div>
        </div>
    <?php } ?>

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


<?php } ?>





</main>

<?php require_once './layouts/feet-main.inc.php'; ?>

