<?php

$fileContent = file('input');

$sum = 0;

foreach ($fileContent as $lineIndex => $content) {
    preg_match_all('/\*/', $content, $matches, PREG_OFFSET_CAPTURE);

    $asterisks = $matches[0];

    if ($asterisks === []) {
        continue;
    }

    foreach ($asterisks as $asterisk) {
        $sum += getAdjacentNumbers(
            $asterisk[1],
            $content,
            $fileContent[$lineIndex - 1],
            $fileContent[$lineIndex + 1]
        );
    }
}

function getAdjacentNumbers(
    int $asteriskIndex,
    string $currentLine,
    ?string $previousLine,
    ?string $nextLine,
): int {
    $numbers = [];

    $searchingNumberIndexes = [
        'top' => [
            'string' => $previousLine,
            'indexes' => [$asteriskIndex - 1, $asteriskIndex, $asteriskIndex + 1],
        ],
        'bottom' => [
            'string' => $nextLine,
            'indexes' => [$asteriskIndex - 1, $asteriskIndex, $asteriskIndex + 1],
        ],
        'current' => [
            'string' => $currentLine,
            'indexes' => [$asteriskIndex - 1, $asteriskIndex + 1],
        ],
    ];

    foreach ($searchingNumberIndexes as $position => $searchingNumberIndex) {
        foreach ($searchingNumberIndex['indexes'] as $index) {
            if (is_numeric($searchingNumberIndex['string'][$index])) {
                $numbersInfo = getNumberInfo($position, $index, $searchingNumberIndex['string']);

                if (!in_array($numbersInfo, $numbers)) {
                    $numbers[] = $numbersInfo;
                }
            }
        }
    }

    if (count($numbers) !== 2) {
        return 0;
    }


    return array_product(array_column($numbers, 'value'));
}

function getNumberInfo(string $position, int $foundedNumberIndex, string $rowContent): array
{
    $number = "$rowContent[$foundedNumberIndex]";
    $startIndex = $foundedNumberIndex;

    for ($i = $foundedNumberIndex - 1; $i >= 0; --$i) {
        if (is_numeric($rowContent[$i])) {
            $number = $rowContent[$i] . $number;
            $startIndex = $i;
        } else {
            break;
        }
    }

    for ($i = $foundedNumberIndex + 1; $i < strlen($rowContent); ++$i) {
        if (is_numeric($rowContent[$i])) {
            $number = $number . $rowContent[$i];
        } else {
            break;
        }
    }

    return [
        'position' => $position,
        'startIndex' => $startIndex,
        'value' => (int) $number,
    ];
}

echo $sum . "\n";
