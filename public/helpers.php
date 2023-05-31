<?php

/**
 * Get the value of a request variable
 * 
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function get($key, $default = null)
{
  if (isset($_GET[$key]) && !empty($_GET[$key])) {
    return $_GET[$key];
  }

  return $default;
}

/**
 * Generate a URL
 * 
 * @param string $path
 * 
 * @return string
 */
function url($path): string
{
  if (strpos($path, 'http') === false) {
    if (strpos($path, '/') !== 0) {
      $path = "/{$path}";
    }

    $path = BASE_URL . $path;
  }

  return $path;
}


/**
 * Get the current URL
 * 
 * @param string $path
 * 
 * @return string
 */
function current_url(): string
{
  return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}


/**
 * Check if the current URL is active
 * 
 * @param string $url
 * 
 * @return bool
 */
function is_active(string $url): bool
{
  $current = current_url();
  $url = url($url);

  if (strpos($url, '?') !== false) {
    $url = substr($url, 0, strpos($url, '?'));
  }

  if (strpos($current, '?') !== false) {
    $current = substr($current, 0, strpos($current, '?'));
  }

  return current_url() === url($url);
}

/**
 * Set a session variable with a key and value
 * 
 * @param string $key
 * @param mixed $value
 * 
 * @return void
 */
function session_set(string $key, $value): void
{
  $_SESSION[$key] = $value;
}

/**
 * Get a session variable with a key
 * 
 * @param string $key
 * @param mixed $default
 * 
 * @return mixed
 */
function session_get(string $key, $default = null)
{
  if (isset($_SESSION[$key])) {
    return $_SESSION[$key];
  }

  return $default;
}

/**
 * Check if a session variable exists
 * 
 * @param string $key
 * 
 * @return bool
 */
function session_has(string $key): bool
{
  return isset($_SESSION[$key]);
}

/**
 * Remove a session variable
 * 
 * @param string $key
 * 
 * @return void
 */
function session_remove(string $key): void
{
  unset($_SESSION[$key]);
}

/**
 * Get the value of a session variable and remove it
 * 
 * @param string $key
 * @param mixed $default
 * 
 * @return mixed
 */
function session_pop(string $key, $default = null)
{
  if (isset($_SESSION[$key])) {
    $value = $_SESSION[$key];

    unset($_SESSION[$key]);

    return $value;
  }

  return $default;
}