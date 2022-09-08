<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Services\RoundService;
use \View;
use Symfony\Component\HttpFoundation\Response;

class FixtureController extends Controller
{
    public function currentFixtures()
    {
        $activeRound = RoundService::getActiveRound();

        $fixtures = Fixture::where([
            'round_id' => $activeRound->id
        ])->get();

        return View::make('fixtures/index', [
            'fixtures' => $fixtures
        ]);

    }
}
