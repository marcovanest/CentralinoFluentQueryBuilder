<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\DMS;

use CentralinoFluentQueryBuilder\Builder\General;
use CentralinoFluentQueryBuilder\Builder\Interfaces;
use CentralinoFluentQueryBuilder\Builder\Mysql;

class Select extends Mysql\Syntax implements Interfaces\Select
{
  private $_columns = array();

  public function __construct($columns)
  {
    parent::$_build['dms'] = $this;

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