<?php

namespace App\Models\Services;

use App\Models\Fixture;
use App\Models\Prediction;
use App\Models\Round;
use App\Models\RoundStatus;

class RoundService
{
    public $round;

    /**
     * @param Round $round
     */
    public function __construct(Round $round)
    {
        $this->round = $round;
    }

    /**
     * @return Round
     */
    public static function getActiveRound(): Round
    {
        return Round::where('round_status_id', RoundStatus::OPEN)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getRoundFixtures()
    {
        return Fixture::where('round_id', $this->round->id)
            ->orderBy('fixture_date', 'ASC')
            ->get();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getUserRoundPredictions(int $userId): array
    {
        $roundFixtures = $this->getRoundFixtures();

        $predictions = [];

        foreach ($roundFixtures as $fixture) {
            $predictions[$fixture->id] = Prediction::where([
                'user_id' => $userId,
                'fixture_id' => $fixture->id
            ])->firstOrCreate([
                'user_id' => $userId,
                'fixture_id' => $fixture->id
            ]);
        }

        return $predictions;
    }

}
