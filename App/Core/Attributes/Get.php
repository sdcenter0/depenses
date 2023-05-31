<?php

namespace App\Core\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Get extends HttpMethod
{
  public function getMethod(): string
  {
    return 'GET';
  }
}