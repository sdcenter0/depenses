<?php

namespace App\Core\Validations;

use App\Core\Validations\Rules\ExistsRule;
use App\Core\Validations\Rules\RequiredRule;
use App\Core\Validations\Rules\Rule;
use App\Core\Validations\Rules\UniqueRule;

class Validator
{
  /**
   * The rules to be applied to the data
   * 
   * @var array
   */
  private array $rules = [];

  /**
   * The data under validation
   * 
   * @var array
   */
  private array $data = [];

  /**
   * Make a new validator instance
   * 
   * @param array $data
   * @param array $rules
   * 
   * @return static
   */
  public static function make(array $data, array $rules)
  {
    $instance = new self();

    $mapped = [];

    foreach ($rules as $field => $rule) {
      if (is_string($rule)) {
        $rule = [$rule];
      }

      $mapped[$field] = [];

      foreach ($rule as $r) {
        $parts = explode(':', $r);

        if (method_exists($instance, $parts[0])) {
          $args = explode(',', $parts[1] ?? '');

          $mapped[$field][] = $instance->{$parts[0]}($args);
        } else {
          throw new \Exception('Rule ' . $parts[0] . ' does not exist');
        }
      }
    }

    $instance->rules = $mapped;

    $instance->data = $data;

    return $instance;
  }

  /**
   * Validate the data
   * 
   * @return array
   */
  public function validate(): array
  {
    $errors = [];

    /** @var Rule $rule */
    foreach ($this->rules as $field => $rules) {
      foreach ($rules as $rule) {
        if (!$rule->passes($field, $this->data[$field] ?? null)) {
          if (!isset($errors[$field])) {
            $errors[$field] = [];
          }

          $message = $rule->message();

          $errors[$field][] = $this->replaceAttribute($message, $field);
        }
      }
    }

    if (empty($errors)) {
      return [];
    }

    throw new ValidationException($errors, $this->data);
  }

  /**
   * Replace the :attribute placeholder in the message with the actual field name
   * 
   * @param string $message
   * @param string $field
   * 
   * @return string
   */
  private function replaceAttribute(string $message, string $field)
  {
    $field = str_replace('_', ' ', $field);

    return str_replace(':attribute', $field, $message);
  }

  public function required(): Rule
  {
    return new RequiredRule();
  }

  public function unique(array $args): Rule
  {
    return new UniqueRule(...$args);
  }

  public function exists(array $args): Rule
  {
    return new ExistsRule(...$args);
  }
}