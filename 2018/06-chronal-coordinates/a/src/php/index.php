#!/usr/bin/env php
<?php
$chronals = $chronalsWithFiniteAreas = [];

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

$xCoordinates = array_column($chronals, 0);
$yCoordinates = array_column($chronals, 1);

$minimalX = min($xCoordinates);
$maximalX = max($xCoordinates);
$minimalY = min($yCoordinates);
$maximalY = max($yCoordinates);

foreach ($chronals as $i => $chronal) {
	list($chronalX, $chronalY) = $chronal;
	if ($chronalX !== $minimalX && $chronalX !== $maximalX && $chronalY !== $minimalY && $chronalY !== $maximalY) {
		$chronalsWithFiniteAreas[$i] = $chronal;
	}
}

$numberOfClosestLocations = array_fill_keys(array_keys($chronalsWithFiniteAreas), 0);
for ($x = $minimalX + 1; $x < $maximalX; $x += 1) {
	for ($y = $minimalY + 1; $y < $maximalY; $y += 1) {
		$minimalManhattanDistance = PHP_INT_MAX;
		$closestChronals = [];
		foreach ($chronals as $i => $chronal) {
			list($chronalX, $chronalY) = $chronal;

			$manhattanDistance = manhattanDistance($chronal, [$x, $y]);
			if ($manhattanDistance === $minimalManhattanDistance) {
				$closestChronals[] = $i;
			} elseif ($manhattanDistance < $minimalManhattanDistance) {
				$minimalManhattanDistance = $manhattanDistance;
				$closestChronals = [$i];
			}
		}

		if (count($closestChronals) === 1 && array_key_exists($closestChronals[0], $chronalsWithFiniteAreas)) {
			$numberOfClosestLocations[$closestChronals[0]] += 1;
		}
	}
}

echo max($numberOfClosestLocations) . PHP_EOL;

function manhattanDistance(array $a, array $b): int {
	if (count($a) !== count($b)) {
		throw new InvalidArgumentException('Array sizes do not match');
	}

	return abs($a[0] - $b[0]) + abs($a[1] - $b[1]);
}
