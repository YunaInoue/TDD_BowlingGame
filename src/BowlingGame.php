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
        // 各フレームの1投目の場合
        if ($this->isFirstShotInFrame()) {
            // 前回スペアだった場合
            if ($this->spare) {
                $this->score += $pins;
            }
            $this->firstShotPins = $pins;
            return;
        }
        // 各フレームの2投目の場合
        $this->spare = $this->isSpare($pins);
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
     * @return bool
     */
    public function isSpare(int $pins): bool
    {
        return $pins + $this->firstShotPins === 10;
    }
}