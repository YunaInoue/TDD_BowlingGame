<?php
namespace myApp;


class BowlingGame
{
    /** @var int 都道府県等が定める 額 */
    public $score;

    /**
     * BowlingGame constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param int $pins
     */
    public function recordShot(int $pins): void
    {
        $this->score += $pins;
    }

}