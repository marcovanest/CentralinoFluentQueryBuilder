<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Condition
{
  public $arguments = array();

  public $type;

  public function __construct($type)
  {
    $this->type  = $type;
  } 

  public function compare($arguments)
  {
    $this->arguments['left']     = $arguments[0];
    $this->arguments['operator'] = $arguments[1];
    $this->arguments['right']    = $arguments[2];
  }

  public function comparelist($arguments)
  {
    $this->arguments['left']  = $arguments[0];
    $this->arguments['list']  = $arguments[1];
  }

  public function range($arguments)
  {
    $this->arguments['left']    = $arguments[0];
    $this->arguments['min']     = $arguments[1];
    $this->arguments['max']     = $arguments[2];
  }

  public function contains($arguments)
  {
    $this->arguments['left']      = $arguments[0];
    $this->arguments['contains']  = $arguments[1];
  }

  public function isnull($arguments)
  {
    $this->arguments['left']      = $arguments[0];
  }
}