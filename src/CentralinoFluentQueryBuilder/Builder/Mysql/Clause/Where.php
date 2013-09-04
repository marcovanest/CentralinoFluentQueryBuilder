<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\Clause;

use CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Mysql\Builder
{
  private $_left;
  private $_logicaloperator;
  private $_conditions;
  private $_whereposition;

  public function __construct($left, $logicaloperator = 'AND')
  { 
    $this->_type            = 'where';  
    $this->_left            = $left;  
    $this->_whereposition   = isset(parent::$_build[$this->_type]) ? count(parent::$_build[$this->_type]) : 0;
    $this->_logicaloperator = $logicaloperator; 
    $this->_conditions      = array();  

    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type] = array();
    }
    parent::$_build[$this->_type][] = $this;
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
   * Comparison with operators
   *
   * Logical operator: AND
   * 
   * @return Where
   */
  public function compare()
  {  
    $arguments = $this->prepareArguments($this->_left, func_get_args());

    $condition = new Mysql\Condition();
    $condition->compare($arguments);

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition('OR');
    $condition->compare($arguments);

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition();
    $condition->range($arguments);

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition('OR');
    $condition->range($arguments);

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition();
    $condition->comparelist($arguments);

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition('OR');
    $condition->comparelist($arguments);

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition();
    $condition->comparelist($arguments, 'NOT');

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition('OR');
    $condition->comparelist($arguments);

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition();
    $condition->contains($arguments);

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition('OR');
    $condition->contains($arguments);

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition();
    $condition->contains($arguments, 'NOT');

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition('OR');
    $condition->contains($arguments, 'NOT');

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition();
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition('OR');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition();
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

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

    $condition = new Mysql\Condition('OR');
    $condition->isnull($arguments, 'NOT');

    parent::addCondition($condition);

    return $this;      
  }

  public function exists()
  {

  }

}