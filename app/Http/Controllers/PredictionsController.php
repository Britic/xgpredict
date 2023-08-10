<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\Round;
use App\Models\RoundStatus;
use App\Models\Services\RoundService;
use App\Models\User;
use App\Notifications\PredictionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
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
     */
    public function index()
    {
        
        if (Auth::user()->id !== 1) {
            return Response::make('Not found', 404);
        }

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
            // Show the submitted view
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
        $user = Auth::user();

        foreach ($request->get('predictions') as $predictionId => $submittedPrediction) {
            $prediction = Prediction::find($predictionId);
            $prediction->predicted_result_id = $submittedPrediction;
            $prediction->save();
        }

        if ($this->roundService->userRoundSubmitted($user)) {
            $user->notify(new PredictionConfirmation($this->roundService->round));
        }

        Session::put('status', 'Predictions Saved');

        return Redirect::route('submit_predictions');
    }
}
