<?php namespace Centralino\Core\DatabaseManager\Statement\Builder\Mysql;

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
}