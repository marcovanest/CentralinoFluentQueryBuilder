<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Group extends Builder
{
  public $column;

  public function __construct($column)
  {
    parent::$_build['group'] = new \ArrayObject();

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

  public function column($column)
  {      
    $this->column = new Column($column, 'normal');

    parent::$_build['group']->append($this);
   
    return $this;
  }
}