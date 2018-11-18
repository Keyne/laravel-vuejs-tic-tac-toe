<?php

namespace Tests\Unit;

use App\Components\WinnerChecker;
use App\Models\Match;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WinnerCheckerComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests winners
     *
     * @return void
     */
    public function testWinner()
    {
        $this->winner(Match::PLAYER_X);
        $this->winner(Match::PLAYER_O);
    }

    /**
     * Tests a given winner
     *
     * @param  int $player
     * @return void
     */
    private function winner(int $player)
    {
        $winnerChecker = new WinnerChecker();
        $this->assertTrue($winnerChecker->check($this->getWinnerRow1($player), $player));
        $this->assertTrue($winnerChecker->check($this->getWinnerRow2($player), $player));
        $this->assertTrue($winnerChecker->check($this->getWinnerRow3($player), $player));
        $this->assertTrue($winnerChecker->check($this->getWinnerCol1($player), $player));
        $this->assertTrue($winnerChecker->check($this->getWinnerCol2($player), $player));
        $this->assertTrue($winnerChecker->check($this->getWinnerCol3($player), $player));
        $this->assertTrue($winnerChecker->check($this->getWinnerDiag1($player), $player));
        $this->assertTrue($winnerChecker->check($this->getWinnerDiag2($player), $player));
        $this->assertFalse($winnerChecker->check($this->getWinnerDraw($player), $player));
    }

    private function getWinnerRow1(int $p): array
    {
        $o = $p === 1 ? 2 : 1;
        return [
            $p, $p, $p,
            0,   0, $o,
            $o,  $o,  0
        ];
    }

    private function getWinnerRow2(int $p): array
    {
        $o = $p === 1 ? 2 : 1;
        return [
            0,   0, $o,
            $p, $p, $p,
            $o, $o,  0
        ];
    }

    private function getWinnerRow3(int $p): array
    {
        $o = $p === 1 ? 2 : 1;
        return [
            0,   0, $o,
            $o, $o,  0,
            $p, $p, $p,
        ];
    }

    private function getWinnerCol1(int $p): array
    {
        $o = $p === 1 ? 2 : 1;
        return [
            $p,  0, $o,
            $p, $o,  0,
            $p, $o,  0,
        ];
    }

    private function getWinnerCol2(int $p): array
    {
        $o = $p === 1 ? 2 : 1;
        return [
            $o, $p, $o,
             0, $p,  0,
             0, $p,  0,
        ];
    }

    private function getWinnerCol3(int $p): array
    {
        $o = $p === 1 ? 2 : 1;
        return [
            $o, $o, $p,
            0,  $o, $p,
            0,   0, $p,
        ];
    }

    private function getWinnerDiag1(int $p): array
    {
        $o = $p === 1 ? 2 : 1;
        return [
            $p, $o, $o,
            0,  $p, $o,
            0,   0, $p,
        ];
    }

    private function getWinnerDiag2(int $p): array
    {
        $o = $p === 1 ? 2 : 1;
        return [
             0, $o, $p,
             0, $p, $o,
            $p,  0, $o,
        ];
    }

    private function getWinnerDraw(int $p): array
    {
        $o = $p === 1 ? 2 : 1;
        return [
            $p, $o, $o,
            $o, $p, $p,
            $p, $o, $o,
        ];
    }
}
