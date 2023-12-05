<?php

$total = 0;

foreach (file('input') as $line) {
    preg_match_all(
        '/(?<number>\d{1,3}) (?<color>red|green|blue)/',
        $line,
        $matches,
        PREG_SET_ORDER
    );

    $total += getPowers($matches);
}

echo $total . "\n";

function getPowers(array $matches): int
{
    $maxColors = [];

    foreach ($matches as $match) {
        if (
            !array_key_exists($match['color'], $maxColors)
            || $match['number'] > $maxColors[$match['color']]
        ) {
            $maxColors[$match['color']] = (int) $match['number'];
        }
    }

    return array_product($maxColors);
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
