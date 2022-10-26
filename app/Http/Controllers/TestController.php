<?php

namespace App\Http\Controllers;

use App\Models\Services\RoundService;
use App\Models\User;
use App\Notifications\PredictionConfirmation;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;

class TestController extends Controller
{
    public function testEmail()
    {
        $user = User::find(1);
        $round = RoundService::getActiveRound();
        $user->notify(new PredictionConfirmation($round, $user));

    }
}
