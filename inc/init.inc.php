<?php
//set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__).'/vendor');

use Core\Db;

session_start();

spl_autoload_register(
    function ($class) {
        require_once __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.class.php';
    }, 
    true, 
    false
);

