<?php

namespace App\Core\Exceptions;

class ActionNotFoundException extends \Exception
{
  public function __construct(string $action)
  {
    parent::__construct("Action $action not found");
  }
}