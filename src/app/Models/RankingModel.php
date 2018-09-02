<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class RankingModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rankings';

    /**
     * Timestamps to verify inclusions and updates.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
        'score',
        'user_id'
    ];

    /**
     * User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo( UserModel::class, 'user_id', 'id');
    }

    /**
     * Ranking ordered by score
     *
     * @param int $count
     * @return mixed
     */
    public static function getHighscores(int $count)
    {
        return DB::select("
            SELECT      rankings.score,
                        users.nickname
            FROM        rankings
            INNER JOIN  users
            ON          users.id = rankings.user_id
            ORDER BY    rankings.score DESC
            
            LIMIT       ?
        ", [$count]);
    }
}
