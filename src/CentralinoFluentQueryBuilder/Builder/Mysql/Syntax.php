<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

use CentralinoFluentQueryBuilder\Builder;
use CentralinoFluentQueryBuilder\Builder\Interfaces;
use CentralinoFluentQueryBuilder\Builder\Mysql;

class Syntax implements Interfaces\Syntax
{
  protected static $_targettable;

  protected static $_dms;

  public function __construct()
  {

  }

  public function getSyntaxInstance()
  {
    return $this;
  }

  public function target($table)
  {    
    static::$_targettable = new Target($table);

    return $this;
  }

  public function select($fields = array())
  {
    static::$_dms = new DMS\Select($fields);

    return static::$_dms;
  }

  public function insert($fields = array())
  {
    static::$_dms = new DMS\Insert($fields);

    return static::$_dms;
  }

  public function join($table)
  {
    $join = new Join($table);
    static::$_dms->_addJoin($table, $join);
    
    return $join;
  }

  public function inner_join($table)
  {
    $join = new Join($table, 'inner');
    static::$_dms->_addJoin($table, $join);
    
    return $join;
  }

  public function left_join($table)
  {
    $join = new Join($table, 'left');
    static::$_dms->_addJoin($table, $join);
    
    return $join;
  }

  public function right_join($table)
  {
    $join = new Join($table, 'right');
    $this->_joins[$table][] = $join;
    
    return $join;
  }

  public function where($table = null)
  {
    $where = new Clause\Where($table);
    static::$_dms->_addWhere($where);
    
    return $where;
  }

  public function or_where($table = null)
  {
    $where = new Clause\Where($table, 'OR');
    static::$_dms->_addWhere($where);
    
    return $where;
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
    static::$_dms->_addLimit($limit);

    return $limit;
  }

  public function order($columns, $direction = null)
  {
    $order = new Mysql\Clause\Order($columns, $direction);
    static::$_dms->_addOrder($order);

    return $order;
  }

  public function group($column)
  {
    $group = new Mysql\Clause\Group($column);
    static::$_dms->_addGroup($group);

    return $group;
  }

  public function asString()
  {
    $parser = new Builder\Parser(static::$_dms);

    return $parser->parse();
  }

  public function asObject()
  {
    return static::$_dms;
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

