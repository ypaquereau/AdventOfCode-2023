<?php

$total = 0;

foreach (file('input') as $line) {
    preg_match_all('/(?=([1-9]|one|two|three|four|five|six|seven|eight|nine))/', $line, $matches);

    $numbers = $matches[1];

    $firstNumber = getNumber($numbers[array_key_first($numbers)]);
    $lastNumber = getNumber($numbers[array_key_last($numbers)]);

    $total += (int) "$firstNumber$lastNumber";;
}

echo $total . "\n";

function getNumber(string $number): string
{
    $numbersInLetters = [
        'one' => '1',
        'two' => '2',
        'three' => '3',
        'four' => '4',
        'five' => '5',
        'six' => '6',
        'seven' => '7',
        'eight' => '8',
        'nine' => '9',
    ];

    return $numbersInLetters[$number] ?? $number;
}
