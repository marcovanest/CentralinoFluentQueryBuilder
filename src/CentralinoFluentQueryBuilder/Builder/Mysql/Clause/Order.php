<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\Clause;

use CentralinoFluentQueryBuilder\Builder\Mysql;

class Order extends Mysql\Builder
{
  private $_column;
  private $_direction;

  public function __construct($column, $direction = 'ASC')
  {
    parent::$_build['order'] = array();

    if($column instanceof \Closure)
    {
      if(is_callable($column))
      {
        call_user_func($column, $this);
      }
    }
    else
    {
      $this->column($column, $direction);
      
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

  /**
   * return the order direction
   * 
   * @return [type]
   */
  public function getDirection()
  {
    return $this->_direction;
  }

  /**
   * Specifies the column of the order by clause
   * 
   * @param  string $column
   * @param  string $direction
   * @return Order
   */
  public function column($column, $direction)
  {      
    $this->_direction = $direction;

    $this->_column = new Mysql\Column();
    $this->_column->setName($column);
    $this->_column->setType('normal');

    parent::$_build['order'][] = $this;
   
    return $this;
  }

}