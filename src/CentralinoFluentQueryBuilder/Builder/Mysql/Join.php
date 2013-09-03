<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Join extends Builder
{
  public $table;
  public $conditions;
  public $logicaloperator;
  public $alias;

  public function __construct($table, $logicaloperator = 'AND')
  {
    $this->_type            = 'join';  
    $this->table            = $table;    
    $this->logicaloperator  = $logicaloperator; 
    $this->conditions       = array();

    $this->_joinposition    = isset(parent::$_build[$this->_type][$this->table]) ? count(parent::$_build[$this->_type][$this->table]) : 0;
    
    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type][$this->table] = array();
    }

    parent::$_build[$this->_type][$this->table][] = $this;
  }

  public function on()
  {
    $arguments  = func_get_args();

    $condition = new Condition('compare');
    $condition->compare($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function or_on()
  {
    $arguments  = func_get_args();

    $condition = new Condition('compare', 'OR');
    $condition->compare($arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function alias($alias)
  {
    $this->alias = $alias;

    return $this;
  }
}