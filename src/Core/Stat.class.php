<?php
namespace Core;

use Core\Lib;
use Core\Db; 

class Stat {

    public static function get_events(array $filters) : ?array
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

}