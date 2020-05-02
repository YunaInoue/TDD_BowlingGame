<?php

use myApp\BowlingGame;
use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{
    /**
     * @test
     */
    public function 全ての投球がガタ―()
    {
        $game = new BowlingGame();
        for ($i = 1; $i <= 20; $i++) {
            $game->recordShot(0);
        }
        $this->assertEquals(0, $game->score);
    }

    /**
     * @test
     */
    public function 全ての投球で1ピンたけ倒した()
    {
        $game = new BowlingGame();
        for ($i = 1; $i <= 20; $i++) {
            $game->recordShot(1);
        }
        $this->assertEquals(20, $game->score);
    }
}
