<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $abbr
 */
class League extends Model
{
    protected $table = 'leagues';
}
