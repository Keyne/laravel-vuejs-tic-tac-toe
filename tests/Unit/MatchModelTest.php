<?php

namespace Tests\Unit;

use App\Models\Match;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests Match's model
     *
     * @return void
     */
    public function testModel()
    {
        $match = new Match();
        $match->save();
        $this->assertInstanceOf(Match::class, $match);
        $this->assertEquals($match->getAttribute('name'), 'Match ' . $match->getAttribute('id'));
        $this->assertEquals(Match::PLAYER_X, 1);
        $this->assertEquals(Match::PLAYER_O, 2);
    }
}
