<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Condition
{
  /**
   * contains all the arguments of the condition
   * 
   * @var array
   */
  private $_arguments = array();

  /**
   * defines the condition type (function/operator)
   * 
   * @var string
   */
  private $_type;

  /**
   * defines the condition logicaloperator
   *
   * values are AND (by default) / OR
   * 
   * @var [type]
   */
  private $_logicaloperator;

  public function __construct($logicaloperator = 'AND')
  {
    $this->_logicaloperator  = $logicaloperator;
  } 

  /**
   * get the arguments
   * 
   * @return array
   */
  public function getArguments()
  {
    return $this->_arguments;
  }

  /**
   * get the type
   * 
   * @return string
   */
  public function getType()
  {
    return $this->_type;
  }

  /**
   * get the logicaloperator
   * 
   * @return string
   */
  public function getLogicalOperator()
  {
    return $this->_logicaloperator;
  }

  /**
   * Comparison with operators
   *
   * - = (Equals)
   * - != (Not equal to)
   * - <> (Not equal to)
   * - > (Great than)
   * - < (Less than)
   * - >= (Greater Than or Equal To)
   * - <= (Less Than or Equal To)
   * - !< (Not Less Than)
   * - !> (Not Greater Than)
   * 
   * @param  array $arguments
   * @return void
   */
  public function compare($arguments)
  {
    $this->_type = 'compare';

    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']   = $columnobject;
    $this->_arguments['operator'] = $arguments[1];
    $this->_arguments['right']    = $arguments[2];
  }

  /**
   * comparison to a list of values
   *
   * if the second argument is given true, then the list of values will be excluded
   *
   * @param  array $arguments
   * @param  boolean $not
   * @return void
   */
  public function comparelist($arguments, $not = false)
  {
    $this->_type = ! $not ? 'in' : 'notin';

    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']  = $columnobject;
    $this->_arguments['list']    = $arguments[1];
  }

  /**
   * range comparison
   * 
   * @param  array  $arguments
   * @param  boolean $not
   * @return void
   */
  public function range($arguments, $not = false)
  {
    $this->_type = ! $not ? 'between' : 'notbetween';

    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']  = $columnobject;
    $this->_arguments['min']     = $arguments[1];
    $this->_arguments['max']     = $arguments[2];
  }

  /**
   * pattern match comparison
   * 
   * @param  array $arguments
   * @param  boolean $not
   * @return void
   */ 
  public function contains($arguments, $not = false)
  {
    $this->_type = ! $not ? 'like' : 'notlike';

    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']   = $columnobject;
    $this->_arguments['contains'] = $arguments[1];
  }

  /**
   * null comparison
   * 
   * @param  array  $arguments
   * @param  boolean $not
   * @return void
   */
  public function isnull($arguments, $not = false)
  {
    $this->_type = ! $not ? 'isnull' : 'isnotnull';

    $columnobject = new Column();
    $columnobject->setName($arguments[0]);
    $columnobject->setType('normal');

    $this->_arguments['column']   = $columnobject;
  }
}