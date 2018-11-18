<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    //use RefreshDatabase;

    const URL_MATCHES = '/api/match',
          URL_MATCH = '/api/match/',
          URL_MATCH_LEAVE = '/api/match/all/leave',
          URL_MATCH_PLAYER_REGISTER = '/api/match/%s/player',
          URL_MATCH_PLAYER_CURRENT = '/api/match/%s/player/session',
          URL_MOVE = '/api/match/%s',
          URL_CREATE = '/api/match',
          URL_DELETE = '/api/match/%s';

    const JSON_PATTERN = '{"id":1,"name":"Match 1","winner":0}';


    public function get($uri, array $headers = [])
    {
        $uri = $this->prepareUrlForRequest('http://web' . $uri);
        return parent::get($uri, $headers);
    }

    public function post($uri, array $data = [], array $headers = [])
    {
        $uri = $this->prepareUrlForRequest('http://web' . $uri);
        return parent::post($uri, $data, $headers);
    }

    public function put($uri, array $data = [], array $headers = [])
    {
        $uri = $this->prepareUrlForRequest('http://web' . $uri);
        return parent::put($uri, $data, $headers);
    }

    public function delete($uri, array $data = [], array $headers = [])
    {
        $uri = $this->prepareUrlForRequest('http://web' . $uri);
        return parent::delete($uri, $data, $headers);
    }

    /**
     * Test index
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testList()
    {
        session()->start();
        session()->put('sessionId', '123');

        $matchJson = json_decode(self::JSON_PATTERN, true);

        $this
            ->get(self::URL_MATCHES, [])
            ->assertExactJson([]);

        $this
            ->post(self::URL_CREATE, [])
            ->assertJsonFragment($matchJson);
    }

    public function testJoinMatch()
    {
        $matchJson = json_decode(self::JSON_PATTERN, true);

        $result = $this
            ->get(self::URL_MATCHES, [])
            ->assertJsonFragment($matchJson)
            ->json();
        ;

        //dd($result);

        $match = array_pop($result);

        $this
            ->get(self::URL_MATCH . 1, [])
            ->assertJsonFragment($matchJson);
        ;

        $match = $this->get(self::URL_MATCH . $match['id'], [])->json();

        $this
            ->withSession(['sessionId' => '123'])
            ->put(sprintf(self::URL_MATCH_PLAYER_REGISTER, $match['id']), ["player" => $match['next']])
            ->assertJsonFragment($matchJson);
        ;
    }

    public function testSameSlot()
    {
        $result = $this
            ->get(self::URL_MATCHES, [])
            ->json();

        $match = array_pop($result);

        $this
            ->withSession(['sessionId' => "321"])
            ->put(sprintf(self::URL_MATCH_PLAYER_REGISTER, $match['id']), ["player" => $match['next']])
            ->assertStatus(500);
    }

    public function testSameSession()
    {
        $result = $this
            ->get(self::URL_MATCHES, [])
            ->json();

        $match = array_pop($result);

        $this
            ->withSession(['sessionId' => '123'])
            ->put(sprintf(self::URL_MATCH_PLAYER_REGISTER, $match['id']), ["player" => $match['next'] === 1 ? 2: 1])
            ->assertStatus(500);
    }

    public function testMove()
    {
        $matchJson = json_decode(self::JSON_PATTERN, true);

        $result = $this
            ->get(self::URL_MATCHES, [])
            ->json();

        $match = array_pop($result);

        $player = $this
            ->withSession(['player' => $match['next'], 'sessionId' => '123'])
            ->get(sprintf(self::URL_MATCH_PLAYER_CURRENT, $match['id']))
            ->assertJsonFragment(['player' => $match['next']])
            ->json();

        $this
            ->withSession(['player' => $match['next'], 'sessionId' => '111'])
            ->get(sprintf(self::URL_MATCH_PLAYER_CURRENT, $match['id']))
            ->assertStatus(500);

        $this
            ->withSession(['player' => $match['next'], 'sessionId' => '123'])
            ->put(sprintf(self::URL_MOVE, $match['id']), ["player" => $player['player'], "position" => 0])
            ->assertJsonFragment($matchJson);
        ;

        $this
            ->withSession(['player' => null, 'sessionId' => '123'])
            ->put(sprintf(self::URL_MOVE, $match['id']), ["player" => $player['player'], "position" => 0])
            ->assertStatus(500);
        ;
    }

    public function testLeaveMatch()
    {
        $this
            ->put(self::URL_MATCH_LEAVE, [])
            ->assertStatus(200);
    }

    public function testDeleteMatch()
    {
        $result = $this
            ->get(self::URL_MATCHES, [])
            ->json();

        $match = array_pop($result);

        $this
            ->delete(sprintf(self::URL_DELETE, $match['id']), [])
            ->assertStatus(200);

        $this
            ->get(self::URL_MATCHES, [])
            ->assertJsonMissing(['id' => $match['id']]);
    }
}
