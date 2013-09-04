<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\DMS;

use CentralinoFluentQueryBuilder\Builder\Interfaces;
use CentralinoFluentQueryBuilder\Builder\Mysql;

class Insert extends Mysql\Syntax implements Interfaces\Insert
{
  private $_columns;

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

  /**
   * return the insert columns and values
   * @return [type]
   */
  public function getColumns()
  {
    return $this->_columns;
  }

  public function columns(array $columns)
  {
    foreach ($columns as $column => $value) 
    {
      $columnobject = new Mysql\Column();
      $columnobject->setName($column);
      $columnobject->setValue($value);
      $columnobject->setType('normal');

      $this->_columns[] = $columnobject;
    }
    
    return $this;
  }

}