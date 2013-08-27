<?php namespace CentralinoFluentQueryBuilder\Builder; use PDO;

class Build
{
  private static $_pdo;

  protected static $_table;

  public function __construct(PDO $pdo)
  {
    self::$_pdo = $pdo;
  }

  public function table($table)
  {
    switch(self::$_pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
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
}