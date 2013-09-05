<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\DMS;


use CentralinoFluentQueryBuilder\Builder\General;
use CentralinoFluentQueryBuilder\Builder\Interfaces;
use CentralinoFluentQueryBuilder\Builder\Mysql;

class Insert extends Mysql\Syntax implements Interfaces\Insert
{
  private $_target;

  private $_columns = array();

  private $_select = null;

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

  /**
   * return the insert columns and values
   * @return array
   */
  public function getColumns()
  {
    return $this->_columns;
  }

  public function getTarget()
  {
    return $this->_target;
  }

  public function getSelect()
  {
    return $this->_select;
  }

  /**
   * sets the select statement if a insert ... select ...  is used
   * 
   * @param  array $select
   * @return Insert
   */
  public function select($select = array())
  {
    $this->_select = $select;
    return $this;
  }

  public function columns(array $columns)
  {
    foreach ($columns as $column => $value) 
    {
      $columnobject = new General\Column();
      $columnobject->setName($column);
      $columnobject->setValue($value);
      $columnobject->setType('normal');

      $this->_columns[] = $columnobject;
    }
    
    return $this;
  }

}