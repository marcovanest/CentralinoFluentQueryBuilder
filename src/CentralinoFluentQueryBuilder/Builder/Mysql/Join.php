<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Join extends Builder
{
  public $table;
  public $conditions = array();

  public function __construct($table, $logicaloperator = 'AND')
  {
    $this->_type            = 'join';  
    $this->table            = $table;    
    $this->_joinposition    = isset(parent::$_build[$this->_type]) && isset(parent::$_build[$this->_type][$this->table]) ? count(parent::$_build[$this->_type][$this->table]) : 0;
    $this->logicaloperator  = $logicaloperator;  

    parent::$_build[$this->_type][$this->table][] = $this;
  }

  public function on()
  {
    $arguments  = func_get_args();

    $condition = new Condition('compare');
    $condition->compare($arguments);

    parent::addCondition($condition);
  }

  public function or_on()
  {
    $arguments  = func_get_args();

    $condition = new Condition('compare', 'OR');
    $condition->compare($arguments);

    parent::addCondition($condition);
  }
}