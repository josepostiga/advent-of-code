<?php

declare(strict_types=1);

$doc = file_get_contents('input.txt');

$numberDict = [
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
    'six' => 6,
    'seven' => 7,
    'eight' => 8,
    'nine' => 9,
];

$calibration = [];
$regex = '\d|(?=(' . implode('|', array_keys($numberDict)) . '))';

foreach (explode(PHP_EOL, $doc) as $line) {
    preg_match_all("/{$regex}/", $line, $matches);

    $first = $numberDict[$matches[1][0]] ?? $matches[0][0];
    $last = $numberDict[$matches[1][count($matches[1]) - 1]] ?? $matches[0][count($matches[0]) - 1];

    $calibration[$line] = (int)$first . $last;
}

printf("Calibration: %d\n", array_sum($calibration));
