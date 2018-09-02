<?php

namespace App\Http\Controllers;

use App\Services\RankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    //
    public function index(Request $request, RankingService $rankingService)
    {
        $ranking = $rankingService->getHighscores(100);
        $me = $rankingService->me(Auth::user());

        return response()->make([
            'me' => $me,
            'ranking' => $ranking
        ], 200);
    }

    //
    public function insertOrUpdate(Request $request, RankingService $ranking)
    {
        //
        $rules = [
            'score' => 'required|integer'
        ];

        // validate
        $this->validate($request, $rules);

        $user = Auth::user();
        $ranking->insertOrUpdate($user->id, $request->score);

        return response()->make(null, 200);
    }
}
