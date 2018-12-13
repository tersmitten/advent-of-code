#!/usr/bin/env php
<?php
$gridSize = 300;

$f = fopen('php://stdin', 'r');
$gridSerialNumber = trim(fgets($f));
fclose($f);

assert(getAdjacent(1, 1, 300) === []);
assert(getAdjacent(2, 2, 300) === [
	[1, 1],
	[2, 1],
	[3, 1],
	[1, 2],
	[3, 2],
	[1, 3],
	[2, 3],
	[3, 3],
]);
assert(getAdjacent(3, 3, 300) === [
	[1, 1],
	[2, 1],
	[3, 1],
	[4, 1],
	[5, 1],
	[1, 2],
	[2, 2],
	[3, 2],
	[4, 2],
	[5, 2],
	[1, 3],
	[2, 3],
	[4, 3],
	[5, 3],
	[1, 4],
	[2, 4],
	[3, 4],
	[4, 4],
	[5, 4],
	[1, 5],
	[2, 5],
	[3, 5],
	[4, 5],
	[5, 5],
]);

$maximumPowerLevel = PHP_INT_MIN;
$topLeftFuelCell = [0, 0];

$range = range(2, $gridSize - 1);
foreach ($range as $y) {
	foreach ($range as $x) {
		$totalPowerLevel = getPowerLevel($x, $y, $gridSerialNumber);
		echo sprintf('%02d,%02d', $x, $y) . ' ';
		// echo sprintf('%02d', $totalPowerLevel) . ' ';
	}
	echo PHP_EOL;
}

function getPowerLevel(int $x, int $y, int $gridSerialNumber) : int {
	$rackID = $x + 10;
	$powerLevel = $rackID * $y;
	$powerLevel += $gridSerialNumber;
	$powerLevel *= $rackID;
	$powerLevel = ($powerLevel / 100) % 10;
	$powerLevel -= 5;

	return $powerLevel;
}

function getAdjacent(int $x, int $y, int $gridSize) : array {
	$minimalX = $minimalY = 1;
	$maximalX = $maximalY = $gridSize;

	$left = $x - $minimalX;
	$right = abs($x - $maximalX);
	$top = $y - $minimalY;
	$bottom = abs($y - $minimalY);

	$maximalAdjacentDepth = min($left, $right, $top, $bottom);

	$adjacent = [];
	foreach (range(abs($maximalAdjacentDepth - $y), $maximalAdjacentDepth + $y) as $aY) {
		foreach (range(abs($maximalAdjacentDepth - $x), $maximalAdjacentDepth + $x) as $aX) {
			if ($aX === $x && $aY === $y) {
				continue;
			}
			$adjacent[] = [$aX, $aY];
		}
	}

	return $adjacent;
}
