<?php

namespace myApp;


class BowlingGame
{
    /** @var int スコア */
    public $score;

    /** @var bool スペアフラグ */
    public $spare;

    /** @var int ストライクボーナスカウント */
    public $strikeBonusCount;

    /** @var int ダブルボーナスカウント */
    public $doubleBonusCount;

    /** @var array|Frame[] フレーム */
    public $frames;

    /** @var Frame スペアフレーム */
    public $spareFrame;

    /** @var Frame ストライクフレーム */
    public $strikeFrame;

    /**
     * BowlingGame constructor.
     */
    public function __construct()
    {
        $this->score = 0;
        $this->spare = false;
        $this->strikeBonusCount = 0;
        $this->frames = array(new Frame());
        $this->spareFrame = null;
        $this->strikeFrame = null;
    }

    /**
     * @param int $pins
     */
    public function recordShot(int $pins): void
    {
        $frame = end($this->frames);
        $frame->recordShot($pins);
        $this->score += $pins;
        $this->calcSpareBonus($pins);
        $this->calcStrikeBonus($pins);
        if ($frame->finished()) {
            array_push($this->frames, new Frame());
        }
    }

    /**
     * @param int $frameNo
     * @return int
     */
    public function frameScore(int $frameNo): int
    {
        return $this->frames[$frameNo - 1]->getScore();
    }

    /**
     * @param int $pins
     */
    private function calcSpareBonus(int $pins): void
    {
        if ($this->spare) { // 前回スペアだった場合ボーナス追加
            $this->score += $pins;
            $this->spareFrame->addBonus($pins);
            $this->spareFrame = null;
        }
        $this->spare = end($this->frames)->spare();
        if ($this->spare) {
            $this->spareFrame = end($this->frames);
        }
    }


    /**
     * @param int $pins
     */
    private function calcStrikeBonus(int $pins): void
    {
        $this->addStrikeBonus($pins);
        $this->addDoubleBonus($pins);
        $this->recognizeStrikeBonus($pins);
    }

    /**
     * @param int $pins
     */
    private function addStrikeBonus(int $pins): void
    {
        if ($this->strikeBonusCount > 0) {
            $this->score += $pins;
            $this->strikeFrame->addBonus($pins);
            $this->strikeBonusCount -= 1;
        }
    }

    /**
     * @param int $pins
     */
    private function addDoubleBonus(int $pins): void
    {
        if ($this->doubleBonusCount > 0) {
            $this->score += $pins;
            $this->doubleBonusCount -= 1;
        }
    }

    /**
     * @param int $pins
     */
    private function recognizeStrikeBonus(int $pins): void
    {
        if ($this->isDouble($pins)) {
            $this->doubleBonusCount = 2;
            return;
        }
        if (end($this->frames)->strike()) {
            $this->strikeFrame = end($this->frames);
            $this->strikeBonusCount = 2;
        }
    }

    /**
     * @param int $pins
     * @return bool
     */
    private function isDouble(int $pins): bool
    {
        return $this->strikeBonusCount > 0 && $pins === 10;
    }
}