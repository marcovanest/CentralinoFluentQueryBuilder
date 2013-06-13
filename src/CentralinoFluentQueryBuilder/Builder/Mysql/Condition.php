<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Condition
{
  public $parameters = array();

  public function __construct()
  {

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