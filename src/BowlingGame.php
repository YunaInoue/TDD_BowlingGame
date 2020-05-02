<?php

namespace myApp;


class BowlingGame
{
    /** @var int スコア */
    public $score;

    /** @var int フレームの1投球目で倒したピン数 */
    public $firstShotPins;

    /** @var bool スペアフラグ */
    public $spare;

    /** @var int ストライクボーナスカウント */
    public $strikeBonusCount;

    /**
     * BowlingGame constructor.
     */
    public function __construct()
    {
        $this->score = 0;
        $this->firstShotPins = null;
        $this->spare = false;
        $this->strikeBonusCount = 0;
    }

    /**
     * @param int $pins
     */
    public function recordShot(int $pins): void
    {
        $this->score += $pins;
        if ($this->strikeBonusCount > 0) {
            $this->score += $pins;
            $this->strikeBonusCount -= 1;
        }
        // 前回スペアだった場合
        $this->calcSpareBonus($pins);
        if ($this->isStrike($pins)) {
            $this->strikeBonusCount += 2;
            $this->firstShotPins = null;
        }
        // 各フレームの1投目の場合
        if ($this->isFirstShotInFrame()) {
            $this->firstShotPins = $pins;
            return;
        }
        $this->firstShotPins = null;
    }

    /**
     * @return bool
     */
    private function isFirstShotInFrame(): bool
    {
        return is_null($this->firstShotPins);
    }

    /**
     * @param int $pins
     */
    public function calcSpareBonus(int $pins): void
    {
        if ($this->spare) { // 前回スペアだった場合ボーナス追加
            $this->score += $pins;
            $this->spare = false;
        }
        $this->spare = $this->isSpare($pins);
    }

    /**
     * @param int $pins
     * @return bool
     */
    public function isSpare(int $pins): bool
    {
        return !$this->isFirstShotInFrame() && $pins + $this->firstShotPins === 10;
    }

    /**
     * @param int $pins
     * @return bool
     */
    public function isStrike(int $pins): bool
    {
        return $this->isFirstShotInFrame() && $pins === 10;
    }
}