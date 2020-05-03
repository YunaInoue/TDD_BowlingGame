<?php


namespace myApp;


class Frame
{

    /** @var int スコア */
    public $score;

    /**
     * Frame constructor.
     */
    public function __construct()
    {
        $this->score = 0;
    }


    /**
     * @param int $pins
     */
    public function recordShot(int $pins): void
    {
        $this->score += $pins;
    }
}