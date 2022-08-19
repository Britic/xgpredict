<?php

namespace App\Http\Controllers;

use App\Models\Services\StandingsService;
use Illuminate\Support\Facades\View;

class StandingsController extends Controller
{
    private $standingsHelper;

    public function __construct()
    {
        $this->standingsHelper = new StandingsService();
    }

    public function index()
    {
        $standings = $this->standingsHelper->getStandings();

        return View::make('standings/index', [
            'standings' => $standings
        ]);
    }

    public function predictions()
    {
        return View::make('predictions/index', [
        ]);
    }
}
