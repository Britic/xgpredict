<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\Round;
use App\Models\RoundStatus;
use App\Models\Services\RoundService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PredictionsController extends Controller
{
    private RoundService $roundService;

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
            'round' => $this->roundService->round,
            'predictionsData' => $this->roundService->getRoundPredictionsData()
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

        if (true === $userRoundSubmitted) {
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

        Session::put('status', 'Predictions Saved');

        return Redirect::route('submit_predictions');
    }
}
