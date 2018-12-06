#!/usr/bin/env php
<?php
$f = fopen('php://stdin', 'r');
$wantedSquareData = (int)trim(fgets($f));
fclose($f);

$x = $y = $i = 0;
$delta = [0, -1];
$width = $height = ceil(sqrt($wantedSquareData) / 10) * 10;
$j = pow(max([$width, $height]), 2);
for (; $j > 0; $j -= 1) {
	if ((-1 * $width / 2 < $x && $x <= $width / 2) && (-1 * $height / 2 < $y && $y <= $height / 2)) {
		$i += 1;
		if ($i === $wantedSquareData) {
			echo manhattanDistance([0, 0], [$x, $y]) . PHP_EOL;
		}
	}

	if ($x === $y || ($x < 0 && $x === -1 * $y) || ($x > 0 && $x === 1 - $y)) {
		$delta = [-1 * $delta[1], $delta[0]];
	}

	$x += $delta[0];
	$y += $delta[1];
}

function manhattanDistance(array $a, array $b): float
{
	if (count($a) !== count($b)) {
		throw new InvalidArgumentException('Array sizes do not match');
	}

	return array_sum(array_map(function ($m, $n) {
		return abs($m - $n);
	}, $a, $b));
}
