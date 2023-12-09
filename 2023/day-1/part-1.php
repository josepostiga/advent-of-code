<?php

declare(strict_types=1);

$doc = file_get_contents('input.txt');
$calibration = [];

foreach (explode(PHP_EOL, $doc) as $line) {
    preg_match_all('/\d/', $line, $matches);
    $first = $matches[0][0];
    $last = $matches[0][count($matches[0]) - 1] ?? $first;

    $calibration[] = (int) $first . $last;
}

printf("Calibration: %d\n", array_sum($calibration));
