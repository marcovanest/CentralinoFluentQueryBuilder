<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\Clause;

use CentralinoFluentQueryBuilder\Builder\General;
use CentralinoFluentQueryBuilder\Builder\Interfaces;
use CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Mysql\Syntax implements Interfaces\Where
{
  private $_left;
  private $_logicaloperator;
  private $_conditions = array();
  private $_whereposition;
  private $_nestedoperators = array();
  private $_nested = false;

  public function __construct($left, $logicaloperator = 'AND')
  { 
    $this->_type            = 'where';  
    $this->_left            = $left;  
    $this->_logicaloperator = $logicaloperator; 
  }

  /**
   * return the where position
   * 
   * @return int
   */
  public function getPosition()
  {
    return $this->_whereposition;
  }

  /**
   * return the where logical operator
   *
   * AND / OR
   * 
   * @return int
   */
  public function getLogicalOperator()
  {
    return $this->_logicaloperator;
  }

  /**
   * return the where conditions
   * 
   * @return array
   */
  public function getConditions()
  {
    return $this->_conditions;
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
   * Comparison with operators
   *
   * Logical operator: AND
   * 
   * @return Where
   */
  public function compare()
  {  
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition();
    $condition->compare($arguments);

    $this->_addCondition($condition);

    return $this;
  }

  /**
   * Comparison with operators
   *
   * Logical operator: OR
   * 
   * @return Where
   */
  public function or_compare()
  {  
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition('OR');
    $condition->compare($arguments);

    $this->_addCondition($condition);

    return $this;
  }

  /**
   * Range comparison
   *
   * Logical operator: AND
   *
   * @return Where
   */
  public function between()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition();
    $condition->range($arguments);

    $this->_addCondition($condition);

    return $this;
  }

  /**
   * Range comparison
   *
   * Logical operator: OR
   *
   * @return Where
   */
  public function or_between()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition('OR');
    $condition->range($arguments);

    $this->_addCondition($condition);

    return $this;
  }

  /**
   * Compare list of values
   *
   * AND IN(:param)
   *
   * Logical operator: AND
   *
   * @return Where
   */
  public function in()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition();
    $condition->comparelist($arguments);

    $this->_addCondition($condition);

    return $this;
  }

 /**
   * Compare list of values
   *
   * OR IN(:param)
   *
   * Logical operator: OR
   *
   * @return Where
   */
  public function or_in()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition('OR');
    $condition->comparelist($arguments);

    $this->_addCondition($condition);

    return $this;
  }

 /**
   * Compare not list of values
   *
   * AND NOT IN(:param)
   *
   * Logical operator: AND
   *
   * @return Where
   */
  public function notin()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition();
    $condition->comparelist($arguments, 'NOT');

    $this->_addCondition($condition);

    return $this; 
  }

 /**
   * Compare not list of values
   *
   * OR NOT IN(:param)
   *
   * Logical operator: OR
   *
   * @return Where
   */
  public function or_notin()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition('OR');
    $condition->comparelist($arguments);

    $this->_addCondition($condition);

    return $this;
  }

 /**
   * Contains comparison
   *
   * AND LIKE '%:param%'
   *
   * Logical operator: AND
   *
   * @return Where
   */
  public function like()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition();
    $condition->contains($arguments);

    $this->_addCondition($condition);

    return $this; 
  }

 /**
   * Contains comparison
   *
   * OR LIKE '%:param%'
   *
   * Logical operator: OR
   *
   * @return Where
   */
  public function or_like()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition('OR');
    $condition->contains($arguments);

    $this->_addCondition($condition);

    return $this; 
  }

 /**
   * Contains not comparison
   *
   * AND NOT LIKE '%:param%'
   *
   * Logical operator: AND
   *
   * @return Where
   */
  public function notlike()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition();
    $condition->contains($arguments, 'NOT');

    $this->_addCondition($condition);

    return $this;  
  }

 /**
   * Contains not comparison
   *
   * OR NOT LIKE '%:param%'
   *
   * Logical operator: OR
   *
   * @return Where
   */
  public function or_notlike()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition('OR');
    $condition->contains($arguments, 'NOT');

    $this->_addCondition($condition);

    return $this;  
  }

 /**
   * IS NULL comparison
   *
   * AND IS_NULL(':param')
   *
   * Logical operator: AND
   *
   * @return Where
   */
  public function isnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition();
    $condition->isnull($arguments, 'NOT');

    $this->_addCondition($condition);

    return $this;      
  }

 /**
   * IS NULL comparison
   *
   * OR IS_NULL(':param')
   *
   * Logical operator: OR
   *
   * @return Where
   */
  public function or_isnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition('OR');
    $condition->isnull($arguments, 'NOT');

    $this->_addCondition($condition);

    return $this;      
  }

 /**
   * IS NOT NULL comparison
   *
   * AND NOT IS_NULL(':param')
   *
   * Logical operator: AND
   *
   * @return Where
   */
  public function isnotnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition();
    $condition->isnull($arguments, 'NOT');

    $this->_addCondition($condition);

    return $this;      
  }

 /**
   * IS NOT NULL comparison
   *
   * OR NOT IS_NULL(':param')
   * 
   * Logical operator: OR
   *
   * @return Where
   */
  public function or_isnotnull()
  {
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new General\Condition('OR');
    $condition->isnull($arguments, 'NOT');

    $this->_addCondition($condition);

    return $this;      
  }

  public function exists()
  {

  }

  /**
   * handles nested conditions if given
   * 
   * @param  function $function
   * @param  string $logicaloperator
   * @return Where
   */
  protected function _handleNestedConditions($function, $logicaloperator)
  {
    $this->_nested = true;

    if(is_callable($function))
    {
      $this->_conditionposition = count($this->_conditions); 
      $this->_nestedoperators[$this->_conditionposition] = $logicaloperator; 

      call_user_func($function, $this);
    }

    $this->_nested = false;

    return $this;
  }

  /**
   * Add a condition to the where clause 
   * 
   * @param Condition $condition
   */
  private function _addCondition($condition)
  {
    if($this->_nested)
    {
      $this->_conditions[$this->_conditionposition][] = $condition;
    }
    else
    {
      $this->_conditions[] = $condition;
    }
  }
}