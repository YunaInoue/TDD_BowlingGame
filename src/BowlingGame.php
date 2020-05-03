<?php

namespace myApp;


class BowlingGame
{
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
        if (end($this->frames)->strike()) {
            $this->recognizeStrikeBonus();
        }
    }

    /**
     * @param int $pins
     */
    private function addStrikeBonus(int $pins): void
    {
        if ($this->strikeFrame && $this->strikeFrame->needBonus()) {
            $this->strikeFrame->addBonus($pins);
        }
    }

    /**
     * @param int $pins
     */
    private function addDoubleBonus(int $pins): void
    {
        if ($this->doubleFrame && $this->doubleFrame->needBonus()) {
            $this->doubleFrame->addBonus($pins);
        }
    }

    private function recognizeStrikeBonus(): void
    {
        if (!$this->strikeFrame || !$this->strikeFrame->needBonus()) {
            $this->strikeFrame = end($this->frames);
        } else {
            $this->doubleFrame = end($this->frames);
        }
    }
}