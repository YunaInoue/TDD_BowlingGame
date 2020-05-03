<?php


namespace myApp;


class Frame
{

    /** @var int スコア */
    public $score;

    /** @var int 投球数 */
    public $shotNo;

    /**
     * Frame constructor.
     */
    public function __construct()
    {
        $this->score = 0;
        $this->shotNo = 0;
    }

    /**
     * @param int $pins
     */
    public function recordShot(int $pins): void
    {
        $this->score += $pins;
        $this->shotNo += 1;
    }

    /**
     * @return bool
     */
    public function finished(): bool
    {
        return $this->shotNo === 2;
    }
}