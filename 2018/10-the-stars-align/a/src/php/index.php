#!/usr/bin/env php
<?php
$points = $grid = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$point = [];
	preg_match('/^position\=\<\s*(-?\d+),\s*(-?\d+)\>\s*velocity\=\<\s*(-?\d+),\s*(-?\d+)\>$/', trim($line), $point);

	$points[] = array_slice($point, -4);
}
fclose($f);

print_r(compact('points'));

$xCoordinates = array_column($points, 0);
$yCoordinates = array_column($points, 1);

$minimalX = min($xCoordinates);
$maximalX = max($xCoordinates);
$minimalY = min($yCoordinates);
$maximalY = max($yCoordinates);

print_r(compact('minimalX', 'maximalX', 'minimalY', 'maximalY'));

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

function printGrid(array $grid) : void {
	foreach ($grid as $y) {
		foreach ($y as $x) {
			echo $x;
		}
		echo PHP_EOL;
	}
}
