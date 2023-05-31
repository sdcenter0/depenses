<?php

namespace App\Models;

use App\Core\Databases\Model;

class Supplier extends Model
{
  public function getTable(): string
  {
    return 'suppliers';
  }
}