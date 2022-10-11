<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\Round;
use App\Models\RoundStatus;
use App\Models\Services\RoundService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class PredictionsController extends Controller
{
    private $roundService;

    public function __construct(RoundService $roundService)
    {
        $this->roundService = $roundService;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return View::make('predictions/index', [
        ]);
    }

    public function submit($userId = null)
    {
        $user = Auth::user();

        if ($userId) {
            $user = User::find($userId);
        }

        $userRoundSubmitted = $this->roundService->userRoundSubmitted($user);
        $roundFixtures = $this->roundService->getRoundFixtures();
        $userPredictions = $this->roundService->getUserRoundPredictions($user);

        if ($userRoundSubmitted) {
            return View::make('predictions/submitted', []);
        } else {

            return View::make('predictions/submit', [
                'round' => $this->roundService->round,
                'fixtures' => $roundFixtures,
                'predictions' => $userPredictions
            ]);
        }


    }

    public function postSubmit(Request $request){

        $userId = $request->get('user_id');

        foreach ($request->get('predictions') as $predictionId => $submittedPrediction) {
            $prediction = Prediction::find($predictionId);
            $prediction->predicted_result_id = $submittedPrediction;
            $prediction->save();
        }

        return back()->with('success', 'Predictions Saved');
    }
}
