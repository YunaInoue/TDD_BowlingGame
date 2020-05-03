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
        $this->assertEquals(14, $this->game->frameScore(1));
    }

    /**
     * @test
     */
    public function 直前の投球との合計が10ピンでもフレーム違いはスペアではない()
    {
        $this->game->recordShot(2);
        $this->game->recordShot(5);
        $this->game->recordShot(5); // 前の投球との合計は10だけどスペアではない
        $this->game->recordShot(1);
        $this->recordManyShots(16, 0);
        $this->assertEquals(13, $this->game->score);
    }

    /**
     * @test
     */
    public function ストライクを取ると次の2投分のピン数を加算()
    {
        $this->game->recordShot(10); // 10+3+3=16
        $this->game->recordShot(3);
        $this->game->recordShot(3);
        $this->game->recordShot(1);
        $this->recordManyShots(16, 0);
        $this->assertEquals(23, $this->game->score);
    }

    /**
     * @test
     */
    public function 連続ストライクすなわちダブル()
    {
        $this->game->recordShot(10); // 10+10+3=23
        $this->game->recordShot(10); // 10+3+1=14
        $this->game->recordShot(3);
        $this->game->recordShot(1);
        $this->recordManyShots(14, 0);
        $this->assertEquals(41, $this->game->score);
    }

    /**
     * @test
     */
    public function ３連続ストライクすなわちターキー()
    {
        $this->game->recordShot(10); // 10+10+10=30
        $this->game->recordShot(10); // 10+10+3=23
        $this->game->recordShot(10); // 10+3+1=14
        $this->game->recordShot(3);
        $this->game->recordShot(1);
        $this->recordManyShots(14, 0);
        $this->assertEquals(71, $this->game->score);
    }

    /**
     * @test
     */
    public function ストライク後のスペア()
    {
        $this->game->recordShot(10); // 10+5+5=20
        $this->game->recordShot(5);
        $this->game->recordShot(5); // 5+3=8
        $this->game->recordShot(3);
        $this->recordManyShots(15, 0);
        $this->assertEquals(36, $this->game->score);
    }

    /**
     * @test
     */
    public function ダブル後のスペア()
    {
        $this->game->recordShot(10); // 10+10+5=25
        $this->game->recordShot(10); // 10+5+5=20
        $this->game->recordShot(5);
        $this->game->recordShot(5); // 5+3=8
        $this->game->recordShot(3);
        $this->recordManyShots(13, 0);
        $this->assertEquals(61, $this->game->score);
    }

    /**
     * @test
     */
    public function 全ての投球がガターの場合の第1フレームの得点()
    {
        $this->recordManyShots(20, 0);
        $this->assertEquals(0, $this->game->frameScore(1));
    }

    /**
     * @test
     */
    public function 全ての投球が1ピンだと全フレーム2点()
    {
        $this->recordManyShots(20, 1);
        for ($frameNo = 1; $frameNo <= 10; $frameNo++) {
            $this->assertEquals(2, $this->game->frameScore($frameNo));
        }
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
