<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Select extends Builder
{
  public $columns;

  public function __construct($columns)
  {
    parent::$_build['select'] = new \ArrayObject();

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

  public function columns(array $columns)
  {
    foreach ($columns as $column) 
    {
      $column = new Column($column, 'normal');
      parent::$_build['select']->append($column);
    }
    
    return $this;
  }

  public function count($column)
  {
    $column = new Column($column, 'count');
    parent::$_build['select']->append($column);

    return $this;
  }

  public function countdistinct($column)
  {
    $column = new Column($column, 'countdistinct');
    parent::$_build['select']->append($column);

    return $this;
  }

  public function sum($column)
  {
    $column = new Column($column, 'countdistinct');
    parent::$_build['select']->append($column);

    return $this;
  }

  public function min($column)
  {
    $column = new Column($column, 'min');
    parent::$_build['select']->append($column);

    return $this;
  }

  public function max($column)
  {
    $column = new Column($column, 'max');
    parent::$_build['select']->append($column);

    return $this;
  }

  public function avg($column)
  {
    $column = new Column($column, 'avg');
    parent::$_build['select']->append($column);

    return $this;
  }
}