<?php

namespace App\Core\Routers;

use App\Controllers\Controller;

class Route
{
  private Controller $controller;

  private string $method;

  private array $params;

  public function __construct(Controller $controller, string $method, array $params)
  {
    $this->controller = $controller;

    $this->method = $method;

    $this->params = $params;
  }

  public function call()
  {
    return call_user_func_array([$this->controller, $this->method], $this->params);
  }
}