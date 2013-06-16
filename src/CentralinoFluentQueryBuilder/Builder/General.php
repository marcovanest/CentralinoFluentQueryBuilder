<?php namespace CentralinoFluentQueryBuilder\Builder;

use CentralinoFluentQueryBuilder\Connection;

class General
{
  private static $_connection;

  protected static $_table;

  public function __construct(Connection $connection)
  {
    static::$_connection = $connection;
  }

  public static function table($table)
  {
    static::$_table = $table;

    switch(static::$_connection->getDriverName())
    {
      case 'mysql':
        return new Mysql\Builder();
    }
  }

  public static function valdiateOperator($operator)
  {
    $operators = array();
    $operators[] = '=';
    $operators[] = '<=>';
    $operators[] = '>=';
    $operators[] = '>';
    $operators[] = '<=';
    $operators[] = '<';
    $operators[] = '<>';
    $operators[] = '!=';

    if(!in_array($operator, $operators))
    {
      throw new Exception("Invalid operator given", 1);
    }
  }
}