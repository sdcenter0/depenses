<?php

// Load environment variables

use App\Core\Exceptions\ExceptionHandler;
use App\Core\Routers\RouteParser;

session_start();

$env = file_get_contents(__DIR__ . '/../.env');

foreach (explode("\n", $env) as $line) {
  $line = trim($line);

  if (empty($line)) {
    continue;
  }

  putenv($line);

  // Set $_ENV
  [$key, $value] = explode('=', $line);

  $_ENV[$key] = $value;
}

define('BASE_URL', $_ENV['APP_URL']);
define('BASE_PATH', dirname(__DIR__));

try {
  $route = RouteParser::parse();

  $response = $route->call();

  // Check if response is a string
  if (is_string($response)) {
    echo $response;
    exit;
  }
} catch (\Throwable $e) {
  $r = ExceptionHandler::handle($e);

  if (is_string($r)) {
    echo $r;
    exit;
  }
}

function has_errors($key)
{
  return isset($_SESSION['errors'][$key]);
}

function flush_session($group, $key, $default = null)
{
  if (isset($_SESSION[$group][$key])) {
    $value = $_SESSION[$group][$key];

    unset($_SESSION[$group][$key]);

    return $value;
  }

  return $default;
}

function errors($key)
{
  return flush_session('errors', $key);
}

function old($key, $default = null)
{
  return flush_session('old', $key, $default);
}