<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\DMS;

use CentralinoFluentQueryBuilder\Builder\Mysql;

class Insert extends Mysql\Builder
{
  private $_columns;

  public function __construct($columns)
  {
    parent::$_build['insert'] = $this;

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
    foreach ($columns as $column => $value) 
    {
      $columnobject     = new Mysql\Column($column, 'normal', $table);
      $this->_columns[] = $columnobject;
    }
    
    return $this;
  }

}