<?php

declare(strict_types=1);

$games = file_get_contents('input.txt');
$possibleGames = [];

$maxCubes = [
    'red' => 12,
    'green' => 13,
    'blue' => 14,
];

// Parse input
$idRegex = "Game\s(?'id'\d*)";
$setRegex = "(?'red'\d*)\sred|(?'green'\d*)\sgreen|(?'blue'\d*)\sblue";

foreach (explode(PHP_EOL, $games) as $game) {
    preg_match_all("/$idRegex/", $game, $idMatch);

    if (empty($idMatch['id'][0])) {
        continue;
    }

    $isValidGame = true;

    foreach (explode(';', $game) as $set) {
        if ($isValidGame === false) {
            continue;
        }

        preg_match_all("/$setRegex/", $set, $setMatches);

        $parsedGameSet = array_map(
            static fn(array $color): int => array_sum(
                array_map(static fn(string $val): int => (int)$val, $color)
            ),
            [$setMatches['red'] ?? [], $setMatches['green'] ?? [], $setMatches['blue'] ?? []]
        );

        // Validate that colors stay upon boundaries
        if (($maxCubes['red'] - $parsedGameSet[0]) < 0
            || ($maxCubes['green'] - $parsedGameSet[1]) < 0
            || ($maxCubes['blue'] - $parsedGameSet[2]) < 0
        ) {
            $isValidGame = false;
        }
    }

    if ($isValidGame) {
        $possibleGames[] = (int) $idMatch['id'][0];
    }
}

printf("Valid games sum: %d\n", array_sum($possibleGames));
