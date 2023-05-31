<?php

// Autoload php classes from App/ directory
spl_autoload_register(function ($class) {
  $class = str_replace('\\', '/', $class);
  if (file_exists(dirname(__DIR__) . '/' . $class . '.php')) {
    require dirname(__DIR__) . '/' . $class . '.php';
  }
});