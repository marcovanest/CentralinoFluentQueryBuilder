<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Condition
{
  public $arguments = array();

  public $type;

  public function __construct($type)
  {
    $this->type = $type;
  } 

  public  function compare($table, $arguments)
  {
    $this->arguments = $arguments;
  }

  public function range($table, $arguments)
  {
    $this->arguments = $arguments;
  }

  public function contains($table, $arguments)
  {
    $this->arguments = $arguments;
  }
}