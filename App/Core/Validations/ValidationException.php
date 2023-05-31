<?php

namespace App\Core\Validations;

class ValidationException extends \Exception
{
  private array $errors;

  private array $data;

  public function __construct(array $errors, array $data)
  {
    $this->data = $data;
  
    $this->errors = $errors;
  }

  public function getErrors(): array
  {
    return $this->errors;
  }

  public function getData(): array
  {
    return $this->data;
  }
}