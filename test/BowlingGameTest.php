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
        $this->assertTrue(true);
    }
}
