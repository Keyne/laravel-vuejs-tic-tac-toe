<?php
/**
 * Created by PhpStorm.
 * User: Keyne
 * Date: 17/11/2018
 * Time: 21:53
 */

namespace App\Components;


interface WinnerCheckerInterface
{
    /**
     * Checks if a player won the match
     *
     * @param  array $board
     * @param  int   $player
     * @return bool
     */
    public function check(array $board, int $player): bool;
}
