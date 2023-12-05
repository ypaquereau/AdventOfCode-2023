<?php

$total = 0;

foreach (file('input') as $line) {
    preg_match_all(
        '/(?<number>\d{1,3}) (?<color>red|green|blue)/',
        $line,
        $matches,
        PREG_SET_ORDER
    );

    if (isLineValid($matches)) {
        preg_match('/Game (\d+)/', $line, $matches);

        $total += (int) $matches[1];
    }
}

echo $total . "\n";

function isLineValid(array $matches): bool
{
    foreach ($matches as $match) {
        if (!isNumberValid($match['color'], $match['number'])) {
            return false;
        }
    }

    return true;
}

function isNumberValid(string $color, int $number): bool
{
    return match($color) {
        'red' => $number <= 12,
        'green' => $number <= 13,
        'blue' => $number <= 14,
        default => false
    };
}
