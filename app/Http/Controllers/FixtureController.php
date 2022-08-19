<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use \View;
use Symfony\Component\HttpFoundation\Response;

class FixtureController extends Controller
{
    public function currentFixtures()
    {

        $fixtures = Fixture::where([
            'round_id' => 1
        ])->get();

        return View::make('fixtures/index', [
            'fixtures' => $fixtures
        ]);

    }
}
