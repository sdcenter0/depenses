<?php

namespace App\Core\Databases;

class Connection
{
  private static self $instance;

  private \PDO $pdo;

  private function __construct()
  {
    $user = getenv('DB_USERNAME');
    $pass = getenv('DB_PASSWORD');
    $dbname = getenv('DB_DATABASE');
    $port = getenv('DB_PORT');
    $connection = getenv('DB_CONNECTION');
    $host = getenv('DB_HOST');

    $this->pdo = new \PDO("$connection:host=$host;dbname=$dbname;port=$port", $user, $pass);
  }

  public static function make(): \PDO
  {
    if (!isset(self::$instance)) {
      self::$instance = new self();
    }

    return self::$instance->pdo;
  }
}