<?php

namespace App\Core\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Post extends HttpMethod
{
  public function getMethod(): string
  {
    return 'POST';
  }
}