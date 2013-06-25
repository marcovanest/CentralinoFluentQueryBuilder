<?php namespace CentralinoFluentQueryBuilder; use PDO; use PDOStatement;

/**
 * Responsible for handling prepared statements
 */
class Statement
{
  private $_statement;
  private $_timer;

  public function __construct(PDOStatement $statement)
  {
    $this->_statement = $statement;
  }

  /**
   * Startup a timer
   * @return float
   */
  private function _startTimer()
  {
    $this->_timer = microtime(true);
  }

  /**
   * End a timer
   * @return float
   */
  private function _stopTimer()
  {
    $this->_timer = number_format(microtime(true) - $this->_timer,3);
  }

   /**
   * Executes a prepared statement without a transaction
   * @return this on succes, throws a exception on failure
   */
  public function execute($aParams = array())
  {
    try
    {
      $this->_statement->execute($aParams);
    }
    catch(\PDOException $e)
    {
      throw new \Exception("Error Processing Request", 1);
    }

    return $this;
  }

  /**
   * Fetches the next row from a result set
   * @param  constant $fetchstyle [controls how the next row will be returned to the caller]
   * @return mixed
   */
  public function fetch($fetchstyle = PDO::FETCH_OBJ)
  {
    return $this->_statement->fetch($fetchstyle);
  }

  /**
   * Returns all the result set rows
   * @param  constant $fetchstyle
   * @return array
   */
  public function fetchAll($fetchstyle = PDO::FETCH_OBJ)
  {
    return $this->_statement->fetchAll($fetchstyle);
  }

  /**
   * Returns a single column from the next row of a result set
   * @return mixed
   */
  public function fetchColumn()
  {
    return $this->_statement->fetchColumn();
  }

  /**
   * Fetches the next row and returns it as an object.
   * @return object
   */
  public function fetchObject()
  {
    return $this->_statement->fetchObject();
  }

  /**
   * Returns the number of rows affected by the last statement
   * @return int
   */
  public function rowCount()
  {
    return $this->_statement->rowCount();
  }
}