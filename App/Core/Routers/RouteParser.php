<?php

namespace App\Core\Routers;

use App\Attributes\HttpMethod;
use App\Attributes\Post;
use App\Controllers\Controller;
use App\Core\Exceptions\ActionNotFoundException;
use App\Core\Exceptions\ControllerNotFoundException;

class RouteParser
{

  /**
   * Get the value of a key from the request
   * 
   * @param string $key
   * @param mixed $default
   * 
   * @return string|array|null
   */
  private static function get(string $key, $default = null): string|array|null
  {
    if (isset($_GET[$key]) && !empty($_GET[$key])) {
      return $_GET[$key];
    }

    return $default;
  }

  /**
   * Parse the route from the request
   * 
   * @return Route
   */
  public static function parse(): Route
  {
    $controller = static::get('controller', Controller::HOME_CONTROLLER_NAME);

    $action = static::get('action', 'index');

    $params = static::get('params', []);

    static::ensureControllerExists($controller);

    $controllerClassName = static::qualifyControllerName($controller);

    $controllerObject = new $controllerClassName();

    static::ensureActionValid($controllerObject, $action);

    return new Route($controllerObject, $action, [$params]);
  }

  /**
   * Qualify the controller name
   * 
   * @param string $name
   * 
   * @return string
   */
  private static function qualifyControllerName(string $name): string
  {
    $name = str_replace('-', ' ', $name);

    $name = ucwords($name);

    $name = str_replace(' ', '', $name);

    $name = "{$name}Controller";

    return "App\\Controllers\\{$name}";
  }

  /**
   * Ensure the controller exists
   * 
   * @param string $name
   * 
   * @return void
   */
  private static function ensureControllerExists(string $name): void
  {
    $qualifiedControllerName = static::qualifyControllerName($name);

    if (!class_exists($qualifiedControllerName)) {
      throw new ControllerNotFoundException($name);
    }
  }

  /**
   * Ensure the action is valid
   * 
   * @param Controller $controller
   * @param string $action
   * 
   * @return void
   */
  private static function ensureActionValid(Controller $controller, string $action)
  {
    static::ensureActionExists($controller, $action);

    // Check if the action's http method matches the request method
    if (!static::actionMethodMatchesRequest($controller, $action)) {
      throw new ActionNotFoundException($action);
    }
  }

  /**
   * Ensure the action exists
   * 
   * @param Controller $controller
   * @param string $action
   * 
   * @return void
   */
  private static function ensureActionExists(Controller $controller, string $action)
  {
    if (!method_exists($controller, $action)) {
      throw new ActionNotFoundException($action);
    }
  }

  /**
   * Check if the action's http method matches the request method
   * 
   * @param Controller $controller
   * @param string $action
   * 
   * @return bool
   */
  private static function actionMethodMatchesRequest(Controller $controller, string $action): bool
  {
    $actionMethod = new \ReflectionMethod($controller, $action);

    $actionAttributes = $actionMethod->getAttributes();

    foreach ($actionAttributes as $attribute) {
      $instance = $attribute->newInstance();

      if ($instance instanceof HttpMethod) {
        return $instance->matches($_SERVER['REQUEST_METHOD']);
      }
    }

    return true;
  }
}