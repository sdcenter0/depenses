<?php

namespace App\Core\Exceptions;

use App\Core\Validations\ValidationException;

class ExceptionHandler
{
  public static function handle(\Throwable $e): mixed
  {
    if ($e instanceof ValidationException) {
      $_SESSION['errors'] = $e->getErrors();

      $_SESSION['old'] = $e->getData();

      header('Location: ' . $_SERVER['HTTP_REFERER']);
    } elseif ($e instanceof ActionNotFoundException || $e instanceof ControllerNotFoundException) {
      require_once BASE_PATH . '/resources/views/errors/404.php';
    } else {
      require_once BASE_PATH . '/resources/views/errors/500.php';
    }

    return null;
  }
}