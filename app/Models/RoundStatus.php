<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoundStatus extends Model
{
    const PENDING = 1;
    const OPEN = 2;
    const LOCKED = 3;
    const COMPLETE = 4;
}
