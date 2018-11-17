<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    const PLAYER_X = 1;
    const PLAYER_O = 2;
    const MATCH_DRAW = 3;

    protected $table = 'matches';

    protected $appends = [
        'name',
    ];

    protected $casts = [
        'board' => 'array'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setAttribute('next', rand(self::PLAYER_X, self::PLAYER_O));
        $this->setAttribute(
            'board', [
            0, 0, 0,
            0, 0, 0,
            0, 0, 0,
            ]
        );
    }

    public function getNameAttribute()
    {
        return 'Match ' . $this->getAttribute('id');
    }

    public function isFinished()
    {
        foreach($this->getAttribute('board') as $position) {
            if ($position === 0) {
                return false;
            }
        }
        return true;
    }
}
