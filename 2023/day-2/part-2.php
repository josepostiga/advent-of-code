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

    $gameId = (int)$idMatch['id'][0] ?? 0;

    if (empty($gameId)) {
        continue;
    }

    foreach (explode(';', $game) as $index => $set) {
        preg_match_all("/$setRegex/", $set, $setMatches);

        $parsedGameSet[$gameId][$index] = array_map(
            static fn(array $color): int => array_sum(
                array_map(static fn(string $val): int => (int)$val, $color)
            ),
            [$setMatches['red'] ?? [], $setMatches['green'] ?? [], $setMatches['blue'] ?? []]
        );
    }

    $minGameSet[$gameId] = array_reduce(
        $parsedGameSet[$gameId] ?? [],
        static fn(mixed $carrie, mixed $item): array => [
            max($carrie[0], $item[0]),
            max($carrie[1], $item[1]),
            max($carrie[2], $item[2]),
        ],
        [0, 0, 0]
    );
}

printf(
    "Sum of the power of minimum game sets: %d\n",
    array_sum(
        array_map(
            static fn(array $set): int => $set[0] * $set[1] * $set[2],
            $minGameSet ?? [0, 0, 0],
        )
    )
);
