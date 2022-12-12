<?php
namespace Core;

use Core\Lib;
use Core\Db; 

class Auth {
    public const EVT_LOGON     = 1; // Login
    public const EVT_LOGOUT    = 2; // Logout
    public const EVT_REG       = 3; // Registration
    public const EVT_PAGE_VIEW = 4; // Page view
    public const EVT_BTN_CLICK = 5; // Button click

    public static function logon(string $uname, string $upass) : bool
    {
      $db = Db::get_instance();

      $qstr = "SELECT id, `login`, email, is_admin"
      . " FROM users"
      . " WHERE login='".LIb::sanitize($uname,Lib::T_STR)."' AND pass='".md5(Lib::sanitize($upass,Lib::T_STR))."';";
      $db->query($qstr);
      if($user = $db->next()) {
        $_SESSION['user'] = $user;
        return true;
      }
      return false;
    }

    public static function logout() : void
    {
      $_SESSION['user'] = [];
    }

    public static function get_user() : array
    {
      return $_SESSION['user'];
    }
    
    public static function is_authenticated() : bool
    {
      return !empty($_SESSION['user']);
    }    

    public static function is_admin_session() : bool
    {
      return self::is_authenticated() && $_SESSION['user']['is_admin'] === 1;
    }    
    
    public static function register(string $uname, string $upass, string $email, int $is_admin) : bool
    {
      $db = Db::get_instance();

      //TODO check if the email is unique
      //TODO check the password for password policies 

      $uname = LIb::sanitize($uname,Lib::T_STR);
      $upass = Lib::sanitize($upass,Lib::T_STR);

      $qstr = "SELECT id"
      . " FROM users"
      . " WHERE login='".$uname."' AND pass='".md5(Lib::sanitize($upass,Lib::T_STR))."';";
      $db->query($qstr);
      if(!$db->empty) {
        return false;
      }

      $email    = Lib::sanitize($email,Lib::T_EMAIL);
      $is_admin = Lib::sanitize($upass,Lib::T_BIT);
      $qstr = "INSERT INTO users (`login`, pass, email, is_admin)"
      . " VALUES('".$uname."', '".md5($upass)."', '".$email."', ".$is_admin.");";
      $db->query($qstr);

      return true;
    }

    public static function store_event(int $event_type, ?string $event_target) : void
    {
      $db = Db::get_instance();

      $event_target = $event_target ? LIb::sanitize($event_target,Lib::T_STR) : '';

      $qstr = "INSERT INTO events (user_id, `type`, 'target')"
      . " VALUES(".($_SESSION['id']??'0').", '".$event_target."')";
      $db->query($qstr);
    }

}