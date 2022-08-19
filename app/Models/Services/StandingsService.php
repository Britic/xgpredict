<?php

namespace App\Models\Services;

use App\Models\RoundStatus;
use Illuminate\Support\Facades\DB;

class StandingsService
{

    public function getStandings()
    {
        $standings = $this->getStandingsData();
        $sortedData = [];

        $i = 0;
        $lastScore = -1;

        foreach ($standings as $k => $standing) {

            if ($standing->score != $lastScore) {
                $i++;
            }
                $lastScore = $standing->score;

                $rowData = new \stdClass();
                $rowData->rank = $i;
                $rowData->name = $standing->name;
                $rowData->score = $standing->score;

                $sortedData[] = $rowData;
        }
        return $sortedData;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getStandingsData()
    {
        return DB::table('users AS u')
            ->select([
                'u.name',
                DB::raw('(SELECT COUNT(*)
                    FROM
                        predictions p
                            LEFT JOIN
                        fixtures f ON p.fixture_id = f.id
                            LEFT JOIN
                        rounds r ON f.round_id = r.id
                    WHERE
                        r.round_status_id = 4
                    AND
                        (f.result_id = p.predicted_result_id)
                            AND
                        p.user_id = u.id
                            ) AS score')
            ])
            ->orderBy('score', 'DESC')
            ->get();
    }

}
