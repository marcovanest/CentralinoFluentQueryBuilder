<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Column
{
  public $name;
  public $type;
  public $table;

  public function __construct($name, $type, $table = null)
  {
    $this->name  = $name;
    $this->type  = $type;
    $this->table  = $table;
  } 
}