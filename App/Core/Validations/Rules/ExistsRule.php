<?php

namespace App\Core\Validations\Rules;

use App\Core\Databases\Query;

class ExistsRule extends Rule
{
  private string $table;

  private string|null $column;

  public function __construct(string $table, string $column = null)
  {
    $this->table = $table;
    $this->column = $column;
  }

  public function passes($field, $value): bool
  {
    $query = new Query();

    $query->from($this->table)
    ->where($this->column ?? $field, '=', $value);

    return $query->count() > 0;
  }

  public function message(): string
  {
    return 'The :attribute does not exist';
  }
}