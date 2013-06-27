<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Column
{
  public $name;
  public $type;
  public $alias;
  public $table;

  public function __construct($column, $type, $table = null)
  {
    $columnnamepart = explode(' ', $column);

    $this->name   = $columnnamepart[0];
    $this->alias  = isset($columnnamepart[2]) ? $columnnamepart[2] : null;    
    $this->type   = $type;    
    $this->table  = $table;
  } 

  
}