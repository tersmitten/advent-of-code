#!/usr/bin/env php
<?php
$claims = $claimed = $overlapping = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $row, $matches);

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

	for ($y = $top; $y < $top + $height; $y += 1) {
		for ($x = $left; $x < $left + $width; $x += 1) {
			$key = "$x,$y";
			if (array_key_exists($key, $claimed)) {
				$overlapping[$key] = null;
			}
			$claimed[$key] = null;
		}
	}
}

echo count($overlapping) . PHP_EOL;
