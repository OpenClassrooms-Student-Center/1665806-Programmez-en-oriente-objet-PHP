<?php


class Encounter
{
    private const RESULT_WINNER = 1;
    private const RESULT_LOSER = -1;
    private const RESULT_DRAW = 0;
    private const RESULT_POSSIBILITIES = [RESULT_WINNER, RESULT_LOSER, RESULT_DRAW];
    
    
    public function probabilityAgainst(Player $playerOne, Player $playerTwo): float
    {
        return 1/(1+(10 ** (($playerTwo->level - $playerOne->level)/400)));
    }

    public function setNewLevel(Player $playerOne, Player $playerTwo, int $playerOneResult): void
    {
        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)) {
            trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', self::RESULT_POSSIBILITIES)));
        }

        $playerOne->level += round(32 * ($playerOneResult - $this->probabilityAgainst($playerOne, $playerTwo)));
    }
}

class Player
{
    public int $level;
}

$greg = new Player;
$jade = new Player;

$greg->level = 400;
$jade->level = 800;

$encounter = new Encounter;

echo sprintf(
        'Greg à %.2f%% chance de gagner face a Jade',
        $encounter->probabilityAgainst($greg, $jade)*100
    ).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
$encounter->setNewLevel($greg, $jade, self::RESULT_WINNER);
$encounter->setNewLevel($jade, $greg, self::RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $greg->level,
    $jade->level
);

exit(0);
