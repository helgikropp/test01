<?php
  header('Location: /views/login.php');
  exit;
require_once "../inc/init.inc.php";
//echo "test01!!!!";
//Core\Lib::test();
$DB->query('SELECT * FROM users;');
var_dump($DB->get_result_array());