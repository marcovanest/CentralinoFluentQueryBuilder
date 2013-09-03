<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\Clause;

use CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Mysql\Builder
{
  private $_left;
  private $_logicaloperator;
  private $_conditions;

  public function __construct($left, $logicaloperator = 'AND')
  { 
    $this->_type            = 'where';  
    $this->_left            = $left;  
    $this->_whereposition   = isset(parent::$_build[$this->_type]) ? count(parent::$_build[$this->_type]) : 0;
    $this->logicaloperator  = $logicaloperator; 
    $this->conditions       = array();  

    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type] = array();
    }
    parent::$_build[$this->_type][] = $this;
  }

  public function compare()
  {  
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition();
    $condition->compare($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function or_compare()
  {  
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('OR');
    $condition->compare($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function between()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition();
    $condition->range($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function or_between()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('OR');
    $condition->range($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function in()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition();
    $condition->comparelist($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function or_in()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('OR');
    $condition->comparelist($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function notin()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition();
    $condition->comparelist($arguments, 'NOT');

    parent::addCondition($condition);

    return $this; 
  }

  public function or_notin()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('OR');
    $condition->comparelist($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function like()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition();
    $condition->contains($arguments);

    parent::addCondition($condition);

    return $this; 
  }

  public function or_like()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('OR');
    $condition->contains($arguments);

    parent::addCondition($condition);

    return $this; 
  }

  public function notlike()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition();
    $condition->contains($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;  
  }

  public function or_notlike()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('OR');
    $condition->contains($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;  
  }

  public function isnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition();
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function or_isnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('OR');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function isnotnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition();
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function or_isnotnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('OR');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function exists()
  {

  }

}