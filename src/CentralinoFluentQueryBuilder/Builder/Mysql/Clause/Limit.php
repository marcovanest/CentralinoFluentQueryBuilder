<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql\Clause;

use CentralinoFluentQueryBuilder\Builder\Mysql;

class Limit extends Mysql\Syntax
{
  private $_offset;
  private $_amountofrows;

  public function __construct($offset, $amountofrows = null)
  {
    $this->_offset       = $offset;
    $this->_amountofrows = $amountofrows;
  }

  /**
   * return the offset
   * 
   * @return string
   */
  public function getOffset()
  {
    return $this->_offset;
  }

  /**
   * return the order direction
   * 
   * @return [type]
   */
  public function getAmountOfRows()
  {
    return $this->_amountofrows;
  }
}