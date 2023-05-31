<?php

namespace App\Models;

use App\Core\Databases\Model;

class DepenseDetails extends Model
{
  public function getTable(): string
  {
    return 'depense_details';
  }
}