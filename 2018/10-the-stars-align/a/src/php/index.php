#!/usr/bin/env php
<?php
$shortopts = '';
$shortopts .= 's:';
$options = getopt($shortopts);
if (empty($options['s'])) {
	fwrite(STDERR, sprintf('Usage: %s [-s Maximum number of seconds]' . PHP_EOL, $argv[0]));
	exit(1);
}

$points = $grid = $timeline = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$point = [];
	preg_match('/^position\=\<\s*(-?\d+),\s*(-?\d+)\>\s*velocity\=\<\s*(-?\d+),\s*(-?\d+)\>$/', trim($line), $point);

	$points[] = array_slice($point, -4);
}
fclose($f);

$minimalGrid = 0;
$minimalGridSize = [];
$minimalGridProduct = PHP_INT_MAX;
foreach (range(1, $options['s'] - 1) as $tI) {
	foreach ($points as $pI => $point) {
		list($x, $y, $vX, $vY) = $point;

		$timeline[$tI][$pI][0] = $x + ($tI * $vX);
		$timeline[$tI][$pI][1] = $y + ($tI * $vY);
	}

	$xCoordinates = array_column($timeline[$tI], 0);
	$yCoordinates = array_column($timeline[$tI], 1);

	$minimalX = min($xCoordinates);
	$maximalX = max($xCoordinates);
	$minimalY = min($yCoordinates);
	$maximalY = max($yCoordinates);

	$deltaX = abs($minimalX - $maximalX);
	$deltaY = abs($minimalY - $maximalY);

	$gridProduct = $deltaX * $deltaY;
	if ($gridProduct < $minimalGridProduct) {
		$minimalGrid = $tI;
		$minimalGridSize = [$deltaX, $deltaY];
		$minimalGridProduct = $gridProduct;

		$timeline = [
				$tI => $timeline[$tI],
		];
	}
}

if ($minimalGridProduct < 10 ** 3) {
	echo str_repeat('-', 76) . PHP_EOL;
	echo '| ' . $minimalGrid . PHP_EOL;
	echo str_repeat('-', 76) . PHP_EOL;
	echo PHP_EOL;
	printPoints($timeline[$minimalGrid]);
}

function printGrid(array $grid) : void {
	foreach ($grid as $y) {
		foreach ($y as $x) {
			echo $x;
		}
		echo PHP_EOL;
	}
}

function printPoints(array $points): void {
	$xCoordinates = array_column($points, 0);
	$yCoordinates = array_column($points, 1);

	$minimalX = min($xCoordinates);
	$maximalX = max($xCoordinates);
	$minimalY = min($yCoordinates);
	$maximalY = max($yCoordinates);

	$grid = [];
	foreach (range($minimalY, $maximalY) as $y) {
		foreach (range($minimalX, $maximalX) as $x) {
			$grid[$y][$x] = '.';
		}
	}

	foreach ($points as $point) {
		list($x, $y) = $point;
		$grid[$y][$x] = '#';
	}

	printGrid($grid);
}
