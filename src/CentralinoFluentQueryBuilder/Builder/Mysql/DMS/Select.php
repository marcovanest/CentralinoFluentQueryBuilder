<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\DMS;

use CentralinoFluentQueryBuilder\Builder\General;
use CentralinoFluentQueryBuilder\Builder\Interfaces;
use CentralinoFluentQueryBuilder\Builder\Mysql;

class Select extends Mysql\Syntax implements Interfaces\Select
{
  private $_target;
  private $_columns = array();
  private $_joins   = array();
  private $_wheres  = array();
  private $_limit;
  private $_order;
  private $_group;

  public function __construct($columns)
  {
    $this->_target = static::$_targettable;

    if(is_array($columns))
    {
      return $this->columns($columns);
    }
    if($columns instanceof \Closure)
    {
      if(is_callable($columns))
      {
        call_user_func($columns, $this);
      }
    }
  }

  public function getColumns()
  {
    return $this->_columns;
  }

  public function getTarget()
  {
    return $this->_target;
  }

  public function getJoins()
  {
    return $this->_joins;
  }

  public function getWheres()
  {
    return $this->_wheres;
  }

  public function getLimit()
  {
    return $this->_limit;
  }

  public function getOrder()
  {
    return $this->_order;
  }

  public function getGroup()
  {
    return $this->_group;
  }

  public function from($table)
  {
    $this->_target = new Mysql\Target($table);

    return $this;
  }

  protected function _addJoin($table, $join)
  {
    $this->_joins[$table][] = $join;
  }

  protected function _addWhere($where)
  {
    $this->_wheres[] = $where;
  }

  protected function _addLimit($limit)
  {
    $this->_limit = $limit;
  }

  protected function _addOrder($order)
  {
    $this->_order[] = $order;
  }

  protected function _addGroup($group)
  {
    $this->_group[] = $group;
  }

  public function columns(array $columns, $table = null)
  {
    foreach ($columns as $columnname) 
    {
      $columnobject = new General\Column();
      $columnobject->setName($columnname);
      $columnobject->setType('normal');
      $columnobject->setTable($table);

      $this->_columns[] = $columnobject;
    }
    
    return $this;
  }

  public function count($columnname, $table = null)
  {
    $columnobject = new General\Column();
    $columnobject->setName($columnname);
    $columnobject->setType('count');
    $columnobject->setTable($table);
    
    $this->_columns[] = $columnobject;

    return $this;
  }

  public function countdistinct($column, $table = null)
  {
    $columnobject = new General\Column();
    $columnobject->setName($columnname);
    $columnobject->setType('countdistinct');
    $columnobject->setTable($table);
    
    $this->_columns[] = $columnobject;

    return $this;
  }

  public function sum($columnname, $table = null)
  {
    $columnobject = new General\Column();
    $columnobject->setName($columnname);
    $columnobject->setType('sum');
    $columnobject->setTable($table);
    
    $this->_columns[] = $columnobject;

    return $this;
  }

  public function min($columnname, $table = null)
  {
    $columnobject = new General\Column();
    $columnobject->setName($columnname);
    $columnobject->setType('min');
    $columnobject->setTable($table);
    
    $this->_columns[] = $columnobject;

    return $this;
  }

  public function max($columnname, $table = null)
  {
    $columnobject = new General\Column();
    $columnobject->setName($columnname);
    $columnobject->setType('max');
    $columnobject->setTable($table);
    
    $this->_columns[] = $columnobject;

    return $this;
  }

  public function avg($columnname, $table = null)
  {
    $columnobject = new General\Column();
    $columnobject->setName($columnname);
    $columnobject->setType('avg');
    $columnobject->setTable($table);
    
    $this->_columns[] = $columnobject;

    return $this;
  }

  public function __call($function, $arguments)
  {
    $functionparts  = explode('_', $function);
    $function       = array_pop($functionparts);
    $table          = implode('_', $functionparts);

    if(method_exists($this, $function))
    {
      call_user_func(array($this, $function), $arguments[0], $table);
    }
  }
}