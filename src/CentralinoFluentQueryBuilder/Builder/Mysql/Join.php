<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Join extends Builder
{
  private $_table;
  private $_conditions;
  private $_alias;
  private $_joinposition;

  public function __construct($table)
  {
    $this->_type          = 'join';  
    $this->_table         = $table;    
    $this->_conditions    = array();
    $this->_joinposition  = isset(parent::$_build[$this->_type][$this->_table]) ? count(parent::$_build[$this->_type][$this->_table]) : 0;

    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type][$this->_table] = array();
    }

    parent::$_build[$this->_type][$this->_table][] = $this;
  }

  /**
   * returns the table factor of the join expression
   * 
   * @return string
   */
  public function getTable()
  {
    return $this->_table;
  }

  /**
   * returns the join expression conditions
   * 
   * @return array
   */
  public function getConditions()
  {
    return $this->_conditions;
  }

  /**
   * return the tabel factor alias
   * 
   * @return string
   */
  public function getAlias()
  {
    return $this->_alias;
  }

  /**
   * return the join position
   * 
   * @return int
   */
  public function getPosition()
  {
    return $this->_joinposition;
  }

  /**
   * ON clause for conditions that specify how to join the given table
   *
   * Logicaloperator: AND
   *
   * parameters 
   * - left
   * - operator
   * - right
   * 
   * @return Join
   */
  public function on()
  {
    $arguments  = func_get_args();

    $condition = new Condition();
    $condition->compare($arguments);

    parent::addCondition($condition);

    return $this;
  }

  /**
   * ON clause for conditions that specify how to join the given table
   *
   * Logicaloperator: OR
   *
   * parameters 
   * - left
   * - operator
   * - right
   * 
   * @return Join
   */
  public function or_on()
  {
    $arguments  = func_get_args();

    $condition = new Condition('OR');
    $condition->compare($arguments);

    parent::addCondition($condition);

    return $this;
  }

  /**
   * Defines an alias for the given table factor
   * 
   * @param  string $alias
   * @return [Join
   */
  public function alias($alias)
  {
    $this->_alias = $alias;

    return $this;
  }
}