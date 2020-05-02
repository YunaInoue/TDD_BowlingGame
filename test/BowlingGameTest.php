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
        for ($i = 1; $i <= 20; $i++) {
            $this->game->recordShot(0);
        }
        $this->assertEquals(0, $this->game->score);
    }

    /**
     * @test
     */
    public function 全ての投球で1ピンたけ倒した()
    {
        for ($i = 1; $i <= 20; $i++) {
            $this->game->recordShot(1);
        }
        $this->assertEquals(20, $this->game->score);
    }
}
