#!/usr/bin/env php
<?php
$f = fopen('php://stdin', 'r');
$path = array_filter(preg_split('/,\s?/', trim(fgets($f))));
fclose($f);

$startAt = $position = [0, 0];
$numberOfStepsAway = [];

foreach ($path as $i => $move) {
	$position = move($position, $move);
	$numberOfStepsAway[] = distance($startAt, $position);
}

echo max($numberOfStepsAway) . PHP_EOL;

function move(array $position, string $move, int $times = 1): array {
	list($x, $y) = $position;

	switch ($move) {
		case 'n':
			return [$x, $y - (1 * $times)];
		case 'ne':
			return [$x + (1 * $times), $y - (1 * $times)];
		case 'se':
			return [$x + (1 * $times), $y];
		case 's':
			return [$x, $y + (1 * $times)];
		case 'sw':
			return [$x - (1 * $times), $y + (1 * $times)];
		case 'nw':
			return [$x - (1 * $times), $y];
	}
}

function formatPosition (array $position): string
{
	list($x, $y) = $position;

	return sprintf('%d, %d', $x, $y);
}

function distance(array $a, array $b) {
	list($aX, $aY) = $a;
	list($bX, $bY) = $b;

	return max(abs($aX - $bX), abs($aY - $bY));
}
