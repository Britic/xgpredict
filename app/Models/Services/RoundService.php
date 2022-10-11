<?php

namespace App\Models\Services;

use App\Models\Fixture;
use App\Models\Prediction;
use App\Models\Round;
use App\Models\RoundStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RoundService
{
    public $round;

    /**
     * @param Round $round
     */
    public function __construct(Round $round)
    {
        $this->round = $round;

        if(!$round->id) {
            $this->round == self::getActiveRound();
        }

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

    /**
     * @return Collection
     */
    public function getRoundFixtures(): Collection
    {
        return Fixture::where('round_id', $this->round->id)
            ->orderBy('fixture_date', 'ASC')
            ->get();
    }

    /**
     * @param User $user
     * @return array
     */
    public function getUserRoundPredictions(User $user): array
    {
        $roundFixtures = $this->getRoundFixtures();

        $predictions = [];

        foreach ($roundFixtures as $fixture) {
            $predictions[$fixture->id] = Prediction::where([
                'user_id' => $user->id,
                'fixture_id' => $fixture->id
            ])->firstOrCreate([
                'user_id' => $user->id,
                'fixture_id' => $fixture->id
            ]);
        }

        return $predictions;
    }

    /**
     * @param User $user
     * @return int
     */
    public function userRoundPredictionCount(User $user): int
    {
        // Return query result from predictions
        return DB::table('predictions AS p')
            // For this user
            ->where('p.user_id', $user->id)
            // Join on Fixtures
            ->leftJoin('fixtures AS f', 'p.fixture_id', '=', 'f.id')
            // For this round
            ->where('f.round_id', $this->round->id)
            // Where there is a prediction made
            ->whereNotNull('p.predicted_result_id')
            // Get the count
            ->count();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function userRoundSubmitted(User $user): bool
    {
        $numRoundFixtures = $this->getRoundFixtures()->count();
        $numUserRoundPredictions = $this->userRoundPredictionCount($user);

        return $numRoundFixtures === $numUserRoundPredictions;
    }

}
