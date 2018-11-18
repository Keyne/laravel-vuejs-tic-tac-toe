<?php
/**
 * Created by PhpStorm.
 * User: Keyne
 * Date: 17/11/2018
 * Time: 22:19
 */

namespace App\Services;

use App\Components\WinnerCheckerInterface;
use App\Models\Match;
use Illuminate\Support\Collection;

class MatchesService implements MatchesServiceInterface
{
    /**
     * @var WinnerCheckerInterface
     */
    private $winnerChecker;

    /**
     * MatchesService constructor.
     *
     * @param WinnerCheckerInterface $winnerChecker
     */
    public function __construct(WinnerCheckerInterface $winnerChecker)
    {
        $this->winnerChecker = $winnerChecker;
    }

    /**
     * Lists matches
     *
     * @return \Illuminate\Support\Collection
     */
    public function listMatches(): Collection
    {
        return Match::all();
    }

    /**
     * Returns a given match by its id
     *
     * @param  int $id
     * @return Match
     */
    public function getMatch(int $id): Match
    {
        /**
         * @var Match $match
         */
        $match = Match::query()->findOrFail($id);
        return $match;
    }

    /**
     * Creates a match
     *
     * @return Match
     */
    public function create(): Match
    {
        $match = new Match();
        $match->save();
        return $match;
    }

    /**
     * Deletes a match
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        Match::destroy($id);
    }

    /**
     * Makes a move, saves it and checks the winner
     *
     * @param  int $match_id
     * @param  int $position
     * @param  int $player
     * @return Match
     */
    public function makeMove(int $match_id, int $position, int $player): Match
    {
        /**
         * @var Match $match
         */
        $match = Match::query()->find($match_id);
        $board = $match->getAttribute('board');

        $board[$position] = $player;
        $match->setAttribute('board', $board);
        $match->setAttribute('next', $match->getAttribute('next') === 1 ? 2 : 1);
        $match->save();

        $this->checkWinner($match, $player);

        return $match;
    }

    /**
     * Checks the match's winner and saves it (returns true for draw!)
     *
     * @param  Match  $match
     * @param  $player
     * @return bool
     */
    public function checkWinner(Match $match, int $player): bool
    {
        $board = $match->getAttribute('board');

        if($this->winnerChecker->check($board, $player)) {
            $match->setAttribute('winner', $player);
            $match->save();
            return true;
        }

        if ($match->isFinished()) {
            $match->setAttribute('winner', Match::MATCH_DRAW);
            $match->save();
            return true;
        }

        return false;
    }
}
