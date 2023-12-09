<?php

$fileContent = file('input');

$sum = 0;

foreach ($fileContent as $lineIndex => $content) {
    preg_match_all('/\d+/', $content, $matches, PREG_OFFSET_CAPTURE);
    $numbers = $matches[0];

    if ($numbers === []) {
        continue;
    }

    foreach ($numbers as $number) {
        if (isAdjacentSpecialCharacterPresence(
            $number[1],
            strlen($number[0]),
            $content,
            $fileContent[$lineIndex-1] ?? null,
            $fileContent[$lineIndex+1] ?? null
        )) {
            $sum += (int) $number[0];
        }
    }
}

echo $sum . "\n";

function isAdjacentSpecialCharacterPresence(
    int $numberStartIndex,
    int $numberLength,
    string $currentLine,
    ?string $previousLine,
    ?string $nextLine
): bool {
    $previousIndex = $numberStartIndex - 1;
    $nextIndex = $numberStartIndex + $numberLength;

    if (
        (isset($currentLine[$previousIndex]) && isStringContainsSpecialCharacters($currentLine[$previousIndex]))
        || (isset($currentLine[$nextIndex]) && isStringContainsSpecialCharacters($currentLine[$nextIndex]))
    ) {
        return true;
    }

    if (
        $previousLine !== null
        && isStringContainsSpecialCharacters(substr(
            $previousLine,
            ($previousIndex > 0) ? $previousIndex : 0,
            $numberLength + 2
        ))
    ) {
        return true;
    }

    if (
        $nextLine !== null
        && isStringContainsSpecialCharacters(substr(
            $nextLine,
            ($previousIndex > 0) ? $previousIndex : 0,
            $numberLength + 2
        ))
    ) {
        return true;
    }

    return false;
}

function isStringContainsSpecialCharacters(string $string): bool
{
    return preg_match('/[^0-9.\n]/', $string);
}
