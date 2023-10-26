<?php

namespace App\Classes;

use InvalidArgumentException;
use RuntimeException;

class Game
{
    private string $gameId;
    private int $homeTeamScore = 0;
    private int $awayTeamScore = 0;
    private bool $isLive = false;

    public function __construct(
        readonly private Team $homeTeam,
        readonly private Team $awayTeam,
    ) {
        if ($homeTeam->getName() === $awayTeam->getName()) {
            throw new InvalidArgumentException('Teams cannot be the same');
        }

        $this->gameId = $this->homeTeam->getName() . $this->awayTeam->getName();
    }

    public function getGameId(): string
    {
        return $this->gameId;
    }

    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    public function getHomeTeamScore(): int
    {
        return $this->homeTeamScore;
    }

    public function getAwayTeamScore(): int
    {
        return $this->awayTeamScore;
    }

    public function setIsLive(bool $isLive = true): void
    {
        $this->isLive = $isLive;
    }

    public function updateScore(int $homeTeamScore, int $awayTeamScore): void
    {
        if (!$this->isLive) {
            throw new RuntimeException('Game is not live');
        }

        if ($homeTeamScore < 0 || $awayTeamScore < 0) {
            throw new InvalidArgumentException('Score cannot be negative');
        }

        $this->homeTeamScore = $homeTeamScore;
        $this->awayTeamScore = $awayTeamScore;
    }

    public function getScoreOutput(): string
    {
        if (!$this->isLive) {
            throw new RuntimeException('Game is not live');
        }

        return sprintf(
            '%s %s - %s %s',
            $this->homeTeam->getName(), $this->homeTeamScore, $this->awayTeamScore, $this->awayTeam->getName()
        );
    }

    public function getTotalScore(): int
    {
        return $this->homeTeamScore + $this->awayTeamScore;
    }
}