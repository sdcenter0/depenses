<?php

namespace App\Core\Databases;

use ArrayAccess;

abstract class Model implements ArrayAccess
{
  protected array $attributes = [];

  protected string $primaryKey = 'id';

  public function __construct(array $attributes = [])
  {
    $this->fill($attributes);
  }

  public function __get(string $name)
  {
    return $this->attributes[$name] ?? null;
  }

  public function __set(string $name, $value)
  {
    $this->attributes[$name] = $value;
  }

  public function __isset(string $name)
  {
    return isset($this->attributes[$name]);
  }

  public function __unset(string $name)
  {
    unset($this->attributes[$name]);
  }

  /**
   * Create a new model instance
   * 
   * @param array $attributes
   * 
   * @return static
   */
  public static function create($attributes)
  {
    return static::query()->create($attributes);
  }

  /**
   * Save the model to the database
   * 
   * @return bool
   */
  public function update(array $attributes = []): static
  {
    return $this->newModelQuery()->update($attributes);
  }

  /**
   * Get a new query builder for the model's table.
   * 
   * @return Query
   */
  public function newModelQuery(): Query
  {
    return new Query($this);
  }

  /**
   * Get all records from the table
   * 
   * @param array $columns
   * 
   * @return array
   */
  public static function all(array $columns = ['*']): array
  {
    return static::query()->get($columns);
  }

  /**
   * Get the table name
   * 
   * @return string
   */
  public abstract function getTable(): string;

  /**
   * Get the primary key name
   * 
   * @return string
   */
  public function getKeyName()
  {
    return $this->primaryKey;
  }

  /**
   * Create a new query builder for the model
   * 
   * @return Query
   */
  public static function query()
  {
    return (new static())->newModelQuery();
  }

  /**
   * Find a record by the primary key
   * 
   * @param int $id
   * 
   * @return static
   */
  public static function find(int $id): static
  {
    return static::query()
      ->whereKey($id)
      ->first();
  }

  /**
   * Delete the model from the database
   * 
   * @return bool
   */
  public function delete(): bool
  {
    return static::query()->whereKey($this->id)->delete() > 0;
  }

  /**
   * Fill the model with an array of attributes
   * 
   * @param array $attributes
   * 
   * @return static
   */
  public function fill(array $attributes): static
  {
    $this->attributes = $attributes;

    return $this;
  }

  function offsetExists($offset): bool
  {
    return isset($this->attributes[$offset]);
  }

  function offsetGet($offset)
  {
    return $this->attributes[$offset] ?? null;
  }

  function offsetSet($offset, $value): void
  {
    $this->attributes[$offset] = $value;
  }

  function offsetUnset($offset): void
  {
    unset($this->attributes[$offset]);
  }

  public function __toString()
  {
    return json_encode($this->attributes);
  }
}