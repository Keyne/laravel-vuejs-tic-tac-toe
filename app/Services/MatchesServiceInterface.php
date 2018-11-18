<?php
/**
 * Created by PhpStorm.
 * User: Keyne
 * Date: 17/11/2018
 * Time: 21:44
 */

namespace App\Services;

use App\Models\Match;
use Illuminate\Support\Collection;

interface MatchesServiceInterface
{
    /**
     * Lists matches
     *
     * @return \Illuminate\Support\Collection
     */
    public function listMatches(): Collection;

    /**
     * Returns a given match by its id
     *
     * @param  int $id
     * @return Match
     */
    public function getMatch(int $id): Match;

    /**
     * Creates a match
     *
     * @return Match
     */
    public function create(): Match;

    /**
     * Deletes a match
     *
     * @param int $id
     */
    public function delete(int $id): void;


    /**
     * Makes a move, saves it and checks the winner
     *
     * @param  int $match_id
     * @param  int $position
     * @param  int $player
     * @return Match
     */
    public function makeMove(int $match_id, int $position, int $player): Match;

    /**
     * Checks match's winner and saves it
     *
     * @param  Match  $match
     * @param  $player
     * @return bool
     */
    public function checkWinner(Match $match, int $player): bool;
}
