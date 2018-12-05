#!/usr/bin/env php
<?php
$polymer = '';

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$polymer = trim($line);
}
fclose($f);

// echo $polymer . PHP_EOL;

assert(isReactionPossible('a', 'A') === true);
assert(isReactionPossible('A', 'a') === true);
assert(isReactionPossible('a', 'a') === false);
assert(isReactionPossible('A', 'A') === false);
assert(isReactionPossible('A', 'A') === false);
assert(isReactionPossible('A', 'B') === false);
assert(isReactionPossible('a', 'b') === false);
assert(isReactionPossible('a', 'B') === false);

assert(removeReacting('abcd', 0) === 'cd');
assert(removeReacting('abcd', 1) === 'ad');
assert(removeReacting('abcd', 2) === 'ab');
assert(removeReacting('abcd', 3) === 'abc');
assert(removeReacting('abcd', 4) === 'abcd');

$polymerLength = strlen($polymer);
$index = $iterations = 0;
while ($polymerLength > 0 && $index < $polymerLength) {
	$iterations += 1;

	$unit = $polymer[$index];
	$nextIndex = $index + 1;
	$nextUnit = $polymer[$nextIndex] ?? '';

	if (isReactionPossible($unit, $nextUnit)) {
		$polymer = removeReacting($polymer, $index);
		$polymerLength = strlen($polymer);
		$index = 0;
		continue;
	}

	$index += 1;
}

echo strlen($polymer) . PHP_EOL;
// echo $iterations . PHP_EOL;

function isReactionPossible(string $a, string $b) : bool {
	if ($a === $b) {
		return false;
	}

	$lowerA = strtolower($a);
	$lowerB = strtolower($b);
	if ($lowerA !== $lowerB) {
		return false;
	}

	return true;
}

function removeReacting(string $polymer, int $index) : string {
	return substr_replace($polymer, '', $index, 2);
}
