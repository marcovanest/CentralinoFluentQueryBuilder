<?php namespace CentralinoFluentQueryBuilder\Builder;

use CentralinoFluentQueryBuilder\Connection;

class General
{
  private static $_connection;

  protected static $_table;

  public function __construct(Connection $connection)
  {
    self::$_connection = $connection;
  }

  public static function table($table)
  {
    switch(self::$_connection->getDriverName())
    {
      case 'mysql':
        return new Mysql\From($table);
    }
  }

  public static function validateOperator($operator)
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

  protected function execute($sql)
  {
    return self::$_connection->prepare($sql);
  }
}