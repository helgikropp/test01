<?php
namespace Core;

class Db
{

  private $f_count  = 0;
  
  static private $instance = NULL;

 
  /**
   * Undocumented function
   *
   */
  public function __construct()
  {
      //if(!$this->_connect())  { 
      //  echo "Error: " . $this->get_last_error();
     // }
  }

    /**
   * Undocumented function
   *
   * @param array $cfg
   * @return void
   */
  static function get_instance()
  {
    if (!self::$instance)  {
      self::$instance = new Db(require __DIR__ . "/../../inc/cfg.inc.php");
    }
    return self::$instance;
  }
}