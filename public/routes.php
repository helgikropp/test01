<?php
//session_start();
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
        Auth::logout();
        $response = Lib::create_response('RC_OK','','/views/login.php',[]); 
        Auth::store_event(Auth::EVT_LOGOUT,'');
        break;

//------------------------------------------------------------------------------------------------
    case 'cmd_click':
        $response = Lib::create_response('RC_OK','','',[]); 
        Auth::store_event(Auth::EVT_BTN_CLICK,$_POST['target']);
        break;

//------------------------------------------------------------------------------------------------
case 'cmd_click':
    $response = Lib::create_response('RC_OK','','',[]); 
    Auth::store_event(Auth::EVT_BTN_CLICK,$_POST['target']);
    break;

//------------------------------------------------------------------------------------------------
    default:
        $response = Lib::create_response('RC_CMD_UNKNOWN','','/views/login.php',[]); 
}

Lib::send_response($response);