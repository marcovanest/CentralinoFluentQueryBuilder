<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Column
{
  private $_name;
  private $_type;
  private $_alias;
  private $_table;
  private $_value;
  private $_direction;

  public function __construct() { } 

  /**
   * return the column name
   * 
   * @return string
   */
  public function getName()
  {
    return $this->_name;
  }

  /**
   * set the column name
   * 
   * @param string $value
   */
  public function setName($value = null)
  {
    $columnnamepart = explode(' ', $value);
    $this->_name    = $columnnamepart[0];
  }

  /**
   * get the column type
   * 
   * @return string
   */
  public function getType()
  {
    return $this->_type;
  }

  /**
   * set the column type
   * 
   * @param string $value
   */
  public function setType($value = null)
  {
    $this->_type = $value;
  }

  /**
   * get the column value
   * 
   * @return string
   */
  public function getValue()
  {
    return $this->_value;
  }

  /**
   * set the column value
   * 
   * @param string $value
   */
  public function setValue($value = null)
  {
    $this->_value = $value;
  }

  /**
   * get the column alias
   * 
   * @return string
   */
  public function getAlias()
  {
    return $this->_alias;
  }

  /**
   * set the column alias
   * 
   * @param string $value
   */
  public function setAlias($value = null)
  {
    $columnnamepart = explode(' ', $value);
    $this->_alias   = isset($columnnamepart[2]) ? $columnnamepart[2] : null;   
  }

  /**
   * get the column value
   * 
   * @return string
   */
  public function getTable()
  {
    return $this->_table;
  }

  /**
   * set the column value
   * 
   * @param string $value
   */
  public function setTable($value = null)
  {
    $this->_table = $value;
  }

}