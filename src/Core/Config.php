<?php

session_start();

$s = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 's' : '');

define("BASE_PATH", "http{$s}://{$_SERVER['HTTP_HOST']}/development/APIs/API_VTES");
define("IMAGE_PATH", BASE_PATH . "/cdn/media/images/cardImages/" );

define('DATA_LAYER_CONFIG', [
	'driver' => 'mysql',
	'host' => 'localhost',
	'port' => '3306',
	'dbname' => 'vtes_2022',
	'username' => 'root',
	'passwd' => '',
	'options' => [
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		PDO::ATTR_CASE => PDO::CASE_NATURAL,
	],
]);
