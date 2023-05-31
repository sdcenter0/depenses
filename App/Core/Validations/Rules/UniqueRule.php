<?php

namespace App\Core\Validations\Rules;

use App\Core\Databases\Query;

class UniqueRule extends Rule
{
  private string $table;

  private string|null $column;

  private array $except = [];

  public function __construct(string $table, string $column = null, ...$rest)
  {
    $this->table = $table;
    $this->column = $column;

    if (count($rest) > 0) {
      $this->except['value'] = $rest[0];
      $this->except['key'] = $rest[1];
    }
  }

  public function except(array $except): static
  {
    $this->except = $except;

    return $this;
  }

  public function passes($field, $value): bool
  {
    $query = new Query();

    $query->from($this->table)
      ->where($this->column ?? $field, '=', $value);

    if (!empty($this->except)) {

      $query->whereNotIn($this->except['key'], [$this->except['value']]);
    }

    return $query->count() === 0;
  }

  public function message(): string
  {
    return 'The :attribute has already been taken.';
  }
}