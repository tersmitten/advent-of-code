#!/usr/bin/env php
<?php
$claims = $claimed = $overlapping = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $row, $matches);
	// print_r($matches);

	$claimID = $matches[1];
	$left = $matches[2];
	$top = $matches[3];
	$width = $matches[4];
	$height = $matches[5];

	$claims[] = [$claimID, getCoordinates($left, $top, $width, $height)];
}
fclose($f);

foreach ($claims as $claim) {
	list($claimID, $coordinates) = $claim;
	foreach ($coordinates as $coordinate) {
		$key = getKey($coordinate);
		if (array_key_exists($key, $claimed)) {
			$overlapping[$key] = null;
		}
		$claimed[$key] = null;
	}
}

foreach ($claims as $claim) {
	$hasOverlap = false;

	list($claimID, $coordinates) = $claim;
	foreach ($coordinates as $coordinate) {
		$key = getKey($coordinate);
		if (array_key_exists($key, $overlapping)) {
			$hasOverlap = true;
			continue;
		}
	}

	if (!$hasOverlap) {
		echo $claimID	. PHP_EOL;
		break;
	}
}

function getCoordinates(int $left, int $top, int $width, int $height) : array {
	$coordinates = [];
	for ($y = $top; $y < $top + $height; $y += 1) {
		for ($x = $left; $x < $left + $width; $x += 1) {
			$coordinates[] = [$x, $y];
		}
	}

	return $coordinates;
}

function getKey(array $coordinate): string {
	list($x, $y) = $coordinate;

	return "$x,$y";
}
