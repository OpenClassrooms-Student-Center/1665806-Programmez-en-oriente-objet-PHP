<?php

const RESULT_WINNER = 1;
const RESULT_LOSER = -1;
const RESULT_DRAW = 0;
const RESULT_POSSIBILITIES = [RESULT_WINNER, RESULT_LOSER, RESULT_DRAW];

function probabilityAgainst(int $levelPlayerOne, int $againstLevelPlayerTwo)
{
    return 1/(1+(10 ** (($againstLevelPlayerTwo - $levelPlayerOne)/400)));
}

function setNewLevel(int &$levelPlayerOne, int $againstLevelPlayerTwo, int $playerOneResult)
{
    if (!in_array($playerOneResult, RESULT_POSSIBILITIES)) {
        trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', RESULT_POSSIBILITIES)));
    }

    $levelPlayerOne += (int) (32 * ($playerOneResult - probabilityAgainst($levelPlayerOne, $againstLevelPlayerTwo)));
}

$greg = 400;
$jade = 800;

echo sprintf(
    'Greg à %.2f%% chance de gagner face a Jade',
    probabilityAgainst($greg, $jade)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
setNewLevel($greg, $jade, RESULT_WINNER);
setNewLevel($jade, $greg, RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $greg,
    $jade
);

exit(0);
