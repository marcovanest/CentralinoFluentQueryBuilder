<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Condition
{
  public $arguments = array();

  public $type;

  public $logicaloperator;

  public function __construct($type, $logicaloperator = 'AND')
  {
    $this->type             = $type;
    $this->logicaloperator  = $logicaloperator;
  } 

  public function compare($arguments)
  {
    $this->arguments['column']   = new Column($arguments[0], 'normal');
    $this->arguments['operator'] = $arguments[1];
    $this->arguments['right']    = $arguments[2];
  }

  public function comparelist($arguments)
  {
    $this->arguments['column']  = new Column($arguments[0], 'normal');
    $this->arguments['list']    = $arguments[1];
  }

  public function range($arguments)
  {
    $this->arguments['column']  = new Column($arguments[0], 'normal');
    $this->arguments['min']     = $arguments[1];
    $this->arguments['max']     = $arguments[2];
  }

  public function contains($arguments)
  {
    $this->arguments['column']   = new Column($arguments[0], 'normal');
    $this->arguments['contains'] = $arguments[1];
  }

  public function isnull($arguments)
  {
    $this->arguments['column'] = new Column($arguments[0], 'normal');
  }
}