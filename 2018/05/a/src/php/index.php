#!/usr/bin/env php
<?php
$polymer = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$polymer = str_split(trim($line), 1);
}
fclose($f);

// print_r($polymer);

assert(isReactionPossible('a', 'A') === true);
assert(isReactionPossible('A', 'a') === true);
assert(isReactionPossible('a', 'a') === false);
assert(isReactionPossible('A', 'A') === false);
assert(isReactionPossible('A', 'A') === false);
assert(isReactionPossible('A', 'B') === false);
assert(isReactionPossible('a', 'b') === false);
assert(isReactionPossible('a', 'B') === false);

$polymerLength = count($polymer);
while (true) {
	$index = 0;
	while ($index < $polymerLength) {
		$unit = $polymer[$index];
		$nextIndex = $index + 1;
		$nextUnit = $polymer[$nextIndex] ?? '';

		if (isReactionPossible($unit, $nextUnit)) {
			unset($polymer[$index], $polymer[$nextIndex]);
			break;
		}

		$index += 1;
	}

	$newPolymerLength = count($polymer);
	if ($newPolymerLength === 0 || $newPolymerLength === $polymerLength) {
		break;
	}

	$reorderedPolymer = array_values($polymer);
	// print_r(compact('polymer', 'reorderedPolymer'));
	$polymer = $reorderedPolymer;

	$polymerLength = $newPolymerLength;
}

echo count($polymer) . PHP_EOL;

function isReactionPossible(string $a, string $b) : bool {
	if (hash_equals($a, $b)) {
		return false;
	}

	$lowerA = strtolower($a);
	$lowerB = strtolower($b);
	if (!hash_equals($lowerA, $lowerB)) {
		return false;
	}

	return true;
}
