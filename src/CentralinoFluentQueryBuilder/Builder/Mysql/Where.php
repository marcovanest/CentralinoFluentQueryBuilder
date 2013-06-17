<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Builder
{
  private $_left;
  private $_logicaloperator;
  public  $conditions = array();

  public function __construct($left, $logicaloperator = 'AND')
  { 
    $this->left             = $left;   
    $this->_type            = 'where';  
    $this->_logicaloperator = $logicaloperator;  

    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type] = $this;
    }
  }

  public function compare()
  {  
    $arguments = $this->prepareArguments($this->left, func_get_args());

    $condition = new Condition('compare');
    $condition->compare($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function between()
  {
    $arguments = $this->prepareArguments($this->left, func_get_args());

    $condition = new Condition('between');
    $condition->range($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function in()
  {
    $arguments = $this->prepareArguments($this->left, func_get_args());

    $condition = new Condition('in');
    $condition->comparelist($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function notin()
  {
    $arguments = $this->prepareArguments($this->left, func_get_args());

    $condition = new Condition('notin');
    $condition->comparelist($arguments, 'NOT');

    parent::addCondition($condition);

    return $this; 
  }

  public function like()
  {
    $arguments = $this->prepareArguments($this->left, func_get_args());

    $condition = new Condition('like');
    $condition->contains($arguments);

    parent::addCondition($condition);

    return $this; 
  }

  public function notlike()
  {
    $arguments = $this->prepareArguments($this->left, func_get_args());

    $condition = new Condition('notlike');
    $condition->contains($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;  
  }

  public function isnull()
  {
    $arguments = $this->prepareArguments($this->left, func_get_args());

    $condition = new Condition('isnull');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function isnotnull()
  {
    $arguments = $this->prepareArguments($this->left, func_get_args());

    $condition = new Condition('isnotnull');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function exists()
  {

  }

}