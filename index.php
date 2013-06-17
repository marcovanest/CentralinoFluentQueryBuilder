<?php

include 'src/Bootstrap.php';

$pdo = new PDO('mysql:host=127.0.0.1;dbname={DB}', '{USER}', '{PASSWORD}');

$connection = new CentralinoFluentQueryBuilder\Connection($pdo);

$fluent     = $connection->fluentQuery();


$builder = $fluent::table('wp_users');

$builder->select(array('*'));

$builder->join('wp_usermeta')->on('user_id', '=', 'wp_users.ID');

$builder->join('wp_usermeta')->nested(function($builder){
  $builder->on('user_id', '=', 'wp_users.ID');
  $builder->on('user_id', '=', 'wp_users.ID');
});

$builder->where()->nested(function($builder){
  $builder->compare('user_id', '=', 5);
  $builder->compare('user_id', '=', 6);
  $builder->between('user_id', 1, 6);
  $builder->in('user_id', array(1,4));
});

$builder->where('user_id')->in(array(1,4));
$builder->where('user_id')->notin(array(1,4));

$builder->where('user_id')->between(7, 8);

$builder->where('user_id')->compare('=', 'wp_users.ID');

$builder->where('user_id')->like('5');
$builder->where('user_id')->notlike('5');

$builder->where('user_id')->isnull();
$builder->where('user_id')->isnotnull();

$builder->limit(0, 5);
$builder->order('user_id', 'ASC');
$builder->group('user_id');

$s = $builder->transform();

echo '<pre>';
print_r($s);
