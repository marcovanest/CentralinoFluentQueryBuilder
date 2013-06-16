<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Builder
{
  public $parameters = array();

  public $where_position;

  public $left;

  public function __construct($left)
  { 
    $this->left  = $left;   
    $this->_type = 'where';  

    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type] = array();
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

    $condition = new Condition('contains');
    $condition->contains($arguments);

    parent::addCondition($condition);

    return $this; 
  }

  public function exists()
  {

  }

}