<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prediction extends Model
{
    use HasFactory;

    protected $with = [
        'fixture'
    ];

    protected $fillable = [
        'user_id',
        'fixture_id'
    ];

    /**
     * @return HasOne
     */
    public function fixture()
    {
        return $this->hasOne(Fixture::class, 'id','fixture_id');
    }
}
