<?php namespace Centralino\Core\DatabaseManager\Statement\Builder;

use Centralino\Core\DatabaseManager\Connection;

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
}