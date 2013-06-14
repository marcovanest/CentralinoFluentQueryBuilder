<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Condition
{
  public $arguments = array();

  public $type;

  public $table;

  public function __construct($type)
  {
    $this->type = $type;
  } 

  public  function compare($table, $arguments)
  {
    $this->table = $table;
    $this->arguments = $arguments;
  }

  public function range($table, $arguments)
  {
    $this->table = $table;
    $this->arguments = $arguments;
  }

  public function contains($table, $arguments)
  {
    $this->table = $table;
    $this->arguments = $arguments;
  }
}