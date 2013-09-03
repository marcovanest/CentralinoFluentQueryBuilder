<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Condition
{
  private $_arguments = array();

  private $_type;

  private $_logicaloperator;

  public function __construct($type, $logicaloperator = 'AND')
  {
    $this->_type             = $type;
    $this->_logicaloperator  = $logicaloperator;
  } 

  /**
   * get the arguments
   * @return [type]
   */
  public function getArguments()
  {
    return $this->_arguments;
  }

  /**
   * get the type
   * @return [type]
   */
  public function getType()
  {
    return $this->_type;
  }

  /**
   * get the logicaloperator
   * @return [type]
   */
  public function getLogicalOperator()
  {
    return $this->_logicaloperator;
  }
  
  public function compare($arguments)
  {
    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']   = $columnobject;
    $this->_arguments['operator'] = $arguments[1];
    $this->_arguments['right']    = $arguments[2];
  }

  public function comparelist($arguments)
  {
    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']  = $columnobject;
    $this->_arguments['list']    = $arguments[1];
  }

  public function range($arguments)
  {
    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']  = $columnobject;
    $this->_arguments['min']     = $arguments[1];
    $this->_arguments['max']     = $arguments[2];
  }

  public function contains($arguments)
  {
    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']   = $columnobject;
    $this->_arguments['contains'] = $arguments[1];
  }

  public function isnull($arguments)
  {
    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']   = $columnobject;
  }
}