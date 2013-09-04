<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Builder
{
  protected $_nested = false;

  protected static $_build = array();

  protected $_conditionposition;

  protected $_nestedoperators;

  public function __construct()
  {
    
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
    return new Join($table);
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
        $this instanceof Clause\Where )  
    {
      return $this->_handleNestedConditions($function, 'AND');
    }
  }

  public function or_nested(\Closure $function)
  {
    if($this instanceof Join || 
        $this instanceof Clause\Where )
    {
      return $this->_handleNestedConditions($function, 'OR');
    }
  }
  
  public function limit($offset, $amountofrows = null)
  {
    $limit = new Clause\Limit($offset, $amountofrows);

    return $this;
  }

  public function order($columns, $direction = null)
  {
    $order = new Clause\Order($columns, $direction);

    return $this;
  }

  public function group($column)
  {
    $order = new Clause\Group($column);

    return $this;
  }

  public function get()
  {
    $parser = new Parser();
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

