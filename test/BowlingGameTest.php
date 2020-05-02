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
     * @test
     */
    public function スペアをとると次の投球のピン数を加算()
    {
        $this->game->recordShot(3);
        $this->game->recordShot(7); // 10+4=14
        $this->game->recordShot(4);
        $this->recordManyShots(17, 0);
        $this->assertEquals(18, $this->game->score);
    }

    /**
     * @test
     */
    public function 直前の等級との合計が10ピンでもフレーム違いはスペアではない()
    {
        $this->game->recordShot(2);
        $this->game->recordShot(5);
        $this->game->recordShot(5); // 前の投球との合計は10だけどスペアではない
        $this->game->recordShot(1);
        $this->recordManyShots(16, 0);
        $this->assertEquals(13, $this->game->score);
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
