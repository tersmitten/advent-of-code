#!/usr/bin/env php
<?php
$shortopts = '';
$shortopts .= 'm:';
$options = getopt($shortopts);
if (empty($options['m'])) {
	fwrite(STDERR, sprintf('Usage: %s [-m Maximum total Manhattan distance]' . PHP_EOL, $argv[0]));
	exit(1);
}

$chronals = [];
$maximumTotalManhattanDistance = $options['m'];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$chronals[] = explode(', ', trim($line));
}
fclose($f);

assert(manhattanDistance([4, 3], [1, 1]) === 5);
assert(manhattanDistance([4, 3], [1, 6]) === 6);
assert(manhattanDistance([4, 3], [8, 3]) === 4);
assert(manhattanDistance([4, 3], [3, 4]) === 2);
assert(manhattanDistance([4, 3], [5, 5]) === 3);
assert(manhattanDistance([4, 3], [8, 9]) === 10);

assert(totalManhattanDistance([4, 3], [[1, 1], [1, 6], [8, 3], [3, 4], [5, 5], [8, 9]]) === 30);

$xCoordinates = array_column($chronals, 0);
$yCoordinates = array_column($chronals, 1);

$minimalX = min($xCoordinates);
$maximalX = max($xCoordinates);
$minimalY = min($yCoordinates);
$maximalY = max($yCoordinates);

$regionSize = 0;
for ($x = $minimalX + 1; $x < $maximalX; $x += 1) {
	for ($y = $minimalY + 1; $y < $maximalY; $y += 1) {
		$totalManhattanDistance = totalManhattanDistance([$x, $y], $chronals);
		if ($totalManhattanDistance < $maximumTotalManhattanDistance) {
			$regionSize += 1;
		}
	}
}

echo $regionSize . PHP_EOL;

function manhattanDistance(array $a, array $b): int {
	if (count($a) !== count($b)) {
		throw new InvalidArgumentException('Array sizes do not match');
	}

	return abs($a[0] - $b[0]) + abs($a[1] - $b[1]);
}

function totalManhattanDistance(array $highlightedLocation, array $chronals) : int {
	$totalManhattanDistance = 0;
	foreach ($chronals as $chronal) {
		$totalManhattanDistance += manhattanDistance($highlightedLocation, $chronal);
	}

	return $totalManhattanDistance;
}
