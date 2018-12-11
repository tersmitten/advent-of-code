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

//print_r(compact('points'));

//$xCoordinates = array_column($points, 0);
//$yCoordinates = array_column($points, 1);
//
//$minimalX = min($xCoordinates);
//$maximalX = max($xCoordinates);
//$minimalY = min($yCoordinates);
//$maximalY = max($yCoordinates);

//print_r(compact('minimalX', 'maximalX', 'minimalY', 'maximalY'));

//foreach (range($minimalY, $maximalY) as $y) {
//	foreach (range($minimalX, $maximalX) as $x) {
//		$grid[$y][$x] = '.';
//	}
//}
//
//foreach ($points as $point) {
//	list($x, $y) = $point;
//	$grid[$y][$x] = '#';
//}

$timeline[0] = $points;
foreach (range(1, $options['s'] - 1) as $t) {
	foreach ($timeline[$t - 1] as $i => $point) {
		list($x, $y, $vX, $vY) = $point;

		$points[$i][0] = $x + ($t * $vX);
		$points[$i][1] = $y + ($t * $vY);
	}
	$timeline[$t] = $points;
}

//printGrid($grid);
//echo PHP_EOL;
//printPoints($points);
//echo PHP_EOL;
printTimeline($timeline);

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

function printTimeline(array $timeline): void {
	foreach ($timeline as $t => $points) {
		echo str_repeat('-', 40) . PHP_EOL;
		echo '| ' . $t . PHP_EOL;
		echo str_repeat('-', 40) . PHP_EOL;
		echo PHP_EOL;
		printPoints($points);
		echo PHP_EOL;
	}
}
