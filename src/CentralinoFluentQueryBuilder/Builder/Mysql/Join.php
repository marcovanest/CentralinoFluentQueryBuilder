<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

use CentralinoFluentQueryBuilder\Builder\General;
use CentralinoFluentQueryBuilder\Builder\Interfaces;

class Join extends Syntax implements Interfaces\Join
{
  private $_table;
  private $_conditions = array();
  private $_alias;
  private $_joinposition;
  private $_type;
  private $_nestedoperators = array();

  public function __construct($table, $type = 'inner')
  {
    $this->_type          = $type;  
    $this->_table         = $table;    
    $this->_joinposition  = isset(parent::$_build['join'][$this->_table]) ? count(parent::$_build['join'][$this->_table]) : 0;

    if(!isset(parent::$_build['join']))
    {
      parent::$_build['join'][$this->_table] = array();
    }

    parent::$_build['join'][$this->_table][] = $this;
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
   * return the nested operators
   * 
   * @return array
   */
  public function getNestedOperators()
  {
    return $this->_nestedoperators;
  }

  /**
   * return the type
   *
   * possible values
   *  - inner
   *  - left
   *  - right
   * 
   * @return [type]
   */
  public function getType()
  {
    return $this->_type;
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

    $condition = new General\Condition();
    $condition->compare($arguments);

    $this->_addCondition($condition);

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

    $condition = new General\Condition('OR');
    $condition->compare($arguments);

    $this->_addCondition($condition);

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

  /**
   * handles nested conditions if given
   * 
   * @param  function $function
   * @param  string $logicaloperator
   * @return Join
   */
  protected function _handleNestedConditions($function, $logicaloperator)
  {
    $this->_nested = true;

    if(is_callable($function))
    {
      $this->_conditionposition = count(self::$_build['join'][$this->_table][$this->_joinposition]->_conditions);
      $this->_nestedoperators[$this->_joinposition][$this->_conditionposition] = $logicaloperator; 

      call_user_func($function, $this);
    }

    $this->_nested = false;

    return $this;
  }

  /**
   * Add a condition to the join 
   * 
   * @param Condition $condition
   */
  private function _addCondition($condition)
  {
    if($this->_nested)
    {
      if(!isset(self::$_build['join'][$this->_table][$this->_joinposition]->_conditions[$this->_conditionposition]))
      {
        self::$_build['join'][$this->_table][$this->_joinposition]->_conditions[$this->_conditionposition] = array();
      }

      self::$_build['join'][$this->_table][$this->_joinposition]->_conditions[$this->_conditionposition][] = $condition;
    }
    else
    {
      self::$_build['join'][$this->_table][$this->_joinposition]->_conditions[] = $condition;   
    }
  }
}