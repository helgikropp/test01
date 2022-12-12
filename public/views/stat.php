
<?php 
    require_once './layouts/head-main.inc.php';

    \Core\Auth::store_event(\Core\Auth::EVT_PAGE_VIEW,'Stat');
    $flt = $_SESSION['stat'] ?? [];
    $users = \Core\Auth::get_users(); 
    $types = \Core\Stat::get_event_types(); 
    $log   = \Core\Stat::get_events($flt); 
?>

<main class="container" data-page="stat">

    <form method="post" action="/routes.php">
        <input type="hidden" name="cmd" value="cmd_stat">
        <div class="row mb-1">
            <label class="col-form-label col-md-1">Period</label>
            <div class="col-md-2">
                <input type="text" class="form-control" name="from" value="<?= ($flt['from']??'')?>">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="enddate" value="<?= ($flt['to']??'')?>">
            </div>            
            <label class="col-form-label col-md-1">Action</label>
            <div class="col-md-2">
                <select name="type" class="form-select">
                    <option value="">All</option>
                <?php foreach($types as $row) { ?>
                    <option value="<?= $row['id'] ?>"<?= ($row['id'] === ($flt['action']??'-1') ? ' selected' : '') ?>><?= $row['name'] ?></option>
                <?php } ?>
                </select>
            </div>            
            <label class="col-form-label col-md-1">User</label>
            <div class="col-md-3">
                <select name="user" class="form-select">
                    <option value="">All</option>
                <?php foreach($users as $row) { ?>
                    <option value="<?= $row['id'] ?>"<?= ($row['id'] === ($flt['user']??'-1') ? ' selected' : '') ?>><?= $row['login'] ?></option>
                <?php } ?>
                </select>
            </div>            
        </div>

        <div class="row mb-2">
            <div class="col-md-11"></div>
            <button type="submit" name="set" class="col-md-1 btn btn-success">Show</button>
        </div>
    </form>


    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <table>
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
