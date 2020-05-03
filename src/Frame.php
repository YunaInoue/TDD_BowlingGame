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

    /** @var int ボーナス残数 */
    public $bonusCount;

    /**
     * Frame constructor.
     */
    public function __construct()
    {
        $this->score = 0;
        $this->shotNo = 0;
        $this->bonus = 0;
        $this->bonusCount = 0;
    }

    /**
     * @param int $pins
     */
    public function recordShot(int $pins): void
    {
        $this->score += $pins;
        $this->shotNo += 1;
        if ($this->spare()) {
            $this->bonusCount = 1;
        } else if ($this->strike()) {
            $this->bonusCount = 2;
        }
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
        $this->bonusCount -= 1;
    }

    /**
     * @return bool
     */
    public function needBonus(): bool
    {
        return $this->bonusCount > 0;
    }
}