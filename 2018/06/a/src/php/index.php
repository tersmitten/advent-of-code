#!/usr/bin/env php
<?php
$chronals = $chronalsWithFiniteAreas = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$chronals[] = explode(', ', trim($line));
}
fclose($f);

assert(manhattanDistance([1, 1], [1, 6]) === 5);
assert(manhattanDistance([1, 1], [3, 4]) === 5);

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
		throw InvalidArgumentException::arraySizeNotMatch();
	}

	return (int)array_sum(array_map(function (int $m, int $n) : int {
		return abs($m - $n);
	}, $a, $b));
}
