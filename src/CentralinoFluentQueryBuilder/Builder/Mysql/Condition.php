<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Condition
{
  public $parameters = array();

  public $type;

  public function __construct($type)
  {
    $this->type = $type;
  } 

  public  function compare($parameters)
  {
    $this->parameters = $parameters;
  }

  public function range($parameters)
  {
    $this->parameters = $parameters;
  }

  public function contains($parameters)
  {
    $this->parameters = $parameters;
  }
}