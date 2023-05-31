<?php

namespace App\Models;

use App\Core\Databases\Model;

class Depense extends Model
{
  public function getTable(): string
  {
    return 'depenses';
  }
}