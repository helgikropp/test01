<?php
use Core\Db;

session_start();

spl_autoload_register(
    function ($class) {
        //require_once '/../src/' . strtolower(str_replace('\\', '/', $class) . '.class.php');
        require_once __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.class.php';
        //include __DIR__ . '../src/' . $class . '.class.php';
    }, 
    true, 
    false
);

$DB = Db::get_instance();

echo "<br>------------\n"; 
echo __DIR__;
echo "<br>------------\n"; 
