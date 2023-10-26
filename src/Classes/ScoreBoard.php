<?php

namespace App\Classes;

use InvalidArgumentException;

class ScoreBoard
{
    /**
     * @var Game[]
     */
    private array $games = [];

    public function startGame(Game $game): void
    {
        $this->validateGameOnStart($game);
        $game->setIsLive(true);
        $this->games[] = $game;
    }

    public function finishGame(Game $game): void
    {
        foreach ($this->getLiveGames() as $pos => $liveGame) {
            if ($liveGame->getGameId() === $game->getGameId()) {
                $this->games[$pos]->setIsLive(false);
                unset($this->games[$pos]);
            }
        }

        $this->games = array_values($this->getLiveGames());
    }

    public function getSummaryByTotalScore(): string
    {
        $games = array_reverse($this->getLiveGames());
        usort($games, static fn (Game $a, Game $b) => $b->getTotalScore() - $a->getTotalScore());

        return $this->generateSummaryOutput($games);
    }

    /**
     * @return Game[]
     */
    public function getLiveGames(): array
    {
        return $this->games;
    }

    /**
     * @param Game[] $games
     */
    private function generateSummaryOutput(array $games): string
    {
        $summary = '';
        foreach ($games as $pos => $game) {
            $summary .= ++$pos . '. ' . $game->getScoreOutput() . PHP_EOL;
        }

        return $summary;
    }

    private function validateGameOnStart(Game $game): void
    {
        $teamNames = [];
        foreach ($this->getLiveGames() as $liveGame) {
            $teamNames[] = $liveGame->getHomeTeam()->getName();
            $teamNames[] = $liveGame->getAwayTeam()->getName();
        }

        if (in_array($game->getHomeTeam()->getName(), $teamNames, true) || in_array($game->getAwayTeam()->getName(), $teamNames, true)) {
            throw new InvalidArgumentException('One of the teams already playing');
        }
    }
}