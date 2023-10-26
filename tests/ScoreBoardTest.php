<?php

use App\Classes\Game;
use App\Classes\ScoreBoard;
use App\Classes\Team;
use PHPUnit\Framework\TestCase;

final class ScoreBoardTest extends TestCase
{
    public function testValidationGamesOnStart(): void
    {
        $board = new ScoreBoard();
        $game1 = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );

        $game2 = new Game(
            new Team('Austria'),
            new Team('Ukraine')
        );
        $this->expectException(InvalidArgumentException::class);

        $board->startGame($game1);
        $board->startGame($game2);
    }

    public function testGetLiveGamesAndStartGame(): void
    {
        $board = new ScoreBoard();
        $game = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );
        $board->startGame($game);

        $this->assertCount(1, $board->getLiveGames());
        $this->assertInstanceOf(Game::class, $board->getLiveGames()[0]);
        $this->assertEquals($game, $board->getLiveGames()[0]);
    }

    public function testFinishGame(): void
    {
        $board = new ScoreBoard();
        $game = new Game(
            new Team('Ukraine'),
            new Team('Poland')
        );
        $game2 = new Game(
            new Team('Canada'),
            new Team('Mexico')
        );
        $board->startGame($game);
        $board->startGame($game2);
        $this->assertCount(2, $board->getLiveGames());

        $board->finishGame($game);
        $this->assertCount(1, $board->getLiveGames());

        $board->finishGame($game2);
        $this->assertCount(0, $board->getLiveGames());
        $this->assertEquals([], $board->getLiveGames());
    }

    public function testGetSummaryByTotalScore(): void
    {
        $board = new ScoreBoard();
        $game = new Game(
            new Team('Mexico'),
            new Team('Canada')
        );
        $game2 = new Game(
            new Team('Spain'),
            new Team('Brazil')
        );
        $game3 = new Game(
            new Team('Germany'),
            new Team('France')
        );
        $game4 = new Game(
            new Team('Uruguay'),
            new Team('Italy')
        );
        $game5 = new Game(
            new Team('Argentina'),
            new Team('Australia')
        );
        $board->startGame($game);
        $game->updateScore(0, 5);

        $board->startGame($game2);
        $game2->updateScore(10, 2);

        $board->startGame($game3);
        $game3->updateScore(2, 2);

        $board->startGame($game4);
        $game4->updateScore(6, 6);

        $board->startGame($game5);
        $game5->updateScore(3, 1);
        $this->assertEquals(
            '1. Uruguay 6 - 6 Italy' . PHP_EOL .
            '2. Spain 10 - 2 Brazil' . PHP_EOL .
            '3. Mexico 0 - 5 Canada' . PHP_EOL .
            '4. Argentina 3 - 1 Australia' . PHP_EOL .
            '5. Germany 2 - 2 France' . PHP_EOL,
            $board->getSummaryByTotalScore()
        );
    }
}
