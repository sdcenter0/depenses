<?php

namespace App\Core\Databases;

class Query
{
  private \PDO $pdo;

  private Model|null $model;

  private array $bindings = [
    'select' => [],
    'from' => [],
    'join' => [],
    'where' => [],
    'order' => [],
  ];

  /**
   * The columns that should be returned.
   * 
   * @var array
   */
  private array $columns = [];

  /**
   * The where constraints for the query.
   * 
   * @var array
   */
  private array $wheres = [];

  /**
   * The joins that should be performed.
   * 
   * @var array
   */
  private array $joins = [];

  /**
   * The orderings for the query.
   * 
   * @var array
   */
  private array $orders = [];


  /**
   * The table which the query is targeting.
   * 
   * @var string
   */
  private string $from;

  /**
   * The maximum number of records to return.
   * 
   * @var int
   */
  private int $limit;

  /**
   * The number of records to skip.
   * 
   * @var int
   */
  private int $offset;

  /**
   * The groupings for the query.
   * 
   * @var array
   */
  private array $groupBy = [];

  public function __construct(Model $model = null)
  {
    $this->pdo = Connection::make();

    $this->model = $model;
  }

  /**
   * Set the columns to be selected.
   * 
   * @param array $columns
   * 
   * @return static
   */
  public function select(array $columns = ['*']): static
  {
    $this->columns = $columns;

    return $this;
  }

  /**
   * Set the table which the query is targeting.
   * 
   * @param string $table
   * 
   * @return static
   */
  public function from(string $table): static
  {
    $this->from = $table;

    return $this;
  }

  /**
   * Add a basic where clause to the query.
   * 
   * @param string $column
   * @param string $operator
   * @param mixed $value
   * 
   * @return static
   */
  public function where(string $column, string $operator, $value): static
  {
    $this->wheres[] = [
      'column' => $column,
      'operator' => $operator,
      'value' => $value
    ];

    $this->bindings['where'][] = $value;

    return $this;
  }

  /**
   * Add a basic where key clause to the query.
   * 
   * @param int $id
   * 
   * @return static
   */
  public function whereKey(int $id): static
  {
    return $this->where($this->model->getKeyName() ?? 'id', '=', $id);
  }

  /**
   * Add a "where not in" clause to the query.
   * 
   * @param string $column
   * @param array $values
   * 
   * @return static
   */
  public function whereNotIn(string $column, array $values): static
  {
    $this->wheres[] = [
      'column' => $column,
      'operator' => 'not in',
      'value' => $values
    ];

    $this->bindings['where'] = array_merge($this->bindings['where'], $values);

    return $this;
  }

  /**
   * Add a "where in" clause to the query.
   * 
   * @param string $column
   * @param array $values
   * 
   * @return static
   */
  public function whereIn(string $column, array $values): static
  {
    $this->wheres[] = [
      'column' => $column,
      'operator' => 'in',
      'value' => $values
    ];

    $this->bindings['where'] = array_merge($this->bindings['where'], $values);

    return $this;
  }

  /**
   * Add an "order by" clause to the query.
   * 
   * @param string $column
   * @param string $direction
   * 
   * @return static
   */
  public function orderBy(string $column, string $direction = 'asc'): static
  {
    $this->orders[] = [
      'column' => $column,
      'direction' => $direction
    ];

    return $this;
  }

  /**
   * Add a "group by" clause to the query.
   * 
   * @param array|string $columns
   * 
   * @return static
   */
  public function groupBy(array|string $columns): static
  {
    if (is_string($columns)) {
      $columns = func_get_args();
    }

    $this->groupBy = $columns;

    return $this;
  }

  /**
   * Add a join clause to the query.
   * 
   * @param string $table
   * @param string $first
   * @param string $operator
   * @param string $second
   * 
   * @return static
   */
  public function join(string $table, string $first, string $operator, string $second): static
  {
    $this->joins[] = [
      'table' => $table,
      'first' => $first,
      'operator' => $operator,
      'second' => $second
    ];

    return $this;
  }

  /**
   * Set the limit.
   * 
   * @param int $limit
   * 
   * @return static
   */
  public function limit(int $limit): static
  {
    $this->limit = $limit;

    return $this;
  }

  /**
   * Set the offset.
   * 
   * @param int $offset
   * 
   * @return static
   */
  public function offset(int $offset): static
  {
    $this->offset = $offset;

    return $this;
  }

  /**
   * Delete the records matching the query.
   * 
   * @return int
   */
  public function delete()
  {
    $sql = $this->toDeleteSql();

    $statement = $this->pdo->prepare($sql);

    $statement->execute($this->getBindings());

    return $statement->rowCount();
  }

  /**
   * Get the delete SQL statement.
   * 
   * @return string
   */
  private function toDeleteSql()
  {
    $sql = 'delete from ' . $this->getFrom();

    if (!empty($this->wheres)) {
      $sql .= ' where ' . $this->getWhere();
    }

    return $sql;
  }

  /**
   * Find the records matching the query.
   * 
   * @param array $columns
   * 
   * @return array<\App\Core\Databases\Model>
   */
  public function get(array $columns = ['*']): array
  {
    $this->columns = $columns;

    $sql = $this->toSql();

    $statement = $this->pdo->prepare($sql);

    $statement->execute($this->getBindings());

    $class = get_class($this->model ?? \stdClass::class);

    return $statement->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
  }

  /**
   * Find the first record matching the query.
   * 
   * @param array $columns
   * 
   * @return \App\Core\Databases\Model
   */
  public function first(array $columns = ['*']): object
  {
    $this->columns = $columns;

    $sql = $this->toSql();

    $statement = $this->pdo->prepare($sql);

    $statement->execute($this->getBindings());

    $class = get_class($this->model ?? \stdClass::class);

    $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);

    return $statement->fetch();
  }

  /**
   * Create a record in the database.
   * 
   * @param array $attributes
   * 
   * @return \App\Core\Databases\Model
   */
  public function create(array $attributes)
  {
    $table = $this->getFrom();

    $columns = array_keys($attributes);

    $columns = implode(',', $columns);

    $placeholders = array_fill(0, count($attributes), '?');

    $placeholders = implode(',', $placeholders);

    $values = array_values($attributes);

    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

    $statement = $this->pdo->prepare($sql);

    $statement->execute($values);

    $this->model->{$this->model->getKeyName()} = $this->pdo->lastInsertId();

    return $this->model;
  }

  /**
   * Update a record in the database.
   * 
   * @param array $attributes
   * 
   * @return \App\Core\Databases\Model
   */
  public function update(array $attributes)
  {
    $table = $this->getFrom();

    $columns = array_map(fn($column) => "$column = ?", array_keys($attributes));

    $columns = implode(',', $columns);

    $placeholders = array_fill(0, count($attributes), '?');

    $placeholders = implode(',', $placeholders);

    $values = array_values($attributes);

    $sql = "UPDATE $table SET $columns WHERE {$this->model->getKeyName()} = ?";

    $values[] = $this->model->{$this->model->getKeyName()};

    $statement = $this->pdo->prepare($sql);
    
    $statement->execute($values);
    
    $this->model->fill($attributes);

    return $this->model;
  }

  /**
   * Get the number of records matching the query.
   * 
   * @param array $columns
   * 
   * @return int
   */
  public function count(array $columns = ['*']): int
  {
    return (int) $this->aggregate('count', $columns);
  }

  /**
   * Get the maximum of the values of a given column.
   * 
   * @param string $function
   */
  public function max(string $column): mixed
  {
    return (int) $this->aggregate('max', [$column]);
  }

  /**
   * Get the minimum of the values of a given column.
   * 
   * @param string $column
   * 
   * @return mixed
   */
  public function min(string $column): mixed
  {
    return (int) $this->aggregate('min', [$column]);
  }

  /**
   * Get the average of the values of a given column.
   * 
   * @param string $column
   * 
   * @return mixed
   */
  public function avg(string $column): mixed
  {
    return (int) $this->aggregate('avg', [$column]);
  }

  /**
   * Get the sum of the values of a given column.
   * 
   * @param string $column
   */
  public function sum(string $column): mixed
  {
    return (int) $this->aggregate('sum', [$column]);
  }

  /**
   * Get the aggregate result of the query.
   * 
   * @param string $function
   * @param array $columns
   * 
   * @return mixed
   */
  public function aggregate(string $function, array $columns = ['*']): mixed
  {
    $sql = $this->toAggregateSql($function, $columns);

    $statement = $this->pdo->prepare($sql);

    $statement->execute($this->getBindings());

    return $statement->fetchColumn();
  }

  /**
   * Get the aggregate SQL statement.
   * 
   * @param string $function
   * @param array $columns
   * 
   * @return string
   */
  private function toAggregateSql(string $function, array $columns = ['*'])
  {
    $sql = 'select ' . $function . '(' . implode(',', $columns) . ') from ' . $this->getFrom();

    if (!empty($this->joins)) {
      foreach ($this->joins as $join) {
        $sql .= ' join ' . $join['table'] . ' on ' . $join['first'] . ' ' . $join['operator'] . ' ' . $join['second'];
      }
    }

    if (!empty($this->wheres)) {
      $sql .= ' where ' . $this->getWhere();
    }

    if (!empty($this->groupBy)) {
      $sql .= ' group by ' . implode(',', $this->groupBy);
    }

    if (!empty($this->orders)) {
      $sql .= ' order by ';

      foreach ($this->orders as $index => $order) {
        if ($index > 0) {
          $sql .= ', ';
        }

        $sql .= $order['column'] . ' ' . $order['direction'];
      }
    }

    if (!empty($this->limit)) {
      $sql .= ' limit ' . $this->limit;
    }

    if (!empty($this->offset)) {
      $sql .= ' offset ' . $this->offset;
    }

    return $sql;
  }

  /**
   * Build the "where" clause.
   * 
   * @return string
   */
  private function getWhere(): string
  {
    $sql = '';

    if (!empty($this->wheres)) {

      foreach ($this->wheres as $index => $where) {
        if ($index > 0) {
          $sql .= ' and ';
        }

        if (is_array($where['value'])) {
          $placeholders = '(' . implode(',', array_fill(0, count($where['value']), '?')) . ')';
        } else {
          $placeholders = '?';
        }

        $sql .= $where['column'] . ' ' . $where['operator'] . " $placeholders";
      }
    }

    return $sql;
  }

  /**
   * Get the SQL representation of the query.
   * 
   * @return string
   */
  private function toSql(): string
  {
    $sql = 'select ' . implode(',', $this->columns) . ' from ' . $this->getFrom();

    if (!empty($this->joins)) {
      foreach ($this->joins as $join) {
        $sql .= ' join ' . $join['table'] . ' on ' . $join['first'] . ' ' . $join['operator'] . ' ' . $join['second'];
      }
    }

    if (!empty($this->wheres)) {
      $sql .= ' where ';

      foreach ($this->wheres as $index => $where) {
        if ($index > 0) {
          $sql .= ' and ';
        }

        if (is_array($where['value'])) {
          $placeholders = '(' . implode(',', array_fill(0, count($where['value']), '?')) . ')';
        } else {
          $placeholders = '?';
        }

        $sql .= $where['column'] . ' ' . $where['operator'] . " $placeholders";
      }
    }

    if (!empty($this->orders)) {
      $sql .= ' order by ';

      foreach ($this->orders as $index => $order) {
        if ($index > 0) {
          $sql .= ', ';
        }

        $sql .= $order['column'] . ' ' . $order['direction'];
      }
    }

    if (!empty($this->limit)) {
      $sql .= ' limit ' . $this->limit;
    }

    if (!empty($this->offset)) {
      $sql .= ' offset ' . $this->offset;
    }

    return $sql;
  }

  /**
   * Get the bindings from the query.
   * 
   * @return array
   */
  public function getBindings(): array
  {
    $bindings = [];

    foreach ($this->bindings as $binding) {
      $bindings = array_merge($bindings, $binding);
    }

    return $bindings;
  }

  /**
   * Get the table name from the model.
   * 
   * @return string
   */
  public function getFrom(): string
  {
    return $this->from ?? $this->model->getTable() ?? '';
  }

  public function __toString()
  {
    return $this->toSql();
  }
}