<?php
declare(strict_types=1);

use App\Classes\Team;
use PHPUnit\Framework\TestCase;

final class TeamTest extends TestCase
{
    public function testTeamName(): void
    {
        $team = new Team('Mexico');
        $this->assertEquals('Mexico', $team->getName());

        $team2 = new Team('   Ukraine ');
        $this->assertEquals('Ukraine', $team2->getName());
    }

    public function testForbiddenTeamName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Team('');
    }
}
