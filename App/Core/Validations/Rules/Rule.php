<?php

namespace App\Core\Validations\Rules;

abstract class Rule
{
  /**
   * Determine if the validation rule passes
   * 
   * @param string $field
   * @param mixed $value
   * 
   * @return bool
   */
  public abstract function passes($field, $value): bool;

  /**
   * Get the validation error message
   * 
   * @return string
   */
  public abstract function message(): string;
}