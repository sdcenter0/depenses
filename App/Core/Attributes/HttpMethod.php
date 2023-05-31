<?php

namespace App\Core\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
abstract class HttpMethod
{
  public abstract function getMethod(): string;

  public function matches(string $method): bool
  {
    return $this->getMethod() === $method;
  }
}