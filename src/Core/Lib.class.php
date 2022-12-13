<?php
namespace Core;

class Lib {
    public const T_ANY   = 0;
    public const T_STR   = 1;
    public const T_INT   = 2;
    public const T_FLOAT = 3;
    public const T_BIT   = 4;
    public const T_EMAIL = 5;
  
  
    public static function create_response(string $code, string $msg, string $redirect = '', array $data = []) : array
    {
        return [
            'code' => $code,
            'msg'  => $msg,
            'goto' => $redirect,
            'data' => $data
        ];
    }   

    public static function send_ajax_response(array $response) : void
    {
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($response);
    }   
    
    public static function sanitize(mixed $var, int $type) : mixed
    {
        //TODO need a realization
        return $var;
    }   

    public static function is_post_request() : bool
    {
        return !empty($_POST);
    }

    public static function is_ajax_request() : bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    public static function remember_response(string $alias, array $response) : void
    {
        $_SESSION[$alias] = $response;
    }

    public static function send_response(array $response) : void
    {
        if(self::is_ajax_request()) {
            self::send_ajax_response($response);
            exit;
        } elseif(!empty($response['goto']))  {
            header('Location: '.$response['goto']);
            exit;          
        } else {
            echo '400 Bad Request';
        }
    }

    public static function get_file_mime_type(string $fileName) : string 
    {
        $finfo  = finfo_open(FILEINFO_MIME_TYPE); // возвращает mime-тип
        $result = finfo_file($finfo, $fileName);
        finfo_close($finfo);
        return $result;
    }


}