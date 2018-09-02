<?php

namespace App\Services;

use App\Models\RankingModel;
use App\Models\UserModel;

class RankingService
{
    //
    public function me(UserModel $user)
    {
        // get my score
        $ranking = RankingModel::where('user_id', $user->id)->first();

        // my position
        $rank = RankingModel::where('user_id', $user->id)->where('score', '>', $ranking->score)->count() + 1; 

        return (object)[
            'rank' => $rank,
            'nickname' => $user->nickname,
            'score' => $ranking->score
        ];
    }

    //
    public function getHighscores(int $limit)
    {
        $highscores =  RankingModel::getHighScores($limit);

        // FIXME: find a better way to do this
        foreach ($highscores as $i => $v) {
            $v->rank = $i+1;
        }

        return $highscores;
    }

    //
    public function insertOrUpdate(int $user_id, int $score):void
    {
        //
        $ranking = RankingModel::where('user_id', $user_id)->first();

        if ($ranking == null || $ranking->score < $score) {
            $ranking = RankingModel::firstOrNew([
                'user_id' => $user_id
            ]);
            $ranking->score = $score;
            $ranking->save();
        }
    }
}