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
        $this->assertEquals(0, $frame->score);
    }

    /**
     * @test
     */
    public function 全ての投球で1ピンだけ倒した()
    {
        $frame = new Frame();
        $frame->recordShot(1);
        $frame->recordShot(1);
        $this->assertEquals(2, $frame->score);
    }
}
