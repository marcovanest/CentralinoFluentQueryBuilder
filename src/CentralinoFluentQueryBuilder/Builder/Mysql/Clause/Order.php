<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\Clause;

use CentralinoFluentQueryBuilder\Builder\Mysql;

class Order extends Mysql\Builder
{
  public $column;
  public $direction;

  public function __construct($column, $direction)
  {
    parent::$_build['order'] = new \ArrayObject();

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

  public function column($column, $direction)
  {      
    $this->column    = new Mysql\Column($column, 'normal');
    $this->direction = $direction;

    parent::$_build['order']->append($this);
   
    return $this;
  }
}