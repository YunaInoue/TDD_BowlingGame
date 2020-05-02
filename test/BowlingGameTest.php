<?php

use myApp\BowlingGame;
use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{
    /**
     * @var BowlingGame
     */
    private $game;

    protected function setUp()
    {
        $this->game = new BowlingGame();
    }

    /**
     * @test
     */
    public function 全ての投球がガタ―()
    {
        $this->recordManyShots(20, 0);
        $this->assertEquals(0, $this->game->score);
    }

    /**
     * @test
     */
    public function 全ての投球で1ピンたけ倒した()
    {
        $this->recordManyShots(20, 1);
        $this->assertEquals(20, $this->game->score);
    }

    /**
     * @param int $count
     * @param int $pins
     */
    private function recordManyShots(int $count, int $pins): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $this->game->recordShot($pins);
        }
    }
}
