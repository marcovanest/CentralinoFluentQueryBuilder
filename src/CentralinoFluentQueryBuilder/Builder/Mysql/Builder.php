<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

use CentralinoFluentQueryBuilder\Builder\General;

class Builder extends General
{
  protected $nested = false;

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
    $this->nested = true;

    if(is_callable($function))
    {
      if($this instanceof Join)
      {
        $this->on_position = count(self::$_build[$this->_type][$this->table]);
      }
      if($this instanceof Where)
      {
        $this->where_position = count(self::$_build[$this->_type]);
      }

      call_user_func($function, $this);
    }

    $this->nested = false;

    return $this;
  }

  public function transform()
  {
    echo '<pre>';
    print_r(self::$_build);
  }
}
