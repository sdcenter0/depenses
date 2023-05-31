<?php

namespace App\Core\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Put extends HttpMethod
{
  public function getMethod(): string
  {
    return 'PUT';
  }

  public function matches(string $method): bool
  {
    return parent::matches($method) || ($method === 'POST' && isset($_POST['_method']) && parent::matches($_POST['_method']));
  }
}