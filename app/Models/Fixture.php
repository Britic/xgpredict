<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property Team $team1
 * @property Team $team2
 *
 */
class Fixture extends Model
{
    protected $table = 'fixtures';

    protected $dates = [
        'fixture_date'
    ];

    protected $with = [
        'team1',
        'team2',
        'league'
    ];

    /**
     * @return HasOne
     */
    public function team1()
    {
        return $this->hasOne(Team::class, 'id','team_1');
    }

    /**
     * @return HasOne
     */
    public function team2()
    {
        return $this->hasOne(Team::class, 'id','team_2');
    }

    /**
     * @return BelongsTo
     */
    public function league()
    {
        return $this->belongsTo(League::class, 'league_id','id');
    }

}
