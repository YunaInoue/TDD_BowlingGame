<?php


namespace myApp;


class Frame
{

    /** @var int スコア */
    public $score;

    /** @var int 投球数 */
    public $shotNo;

    /** @var int ボーナス */
    public $bonus;

    /**
     * Frame constructor.
     */
    public function __construct()
    {
        $this->score = 0;
        $this->shotNo = 0;
        $this->bonus = 0;
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
     * @return int
     */
    public function getScore(): int
    {
        return $this->score + $this->bonus;
    }

    /**
     * @return bool
     */
    public function finished(): bool
    {
        return $this->score >= 10 || $this->shotNo >= 2;
    }

    /**
     * @return bool
     */
    public function spare(): bool
    {
        return $this->score === 10 && $this->shotNo >= 2;
    }

    /**
     * @return bool
     */
    public function strike(): bool
    {
        return $this->score === 10 && $this->shotNo === 1;
    }

    /**
     * @param int $bonus
     */
    public function addBonus(int $bonus)
    {
        $this->bonus += $bonus;
    }

    /**
     * @return bool
     */
    public function needBonus(): bool
    {
        return $this->spare() || $this->strike();
    }
}