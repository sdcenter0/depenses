<?php

namespace App\Core\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Delete extends HttpMethod
{
  public function getMethod(): string
  {
    return 'DELETE';
  }

  public function matches(string $method): bool
  {
    return parent::matches($method) || ($method === 'POST' && isset($_POST['_method']) && parent::matches($_POST['_method']));
  }
}