#!/usr/bin/env php
<?php
$gridSize = 300;

$f = fopen('php://stdin', 'r');
$gridSerialNumber = trim(fgets($f));
fclose($f);

assert(getPowerLevel(3, 5, 8) === 4);
assert(getPowerLevel(122, 79, 57) === -5);
assert(getPowerLevel(217, 196, 39) === 0);
assert(getPowerLevel(101,153, 71) === 4);

assert(getAdjacent(2, 2) === [[1, 1], [2, 1], [3, 1], [1, 2], [3, 2], [1, 3], [2, 3], [3, 3]]);

$maximumPowerLevel = PHP_INT_MIN;
$topLeftFuelCell = [0, 0];

$range = range(2, $gridSize - 1);
foreach ($range as $y) {
	foreach ($range as $x) {
		$totalPowerLevel = getPowerLevel($x, $y, $gridSerialNumber);
		$adjacentFuelCells = getAdjacent($x, $y);
		foreach ($adjacentFuelCells as $adjacentFuelCell) {
			list($aX, $aY) = $adjacentFuelCell;
			$totalPowerLevel += getPowerLevel($aX, $aY, $gridSerialNumber);
		}

		if ($totalPowerLevel > $maximumPowerLevel) {
			$maximumPowerLevel = $totalPowerLevel;
			$topLeftFuelCell = $adjacentFuelCells[0];
		}
	}
}

echo implode(',', $topLeftFuelCell) . PHP_EOL;

function getPowerLevel(int $x, int $y, int $gridSerialNumber) : int {
	$rackID = $x + 10;
	$powerLevel = $rackID * $y;
	$powerLevel += $gridSerialNumber;
	$powerLevel *= $rackID;
	$powerLevel = ($powerLevel / 100) % 10;
	$powerLevel -= 5;

	return $powerLevel;
}

function getAdjacent(int $x, int $y) : array {
	$xPlusOne = $x + 1;
	$xMinOne = $x - 1;
	$yPlusOne = $y + 1;
	$yMinOne = $y - 1;

	return [
		// topLeft
		[$xMinOne, $yMinOne],
		// top
		[$x, $yMinOne],
		// topRight
		[$xPlusOne, $yMinOne],
		// midLeft
		[$xMinOne, $y],
		// midRight
		[$xPlusOne, $y],
		// botLeft
		[$xMinOne, $yPlusOne],
		// bot
		[$x, $yPlusOne],
		// botRight
		[$xPlusOne, $yPlusOne],
	];
}
