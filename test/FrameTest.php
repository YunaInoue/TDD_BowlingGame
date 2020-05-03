<?php


use myApp\Frame;
use PHPUnit\Framework\TestCase;

class FrameTest extends TestCase
{
    /**
     * @test
     */
    public function 全ての投球がガター()
    {
        $frame = new Frame();
        $frame->recordShot(0);
        $frame->recordShot(0);
        $this->assertEquals(0, $frame->getScore());
    }

    /**
     * @test
     */
    public function 全ての投球で1ピンだけ倒した()
    {
        $frame = new Frame();
        $frame->recordShot(1);
        $frame->recordShot(1);
        $this->assertEquals(2, $frame->getScore());
    }

    /**
     * @test
     */
    public function ２投するとフレームは完了する()
    {
        $frame = new Frame();
        $frame->recordShot(1);
        $this->assertFalse($frame->finished());
        $frame->recordShot(1);
        $this->assertEquals(2, $frame->score);
        $this->assertTrue($frame->finished());
    }

    /**
     * @test
     */
    public function １０ピン倒した時点でフレームを完了する()
    {
        $frame = new Frame();
        $frame->recordShot(10);
        $this->assertTrue($frame->finished());
    }

    /**
     * @test
     */
    public function ２投目で１０ピン倒すとスぺア()
    {
        $frame = new Frame();
        $frame->recordShot(5);
        $this->assertFalse($frame->spare());    // スペアではない
        $frame->recordShot(5);
        $this->assertTrue($frame->spare()); // 10ピンになったのでスペア
    }

    /**
     * @test
     */
    public function １投目で１０ピン倒すとストライク()
    {
        $frame = new Frame();
        $this->assertFalse($frame->strike());    // 投球前はストライクではない
        $frame->recordShot(10);
        $this->assertTrue($frame->strike()); // ストライク
    }

    /**
     * @test
     */
    public function ボーナス点を加算する()
    {
        $frame = new Frame();
        $frame->recordShot(5);
        $frame->recordShot(5);
        $frame->addBonus(5);
        $this->assertEquals(15, $frame->getScore()); // ストライク
    }
}
