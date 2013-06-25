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

  public function columns(array $columns, $table = null)
  {
    foreach ($columns as $column) 
    {
      $column = new Column($column, 'normal', $table);
      parent::$_build['select']->append($column);
    }
    
    return $this;
  }

  public function count($column, $table = null)
  {
    $column = new Column($column, 'count', $table);
    parent::$_build['select']->append($column);

    return $this;
  }

  public function countdistinct($column, $table = null)
  {
    $column = new Column($column, 'countdistinct', $table);
    parent::$_build['select']->append($column);

    return $this;
  }

  public function sum($column, $table = null)
  {
    $column = new Column($column, 'countdistinct', $table);
    parent::$_build['select']->append($column);

    return $this;
  }

  public function min($column, $table = null)
  {
    $column = new Column($column, 'min', $table);
    parent::$_build['select']->append($column);

    return $this;
  }

  public function max($column, $table = null)
  {
    $column = new Column($column, 'max');
    parent::$_build['select']->append($column);

    return $this;
  }

  public function avg($column, $table = null)
  {
    $column = new Column($column, 'avg', $table);
    parent::$_build['select']->append($column);

    return $this;
  }

  public function __call($function, $arguments)
  {
    $functionparts = explode('_', $function);

    $function = array_pop($functionparts);
    $table    = implode('_', $functionparts);

    if(method_exists($this, $function))
    {
      call_user_func(array($this, $function), $arguments[0], $table);
    }
  }
}