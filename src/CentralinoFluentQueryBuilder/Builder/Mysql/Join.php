<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Join extends Builder
{
  public $table;
  public $conditions = array();

  public function __construct($table, $logicaloperator = 'AND')
  {
    $this->table            = $table;   
    $this->_type            = 'join';   
    $this->_joinposition    = isset(parent::$_build[$this->_type]) && isset(parent::$_build[$this->_type][$this->table]) ? count(parent::$_build[$this->_type][$this->table]) : 0;
    $this->logicaloperator  = $logicaloperator;  

    parent::$_build[$this->_type][$this->table][] = $this;
  }

  public function on($firstcolumn, $operator = null, $secondcolumn = null, $type = 'AND')
  {
    $arguments  = func_get_args();

    $condition = new Condition('compare', $this->table);
    $condition->compare($arguments);

    parent::addCondition($condition);
     
  }
}