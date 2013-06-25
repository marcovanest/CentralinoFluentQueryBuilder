<?php namespace CentralinoFluentQueryBuilder; use PDO;

use CentralinoFluentQueryBuilder\Builder;

class Connection
{
  private $_pdo;

  public function __construct(PDO $pdo)
  {
    $this->_pdo = $pdo;
  }

  public function fluentQuery()
  {
    return new Builder\General($this);
  }

  public function getDriverName()
  {
    return $this->_pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
  }

  public function prepare($sSql)
  {
    try
    {
      return new Statement($this->_pdo->prepare($sSql));
    }
    catch (\PDOException $e)
    {
      throw new \Exception("Error Processing Request". $e->getMessage(), 1);
    }
  }
}