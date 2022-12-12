<?php
namespace Core;

class Db
{
  public const ERR_NONE = '';
  public const ERR_DB_NO_CONNECT = 'CONNECTION FAILED';

  private $f_result = FALSE;
  private $f_err    = self::ERR_NONE;
  private $f_conn   = NULL;
  private $f_count  = 0;
  
  static private $instance = NULL;

  /**
   * Undocumented function
   *
   * @param array $cfg
   * @return object
   */
  static function get_instance() : object
  {
    if (!self::$instance)  {
      self::$instance = new Db(require __DIR__ . "/../../inc/cfg.inc.php");
    }
    return self::$instance;
  }
  
  /**
   * Undocumented function
   *
   * @param array $f_cfg
   */
  public function __construct(private array $f_cfg)
  {
      if(!$this->_connect())  { 
        echo "Error: " . $this->get_last_error();
      }
  }


  /**
   * Undocumented function
   *
   * @return void
   */
  public function __destruct()
  {
      $this->_disconnect();
  }


  /**
   * Undocumented function
   *
   * @return string
   */
  public function get_last_error() : string
  {
    return $this->f_err;
  }

/**
 * Undocumented function
 *
 * @return void
 */
  function _reset() : void
  {
    $this->f_count = NULL;
    if($this->f_result) { 
      $this->f_result->free(); 
      $this->f_result = NULL; 
    }
  }

  /**
   * Undocumented function
   *
   * @return boolean
   */
  function _connect():bool
  {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    ['DB_HOST'=>$host, 'DB_NAME'=>$db, 'DB_USER'=>$user, 'DB_PASS'=>$pwd, 'DB_PORT'=>$port] = $this->f_cfg;
    var_dump($this->f_cfg);
    try{
      $this->f_conn = new \mysqli($host, $user, $pwd, $db, $port);
    } catch(\Throwable $e) {
      $this->f_err = $e->getTraceAsString();
    } finally {
      if ($this->f_conn && $this->f_conn->connect_errno) {
        $this->f_err = $this->f_conn->connect_error;
      }
      if($this->f_err) {
        $this->f_conn = NULL;
      }
    }
    return (bool)$this->f_conn;
  }

  //----------------------------------------------------------------------------
  // Non-secure way. For instance only
  //----------------------------------------------------------------------------
  /**
   * Undocumented function
   *
   * @param string $qstr
   * @return void
   */
  public function query(string $qstr):void
  {
    $this->_reset();
    if($this->f_conn) {
      $this->f_result = $this->f_conn->query($qstr);
      $this->f_count  = $this->f_result->num_rows;
      $this->first();
    } else {
      $this->f_err = self::ERR_DB_NO_CONNECT;
    }
  }

  /**
   * Undocumented function
   *
   * @return array
   */
  public function get_result_array() : array
  {
    return $this->f_result 
              ? $this->f_result->fetch_all(MYSQLI_ASSOC) 
              : [];
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  function _disconnect() : void
  {
    if($this->f_conn) {
      $this->f_conn->close();
    }
    $this->f_err = self::ERR_NONE;
  }

  /**
   * Undocumented function
   *
   * @return boolean
   */
  public function first() : bool
  {
    return $this->empty()
              ? false
              : $this->f_result->data_seek(0);
  }

  /**
   * Undocumented function
   *
   * @return array|null
   */
  public function next() : ?array
  {
    return $this->empty() 
            ? null
            : ($this->f_result->fetch_assoc() || null);
  }

  /**
   * Undocumented function
   *
   * @return integer
   */
  public function get_count() : int
  {
    return $this->f_count;
  }

  /**
   * Undocumented function
   *
   * @return boolean
   */
  public function empty() : bool
  {
    return (!$this->f_result || !$this->f_count);
  }
}
?>
