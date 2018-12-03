#!/usr/bin/env php
<?php
$claims = $area = $overlap = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $row, $matches);
	// print_r($matches);

	$claimID = $matches[1];
	$left = $matches[2];
	$top = $matches[3];
	$width = $matches[4];
	$height = $matches[5];

	$claims[] = [$claimID, $left, $top, $width, $height];
}
fclose($f);

foreach ($claims as $claim) {
	list($claimID, $left, $top, $width, $height) = $claim;
	// print_r($claim);

	for ($y = 1; $y <= $top + $height; $y += 1) {
		for ($x = 1; $x <= $left + $width; $x += 1) {
			$value = null;
			if ($y > $top && $y <= $top + $height && $x > $left && $x <= $left + $width) {
				$value = $claimID;
			}

			if (!isset($area[$y][$x])) {
				$area[$y][$x] = $value;
			} else {
				if (!is_null($value)) {
					$overlap["$x, $y"] = null;
				}
			}
		}
	}
}

function printArea(array $area) : void {
	foreach ($area as $y) {
		foreach ($y as $x) {
			echo sprintf('%04d', $x) . "\t";
		}
		echo PHP_EOL;
	}
}
