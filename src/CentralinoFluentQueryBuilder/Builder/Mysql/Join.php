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
    $this->conditions       = new \ArrayObject();

    $this->_joinposition    = isset(parent::$_build[$this->_type][$this->table]) ? parent::$_build[$this->_type][$this->table]->count() : 0;
    
    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type][$this->table] = new \ArrayObject();
    }

    parent::$_build[$this->_type][$this->table]->append($this);
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

  public function alias($alias)
  {
    $this->alias = $alias;

    return $this;
  }
}