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
}