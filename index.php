<?php

include 'src/Bootstrap.php';

$pdo = new PDO('mysql:host=127.0.0.1;dbname=lmoors', 'root', 'tar');

$connection = new CentralinoFluentQueryBuilder\Connection($pdo);

$fluent     = $connection->fluentQuery();


$builder = $fluent::table('wp_users');

$builder->select(array('*'));
//$builder->join('wp_usermeta')->on('user_id', '=', 'wp_users.ID');

$builder->join('wp_usermeta')->nested(function($builder){
  $builder->on('user_id', '=', 'wp_users.ID');
  $builder->on('user_id', '=', 'wp_users.ID');
});

$builder->where()->nested(function($builder){
  $builder->where('user_id', '=', 5);
  $builder->where('user_id', '=', 6);
  $builder->between('user_id', 1, 6);
})->where()->in('user_id', array(1,4));

$builder->limit(0, 5);
$builder->order('user_id', 'ASC');
$builder->group('user_id');

$s = $builder->transform();

echo '<pre>';
print_r($s);
