<?php

namespace App\Core\Validations\Rules;

class RequiredRule extends Rule
{
  public function passes($field, $value): bool
  {
    if (is_array($value)) {
      return !empty($value);
    }

    if (is_string($value)) {
      return trim($value) !== '';
    }

    if (is_numeric($value)) {
      return true;
    }

    return $value !== null;
  }

  public function message(): string
  {
    return 'The :attribute field is required.';
  }
}