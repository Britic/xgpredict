<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prediction extends Model
{
    use HasFactory;

    protected $with = [
        'fixture',
        'result'
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

    /**
     * @return HasOne
     */
    public function result()
    {
        return $this->hasOne(Result::class, 'id','predicted_result_id');
    }
}
