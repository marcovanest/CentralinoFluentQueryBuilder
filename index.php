<?php
include 'src/Bootstrap.php';

$pdo        = new PDO('mysql:host=127.0.0.1;dbname={DB}', '{USER}', '{PASSWORD}');
$connection = new CentralinoFluentQueryBuilder\Connection($pdo);


/**
 * Simple Select
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(array('*'))
                  ->get();

/**
 * Complex Select nested
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(function($builder){
                      $builder->columns(array('ID')); //No table prefix
                      $builder->columns(array('wp_users.ID')); //With table prefix
                      $builder->wp_users_columns(array('user_status', 'display_name')); //No table prefix, but with function prefix
                  })
                  ->get();

/**
 * Simple Join
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(array('*'))
                  ->join('wp_usermeta')->on('wp_usermeta.user_id', '=', 'wp_users.ID')
                  ->get();

/**
 * Complex Join nested
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(array('*'))
                  ->join('wp_usermeta')->nested(function($builder){
                    $builder->on('wp_usermeta.user_id', '=', 'wp_users.ID');
                    $builder->on('wp_usermeta.umeta_id', '=', 4);
                  })
                  ->get();

/**
 * Complex Join multiple nesting
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(array('*'))
                  ->join('wp_usermeta')
                      ->nested(function($builder){
                        $builder->on('wp_usermeta.user_id', '=', 'wp_users.ID');
                      })
                      ->or_nested(function($builder){
                        $builder->on('wp_usermeta.user_id', '=', 7);
                      })
                  ->get();

/**
 * Simple Where
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(array('*'))
                  ->where('wp_users.user_id')->compare('=', 4)
                  ->or_where('wp_users.user_id')->compare('=', 5)
                  ->get();

/**
 * Complex Where nested
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(array('*'))
                  ->where()
                    ->nested(function($builder){
                      $builder->compare('wp_users.ID', '=', 5); //Compare condition
                      $builder->between('wp_users.ID', 1, 6); //Between condition
                    })
                    ->or_nested(function($builder){
                      $builder->isnull('wp_users.ID'); //IS NULL condition
                      $builder->isnotnull('wp_users.ID'); //IS NOT NULL condition
                    })
                    //Logicaloperator AND is not prefixed
                    ->nested(function($builder){
                      $builder->like('wp_users.ID', 'test'); //LIKE condition
                      $builder->notlike('wp_users.ID', 'test'); // NOT LIKE condition
                    })
                    //Logicaloperator OR is prefixed
                    ->or_nested(function($builder){
                      $builder->in('wp_users.ID', array(1,4)); //IN condition
                      $builder->or_notin('wp_users.ID', array(1,4)); //NOTIN condition
                    })
                  ->get();

/**
 * LIMIT
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(array('*'))
                  ->limit(0, 5)
                  ->get();

/**
 * ORDER BY
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(array('*'))
                  ->order('user_id', 'ASC')
                  ->get();

/**
 * GROUP BY
 */
$fluent  = $connection->fluentQuery();
$stm     = $fluent::table('wp_users')
                  ->select(array('*'))
                  ->group('user_id')
                  ->get();
