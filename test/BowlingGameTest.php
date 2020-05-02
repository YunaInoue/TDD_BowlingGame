<?php

use myApp\BowlingGame;
use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{
    /**
     * @test
     */
    public function 全投球ガタ―の場合のテスト()
    {
        $game = new BowlingGame();
        for ($i = 1; $i <= 20; $i++) {
            $game->recordShot(0);
        }
        $this->assertEquals(0, $game->score);
    }
}
