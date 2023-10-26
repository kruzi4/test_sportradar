<?php

use App\Classes\Game;
use App\Classes\Team;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{
    public function getHomeTeamTest(): void
    {
        $game = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );
        $this->assertEquals('Ukraine', $game->getHomeTeam());
    }

    public function getAwayTeamTest(): void
    {
        $game = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );
        $this->assertEquals('Poland', $game->getAwayTeam());
    }

    public function testGameScoreOnStart(): void
    {
        $game = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );
        $this->assertEquals(0, $game->getHomeTeamScore());
        $this->assertEquals(0, $game->getAwayTeamScore());
    }

    public function testUpdateScore(): void
    {
        $game = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );
        $game->updateScore(1, 2);
        $this->assertEquals(1, $game->getHomeTeamScore());
        $this->assertEquals(2, $game->getAwayTeamScore());
    }

    public function testUpdateNegativeScore(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $game = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );
        $game->updateScore(-1, 2);
    }

    public function testGameId(): void
    {
        $game = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );
        $this->assertEquals('UkrainePoland', $game->getGameId());
    }

    public function testGameHaveSameTeams(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Game(
            new Team('Ukraine'),
            new Team('Ukraine')
        );
    }

    public static function teamNamesAndScoresProvider(): array
    {
        return [
            [['Ukraine', 'Poland'], [1, 2], 'Ukraine 1 - 2 Poland'],
            [['Poland', 'Ukraine'], [0, 0], 'Poland 0 - 0 Ukraine'],
            [['Ukraine', 'Poland'], [200, 1], 'Ukraine 200 - 1 Poland'],
        ];
    }

    #[DataProvider('teamNamesAndScoresProvider')]
    public function testGetScoreOutput(array $teamNames, array $score, string $expected): void
    {
        $game = new Game(
            new Team($teamNames[0]),
            new Team($teamNames[1])
        );
        $game->updateScore($score[0], $score[1]);
        $this->assertEquals($expected, $game->getScoreOutput());
    }

    public function testGetTotalScore(): void
    {
        $game = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );
        $game->updateScore(1, 2);
        $this->assertEquals(3, $game->getTotalScore());
    }
}
