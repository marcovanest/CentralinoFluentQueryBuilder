<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

use CentralinoFluentQueryBuilder\Builder;
use CentralinoFluentQueryBuilder\Builder\Mysql;

class Syntax 
{
  protected $_nested = false;

  protected static $_build = array();

  protected $_conditionposition;

  public function __construct()
  {
    self::$_build = '';
  }

  public function target($table)
  {    
    self::$_build['target'] = new Target($table);

    return $this;
  }

  public function select($fields = array())
  {
    return new DMS\Select($fields);
  }

  public function insert($fields = array())
  {
    return new DMS\Insert($fields);
  }

  public function join($table)
  {
    $join = new Join($table);

    return $join;
  }

  public function inner_join($table)
  {
    return new Join($table, 'inner');
  }

  public function left_join($table)
  {
    return new Join($table, 'left');
  }

  public function right_join($table)
  {
    return new Join($table, 'right');
  }

  public function where($table = null)
  {
    return new Clause\Where($table);
  }

  public function or_where($table = null)
  {
    return new Clause\Where($table, 'OR');
  }

  public function nested(\Closure $function)
  {
    if($this instanceof Join || 
        $this instanceof Mysql\Clause\Where )  
    {
      return $this->_handleNestedConditions($function, 'AND');
    }
  }

  public function or_nested(\Closure $function)
  {
    if($this instanceof Join || 
        $this instanceof Mysql\Clause\Where )
    {
      return $this->_handleNestedConditions($function, 'OR');
    }
  }
  
  public function limit($offset, $amountofrows = null)
  {
    $limit = new Mysql\Clause\Limit($offset, $amountofrows);

    return $this;
  }

  public function order($columns, $direction = null)
  {
    $order = new Mysql\Clause\Order($columns, $direction);

    return $this;
  }

  public function group($column)
  {
    $order = new Mysql\Clause\Group($column);

    return $this;
  }

  public function get()
  {
    $parser = new Builder\Parser(self::$_build);
    return $parser->parse();
  }

  protected function prepareArguments($left, $arguments)
  {
    if(empty($left))
    {
      return $arguments;
    }
    else
    {
      array_unshift($arguments, $left);

      return $arguments;
    }
  }
}

