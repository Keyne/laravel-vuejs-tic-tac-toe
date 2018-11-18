<?php

namespace Tests\Unit;

use App\Components\WinnerChecker;
use App\Models\Match;
use App\Services\MatchesService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchesServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests deletion
     *
     * @return void
     */
    public function testDelete()
    {
        $service = new MatchesService(new WinnerChecker());

        $match = new Match();
        $match->save();
        $id = $match->getAttribute('id');
        $this->expectException(\Exception::class);
        $service->delete($id);
        $service->getMatch($id);
    }

    /**
     * Tests deletion
     *
     * @return void
     */
    public function testWinner()
    {
        $service = new MatchesService(new WinnerChecker());

        $match = new Match();
        $match->setAttribute(
            'board', [
            1, 1 ,1,
            2, 0, 2,
            0, 0, 0,
            ]
        );
        $match->save();
        $this->assertTrue($service->checkWinner($match, 1));
    }
}
