
<?php 
    require_once './layouts/head-main.inc.php';

    \Core\Auth::store_event(\Core\Auth::EVT_PAGE_VIEW,'Stat page');
    $flt = $_SESSION['stat'] ?? [];
    $filtered = (empty($flt) || !count(array_filter(array_values($flt),fn($v)=>!empty($v)))) ? '' : ' <span  style="color:red;">(filtered)</span>';
    $users = \Core\Auth::get_users(); 
    $types = \Core\Stat::get_event_types(); 
    $log   = \Core\Stat::get_events($flt); 
?>

<main class="container" data-page="stat">

    <form method="post" action="/routes.php">
        <input type="hidden" name="cmd" value="cmd_stat">

        <div class="row mt-3">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Filters
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mb-1">
                                    <label class="col-form-label col-md-2" for="from">From</label>
                                    <div class="col-md-10">
                                        <div class="input-group log-event" id="dtFrom" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                            <input type="text" class="form-control" id="from" name="from" value="<?= ($flt['from']??'')?>" data-td-target="#dtFrom">
                                            <span class="input-group-text" data-td-target="#dtFrom" data-td-toggle="datetimepicker">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-form-label col-md-2" for="to">To</label>
                                    <div class="col-md-10">
                                        <div class="input-group log-event" id="dtTo" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                            <input type="text" class="form-control" id="to" name="to" value="<?= ($flt['to']??'')?>">
                                            <span class="input-group-text" data-td-target="#dtFrom" data-td-toggle="datetimepicker">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>            
                                    </div>            
                                </div>
                                <div class="row mb-1">
                                    <label class="col-form-label col-md-2">Action</label>
                                    <div class="col-md-10">
                                        <select name="action" class="form-select">
                                            <option value="">All</option>
                                        <?php foreach($types as $row) { ?>
                                            <option value="<?= $row['id'] ?>"<?= ($row['id'] === ($flt['action']??'-1') ? ' selected' : '') ?>><?= $row['name'] ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>            
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-md-2">User</label>
                                    <div class="col-md-10">
                                        <select name="user" class="form-select">
                                            <option value="">All</option>
                                        <?php foreach($users as $row) { ?>
                                            <option value="<?= $row['id'] ?>"<?= ($row['id'] === ($flt['user']??'-1') ? ' selected' : '') ?>><?= $row['login'] ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>            
                                </div>
                                <div class="row">
                                    <button type="button" id="reset" class="col-md-2 btn btn-warning">Reset</button>
                                    <div class="col-md-8"></div>
                                    <button type="submit" id="show" class="col-md-2 btn btn-success">Show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </form>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <table class="table table-sm table-striped table-hover w-100 caption-top">
                <caption class="text-center fw-bold">Events<?=$filtered?></caption>
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Type</th>
                        <th scope="col">Target</th>
                        <th scope="col">User</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($log as $row) { ?>
                    <tr>
                        <th><?= $row['date'] ?></th>
                        <th><?= $row['type'] ?></th>
                        <th><?= $row['target'] ?></th>
                        <th><?= $row['login'] ?></th>
                    </tr>                    
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-3"></div>
    </div>

</main>

<?php require_once './layouts/feet-main.inc.php'; ?>
