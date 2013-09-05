<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\Clause;

use CentralinoFluentQueryBuilder\Builder\General;
use CentralinoFluentQueryBuilder\Builder\Interfaces;
use CentralinoFluentQueryBuilder\Builder\Mysql;

class Group extends Mysql\Syntax implements Interfaces\Group
{
  private $_column;

  public function __construct($column)
  {
    if($column instanceof \Closure)
    {
      if(is_callable($column))
      {
        call_user_func($column, $this);
      }
    }
    else
    {
      $this->column($column);
    }
  }

  /**
   * return the columnobject
   * 
   * @return string
   */
  public function getColumn()
  {
    return $this->_column;
  }

  public function column($column)
  {      
    $this->_column = new General\Column();
    $this->_column->setName($column);
    $this->_column->setType('normal');
   
    return $this;
  }
}