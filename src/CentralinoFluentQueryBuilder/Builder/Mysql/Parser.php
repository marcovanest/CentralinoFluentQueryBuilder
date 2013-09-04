<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Parser extends Builder
{
  public function __construct()
  {
    
  }

  public function parse()
  {
    $sql = '';
    $sql .= $this->_parseDMS();
    $sql .= $this->_parseTarget();
    $sql .= $this->_parseJoins();
    $sql .= $this->_parseWheres();
    $sql .= $this->_parseLimit();
    $sql .= $this->_parseOrder();
    $sql .= $this->_parseGroup();

    return $sql;
  }

  private function _parseDMS()
  {
    $columns = '';
    if(isset(self::$_build['select']))
    {
      $selectcolumns  = self::$_build['select']->getColumns();
      $total          = count($selectcolumns);
      $columncounter  = 1;

      foreach ($selectcolumns as $column) 
      {
        $seperator = $total != $columncounter ? ', ' : '';
        $table     = ! empty($column->table) ? $column->table . '.' : '';
        $columncounter++;

        switch($column->getType())
        {
          case 'normal':
            $columns .= $table . $column->getName() . $seperator;
            break;

          case 'count':
            $columns .= 'COUNT(' . $table . $column->getName() . ') ' . $seperator;
            break;

          case 'avg':
            $columns .= 'AVG(' . $table . $column->getName() . ') ' . $seperator;
            break;

          case 'sum':
            $columns .= 'SUM(' . $table.$column->getName().') ' .$seperator;
            break;

          case 'min':
            $columns .= 'MIN(' . $table . $column->getName() . ') ' . $seperator;
            break;

          case 'max':
            $columns .= 'MAX(' . $table . $column->getName() . ') ' . $seperator;
            break;
        }      
      }

      return 'SELECT ' . $columns . ' ';
    }
  }

  private function _parseTarget()
  {
    if(isset(parent::$_build['target']))
    {
      $target = parent::$_build['target'];

      $table = $target->getTable();
      $alias = $target->getAlias();

      return 'FROM ' . $table . ( ! empty($alias) ? ' AS ' . $alias : '' ) . ' ';
    }
  }

  private function _parseJoins()
  {
    $sql = '';

    if(isset(self::$_build['join']))
    {
      $tables = array_keys(self::$_build['join']);

      foreach (self::$_build['join'] as $table => $joins) 
      {
        foreach ($joins as $joinposition => $join) 
        {
          $alias = $join->getAlias();
          $type  = strtoupper($join->getType());

          $sql .= $type . ' JOIN ' . $table . ( ! empty($alias) ? ' AS ' . $alias : '' ) . ' ON ';

          if($join instanceof Join)
          {
            $conditions = $join->getConditions();
            
            $sql .= $this->_parseConditions($conditions, $join->_nestedoperators[$joinposition]);
          }
        }
      }
    }

    return $sql;
  }

  private function _parseWheres()
  {
    if(isset(self::$_build['where']))
    {
      $sql = 'WHERE ';
      foreach (self::$_build['where'] as $whereposition => $where) 
      {
        if($whereposition !== 0)
        {
          $sql .= $where->getLogicalOperator() . ' ';
        }

        if($where instanceof Clause\Where)
        {
          $conditions = $where->getConditions();

          $sql .= $this->_parseConditions($conditions, $where->_nestedoperators[$whereposition]);          
        }
      }
      return $sql;
    } 
  }

  private function _parseLimit()
  {
    if(isset(self::$_build['limit']))
    {
      $limit = self::$_build['limit'];

      $offset = $limit->getOffset();
      $amountofrows = $limit->getAmountOfRows();

      $sql = 'LIMIT ' . $offset . ( ! empty($amountofrows) ? ',' . $amountofrows : '') . ' ';
      return $sql;
    }
  } 

  private function _parseOrder()
  {
    if(isset(self::$_build['order']))
    {
      $total         = count(self::$_build['order']);
      $columncounter = 1;

      $sql = 'ORDER BY ';
      foreach (self::$_build['order'] as $orderposition => $order) 
      {
        if($order instanceof Clause\Order)
        {
          $column     = $order->getColumn()->getName();
          $direction  = $order->getDirection();

          $sql .= $column . ' ' . $direction;
          $sql .= $columncounter!=$total ? ', ' : '';

          $columncounter++; 
        }
      }
      return $sql;
    }    
  }

  private function _parseGroup()
  {
    if(isset(self::$_build['group']))
    {
      $total         = count(self::$_build['group']);
      $columncounter = 1;

      $sql = 'GROUP BY ';

      foreach (self::$_build['group'] as $groupposition => $group) 
      {
        if($group instanceof Clause\Group)
        {
          $column = $group->getColumn()->getName();

          $sql .= $column;      
          $sql .= $columncounter!=$total ? ', ' : '';

          $columncounter++; 
        }
      }
      return $sql;
    }    
  }

  private function _parseConditions($conditions, $logicaloperators = null, &$sql = '', $nested = false)
  {
    foreach ($conditions as $conditionposition => $condition) 
    {
      if(is_array($condition))
      {
        $sql .= ($conditionposition != 0 ? $logicaloperators[$conditionposition] : '') . ' ( ';
        $this->_parseConditions($condition, null, $sql, true);
      }
      
      if($condition instanceof Condition)
      {
        $sql .= $this->_parseCondition($condition, $conditionposition);
      }
    }

    if($nested)
    {
      $sql .= $nested ? ') ' : '';
    }

    return $sql;
  }

  private function _parseCondition(Condition $condition, $conditionposition)
  {
    $sql = '';
    if($conditionposition !== 0)
    {
      $sql .= $condition->getLogicalOperator() . ' ';
    }

    $arguments = $condition->getArguments();
    $column    = $arguments['column'];

    switch ($condition->getType()) 
    {
      case 'compare':
        $operator = $arguments['operator'];
        $right    = $arguments['right'];

        $sql .= $column->getName() . ' ' . $operator . ' ' . $right . ' ';
        break;

     case 'between':
        $min = $arguments['min'];
        $max = $arguments['max'];

        $sql .= $column->getName() . ' BETWEEN ' . $min . ' AND ' . $max . ' ';
        break;

     case 'notbetween':
        $min = $arguments['min'];
        $max = $arguments['max'];

        $sql .= $column->getName() . ' NOT BETWEEN ' . $min . ' AND ' . $max . ' ';
        break;

     case 'in':
        $list = $arguments['list'];

        $sql .= $column->getName() . ' IN (' . implode(', ', $list) . ') '; 
        break;

      case 'notin':
        $list = $arguments['list'];

        $sql .= $column->getName() . ' NOT IN (' . implode(', ', $list) . ') '; 
        break;

      case 'isnull':
        $sql .= $column->getName() . ' IS NULL '; 
        break;

      case 'isnotnull':
        $sql .= $column->getName() . ' IS NOT NULL '; 
        break;
      
      case 'like':
        $contains = $arguments['contains'];

        $sql .= $column->getName() . ' LIKE ("%' . $contains . '%") '; 
        break;
      
      case 'notlike':
        $contains = $arguments['contains'];

        $sql .= $column->getName() . ' NOT LIKE ("%' . $contains . '%") '; 
        break;

      default:
        # code...
        break;
    }
    return $sql;
  }
}