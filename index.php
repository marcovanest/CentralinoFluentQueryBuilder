<?php
include 'src/Bootstrap.php';

$pdo = new PDO('mysql:host=127.0.0.1;dbname={DB}', '{USER}', '{PASSWORD}');

$connection = new CentralinoFluentQueryBuilder\Connection($pdo);

$fluent     = $connection->fluentQuery();


$builder = $fluent::table('wp_users');

$builder->select(array('*'));

$builder->join('wp_usermeta')->alias('metadata')->on('user_id', '=', 'wp_users.ID');

$builder->join('wp_usermeta')

->nested(function($builder){
  $builder->on('1', '=', '1');
  $builder->on('2', '=', '2');
})
->or_nested(function($builder){
  $builder->on('user_id', '=', 'wp_users.ID');
  $builder->on('user_id', '=', 'wp_users.ID');
})
->nested(function($builder){
  $builder->on('1', '=', '1');
  $builder->on('2', '=', '2');
})->where_size('324');


$builder->where()->nested(function($where){
 $where->compare('user_id', '=', 5);
 $where->between('user_id', 1, 6);


  $where->isnull('user_id');
  $where->isnotnull('user_id');

  $where->like('user_id', 'test');
  $where->notlike('user_id', 'test');
})->or_where()->nested(function($where){
    $where->or_in('user_id', array(1,4));
  $where->notin('user_id', array(1,4));

});

//$builder->where('user_id')->compare('=', 'wp_users.ID');
//$builder->where('user_id')->between(7, 8);

// $builder->where('user_id')->in(array(1,4));
// $builder->where('user_id')->notin(array(1,4));

// $builder->where('user_id')->isnull();
// $builder->where('user_id')->isnotnull();

// $builder->where('user_id')->like('5');
// $builder->where('user_id')->notlike('5');

// $builder->or_where('user_id')->notlike('5');

// $builder->limit(0, 5);

// $builder->order('user_id', 'ASC');

// $builder->group('user_id');

$s = $builder->get();

echo '<pre>';
print_r($s);
