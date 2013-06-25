<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Column
{
  public $name;
  public $type;

  public function __construct($name, $type)
  {
    $this->name  = $name;
    $this->type  = $type;
  } 
}