<?php namespace Centralino\Core\DatabaseManager\Statement\Builder\Mysql;

use Centralino\Core\DatabaseManager\Statement\Builder\General;

class Builder extends General
{
  protected static $_build = array();

  protected $_type;

  public function __construct()
  {
    
  }

  public function select(array $fields)
  {
    return new Select($fields);
  }

  public function join($table)
  {
    return new Join($table);
  }

  public function where()
  {
    return new Where();
  }

  public function nested(\Closure $function)
  {
    $class = $this;

    if(is_callable($function))
    {
      call_user_func($function, $this);
    }

    return $this;
  }

  public function transform()
  {
    echo '<pre>';
    print_r(self::$_build);
  }
}
