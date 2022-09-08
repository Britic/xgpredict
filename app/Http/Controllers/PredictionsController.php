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

        // We need the active round
        $activeRound = Round::where('round_status_id', RoundStatus::OPEN)
            ->orderBy('id', 'desc')
            ->first();

        // Load the service
        $rs = new RoundService($activeRound);

        return View::make('predictions/submit', [
            'round' => $activeRound,
            'fixtures' => $rs->getRoundFixtures(),
            'predictions' => $rs->getUserRoundPredictions($user->id)
        ]);
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
