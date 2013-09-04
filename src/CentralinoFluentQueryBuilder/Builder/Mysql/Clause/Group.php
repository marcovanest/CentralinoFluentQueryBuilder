<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\Clause;

use CentralinoFluentQueryBuilder\Builder\Mysql;

class Group extends Mysql\Builder
{
  private $_column;

  public function __construct($column)
  {
    parent::$_build['group'] = array();

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
    $this->_column = new Mysql\Column();
    $this->_column->setName($column);
    $this->_column->setType('normal');

    parent::$_build['group'][] = $this;
   
    return $this;
  }
}