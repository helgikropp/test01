<?php
require_once "../inc/init.inc.php";

use Core\Lib;
use Core\Auth;

$cmd = $_POST['cmd'];

switch ($cmd) {
//------------------------------------------------------------------------------------------------
    case 'cmd_logon':
        $uname = trim($_POST['uname']);
        $pwd   = trim($_POST['pwd']);
        if(empty($uname) || empty($pwd)) {
            $response = Lib::create_response('RC_EMPTY_PARAM','','/views/login.php',[]); 
        } else {
            Auth::logon($uname,$pwd);
            if(Auth::is_authenticated()) {
                $response = Lib::create_response('RC_OK','','/views/page-a.php',[]); 
            } else {
                $response = Lib::create_response('RC_ERR','','',[]); 
            }
        }
        Auth::store_event(Auth::EVT_LOGON,Auth::is_authenticated() ? 'Success' : 'Fail');
        break;

//------------------------------------------------------------------------------------------------
    case 'cmd_logout':
        Auth::store_event(Auth::EVT_LOGOUT,'');
        Auth::logout();
        $response = Lib::create_response('RC_OK','','/views/login.php',[]); 
        break;

//------------------------------------------------------------------------------------------------
    case 'cmd_click':
        $response = Lib::create_response('RC_OK','','',[]); 
        Auth::store_event(Auth::EVT_BTN_CLICK,$_POST['target']);
        break;

//------------------------------------------------------------------------------------------------
    case 'cmd_stat':
        $_SESSION['stat']['from']   = $_POST['from'] ?? ''; 
        $_SESSION['stat']['to']     = $_POST['to'] ?? ''; 
        $_SESSION['stat']['user']   = $_POST['user'] ?? ''; 
        $_SESSION['stat']['action'] = $_POST['action'] ?? ''; 
        $response = Lib::create_response('RC_OK','','/views/stat.php',[]); 
        Auth::store_event(Auth::EVT_BTN_CLICK,'Stat \ Set filters');
        break;

//------------------------------------------------------------------------------------------------
case 'cmd_download':
    $name = Lib::sanitize($_POST['file_name'],Lib::T_STR);
    $path = __DIR__.'/files/'.$name;
    if (file_exists($path)) {
        header('Content-Type: ' . Lib::get_file_mime_type($path));
        header('Content-Disposition: inline; filename='.$name.";filename*=UTF-8''".urlencode($name));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        readfile($path);
        exit;
    } else {
        $response = Lib::create_response('RC_404','','',[]); 
    }   
    break;
//------------------------------------------------------------------------------------------------
    default:
        $response = Lib::create_response('RC_CMD_UNKNOWN','','/views/login.php',[]); 
}

Lib::send_response($response);