<?php
namespace Core;

use Core\Lib;
use Core\Db; 

class Stat {

    public static function get_events(array $filters) : array
    {
      $db = Db::get_instance();

      $qstr = "SELECT e.id, e.date, u.login, t.name AS `type`, e.`target`"
        . " FROM events e"
        . " LEFT JOIN users u ON u.id = e.user_id"
        . " LEFT JOIN event_types t ON t.id = e.type_id"
        . " WHERE 1=1";

        if($filters['from']) {
          $qstr .= " AND e.date >= '" . $filters['from'] . "'"; 
        }
        if($filters['to']) {
          $qstr .= " AND e.date <= '" . $filters['to'] . "'"; 
        }
        if($filters['user']) {
          $qstr .= " AND e.user_id = " . $filters['user']; 
        }
        if($filters['action']) {
          $qstr .= " AND e.type_id = " . $filters['action']; 
        }
        $qstr .= " ORDER BY e.date DESC";

        $db->query($qstr);
        return $db->get_result_array();
    }

    public static function get_event_types() : array
    {
      $db = Db::get_instance();

      $qstr = "SELECT id, `name`"
        . " FROM event_types ORDER BY id";
      $db->query($qstr);

      return $db->get_result_array();
    }

}