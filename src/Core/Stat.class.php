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

        if(!empty($filters['from'])) {
          $qstr .= " AND e.date >= '" . $filters['from'] . "'"; 
        }
        if(!empty($filters['to'])) {
          $qstr .= " AND e.date <= '" . $filters['to'] . "'"; 
        }
        if(!empty($filters['user'])) {
          $qstr .= " AND e.user_id = " . $filters['user']; 
        }
        if(!empty($filters['action'])) {
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

    public static function get_report() : array
    {
      $db = Db::get_instance();
      $rec = [
        'chart' => [],
        'table' => []
      ];
$qstr = <<<SQL
SELECT CONCAT(
  'SELECT DATE(e.date) AS `date`, ',
  (
    SELECT GROUP_CONCAT(DISTINCT CONCAT(
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
  ' GROUP BY 1'
) AS pivot_sql;
SQL;
      
      $db->query($qstr);
      $res = $db->get_result_array();
      if($res[0]['pivot_sql']) {
        $db->query($res[0]['pivot_sql']);
        $rec['table'] = $db->get_result_array();
      }

$qstr = <<<SQL
SELECT CONCAT(
  'SELECT CONCAT(t.name,'' '',e.target) AS `action`, ',
  (
    SELECT GROUP_CONCAT(DISTINCT CONCAT(
      'SUM(
        CASE WHEN DATE(e.date) = ''', DATE(e.date), ''' THEN 1 ELSE 0 END) 
        AS ', CONCAT('`',DATE(e.date),'`'))
      ) AS sub_sql
    FROM events e
    LEFT JOIN event_types t ON t.id = e.type_id
    WHERE e.type_id IN (4,5) AND LEFT(e.target,1) IN ('B','D','P')
  ), 
  ' FROM events e',
  ' LEFT JOIN event_types t ON t.id = e.type_id',
  ' GROUP BY 1'
) AS pivot_sql;
SQL;
      
      $db->query($qstr);
      $res = $db->get_result_array();
      if($res[0]['pivot_sql']) {
        $db->query($res[0]['pivot_sql']);
        $rec['chart'] = $db->get_result_array();
      }

      return $rec;
    }


}