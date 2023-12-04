<?php

$total = 0;

foreach (file('input') as $line) {
    preg_match_all('/\d/', $line, $matches);

    $numbers = $matches[0];

    if (count($numbers) > 0) {
        $number = (int) "{$numbers[array_key_first($numbers)]}{$numbers[array_key_last($numbers)]}";

        $total += $number;
    }
}

# Print 53974
echo $total;
