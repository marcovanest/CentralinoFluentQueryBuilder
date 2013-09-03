<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Column
{
  private $_name;
  private $_type;
  private $_alias;
  private $_table;
  private $_value;

  public function __construct()
  {

  } 

  /**
   * return the column name
   * @return [type]
   */
  public function getName()
  {
    return $this->_name;
  }

  /**
   * set the column name
   * @param [type] $value
   */
  public function setName($value = null)
  {
    $columnnamepart = explode(' ', $value);
    $this->_name    = $columnnamepart[0];
  }

  /**
   * get the column type
   * @return [type]
   */
  public function getType()
  {
    return $this->_type;
  }

  /**
   * set the column type
   * @param [type] $value
   */
  public function setType($value = null)
  {
    $this->_type = $value;
  }

  /**
   * get the column value
   * @return [type]
   */
  public function getValue()
  {
    return $this->_value;
  }

  /**
   * set the column value
   * @param [type] $value
   */
  public function setValue($value = null)
  {
    $this->_value = $value;
  }

  /**
   * get the column alias
   * @return [type]
   */
  public function getAlias()
  {
    return $this->_alias;
  }

  /**
   * set the column alias
   * @param [type] $value
   */
  public function setAlias($value = null)
  {
    $columnnamepart = explode(' ', $value);
    $this->_alias   = isset($columnnamepart[2]) ? $columnnamepart[2] : null;   
  }

  /**
   * get the column value
   * @return [type]
   */
  public function getTable()
  {
    return $this->_table;
  }

  /**
   * set the column value
   * @param [type] $value
   */
  public function setTable($value = null)
  {
    $this->_table = $value;
  }

}