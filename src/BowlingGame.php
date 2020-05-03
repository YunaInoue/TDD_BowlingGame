<?php

namespace myApp;


class BowlingGame
{

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

    /** @var Frame ダブルフレーム */
    public $doubleFrame;

    /**
     * BowlingGame constructor.
     */
    public function __construct()
    {
        $this->strikeBonusCount = 0;
        $this->frames = array(new Frame());
        $this->spareFrame = null;
        $this->strikeFrame = null;
        $this->doubleFrame = null;
    }

    /**
     * @param int $pins
     */
    public function recordShot(int $pins): void
    {
        $frame = end($this->frames);
        $frame->recordShot($pins);
        $this->calcSpareBonus($pins);
        $this->calcStrikeBonus($pins);
        if ($frame->finished()) {
            array_push($this->frames, new Frame());
        }
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        $score = 0;
        foreach ($this->frames as $frame) {
            $score += $frame->getScore();
        }
        return $score;
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
        if ($this->spareFrame && $this->spareFrame->needBonus()) {
            $this->spareFrame->addBonus($pins);
            $this->spareFrame = null;
        }
        if (end($this->frames)->spare()) {
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
            $this->doubleFrame->addBonus($pins);
            $this->doubleBonusCount -= 1;
        }
    }

    /**
     * @param int $pins
     */
    private function recognizeStrikeBonus(int $pins): void
    {
        if ($this->isDouble($pins)) {
            $this->doubleFrame = end($this->frames);
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