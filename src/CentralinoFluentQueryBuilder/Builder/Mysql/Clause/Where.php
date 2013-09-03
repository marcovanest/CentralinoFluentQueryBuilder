<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\Clause;

use CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Mysql\Builder
{
  private $_left;
  public  $logicaloperator;
  public  $conditions;

  public function __construct($left, $logicaloperator = 'AND')
  { 
    $this->_type            = 'where';  
    $this->_left            = $left;  
    $this->_whereposition   = isset(parent::$_build[$this->_type]) ? parent::$_build[$this->_type]->count() : 0;
    $this->logicaloperator  = $logicaloperator; 
    $this->conditions       = new \ArrayObject();  

    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type] = new \ArrayObject();
    }
    parent::$_build[$this->_type]->append($this);
  }

  public function compare()
  {  
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('compare');
    $condition->compare($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function or_compare()
  {  
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('compare', 'OR');
    $condition->compare($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function between()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('between');
    $condition->range($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function or_between()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('between', 'OR');
    $condition->range($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function in()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('in');
    $condition->comparelist($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function or_in()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('in', 'OR');
    $condition->comparelist($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function notin()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('notin');
    $condition->comparelist($arguments, 'NOT');

    parent::addCondition($condition);

    return $this; 
  }

  public function or_notin()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('notin', 'OR');
    $condition->comparelist($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function like()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('like');
    $condition->contains($arguments);

    parent::addCondition($condition);

    return $this; 
  }

  public function or_like()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('like', 'OR');
    $condition->contains($arguments);

    parent::addCondition($condition);

    return $this; 
  }

  public function notlike()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('notlike');
    $condition->contains($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;  
  }

  public function or_notlike()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('notlike', 'OR');
    $condition->contains($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;  
  }

  public function isnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('isnull');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function or_isnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('isnull', 'OR');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function isnotnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('isnotnull');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function or_isnotnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition('isnotnull', 'OR');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function exists()
  {

  }

}