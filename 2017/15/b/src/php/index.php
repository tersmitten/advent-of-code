#!/usr/bin/env php
<?php
$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/([\d]+)$/', $row, $matches);
	$startingValues[] = $matches[0];
}
fclose($f);

$factors = [16807, 48271];
$divider = 2147483647;
$values = $startingValues;
$numMatches = $i = 0;
$numPairsToConsider = 5 * 10 ** 6;

while ($i <= $numPairsToConsider) {
	while (true) {
		$values[0] = calculateRemainder($values[0], $factors[0], $divider);
		if ($values[0] % 4 === 0) {
			break;
		}
	}

	while (true) {
		$values[1] = calculateRemainder($values[1], $factors[1], $divider);
		if ($values[1] % 8 === 0) {
			break;
		}
	}

	$i += 1;
	if (getLowest16Bits($values[0]) === getLowest16Bits($values[1])) {
		$numMatches += 1;
	}
}

echo $numMatches . PHP_EOL;

function calculateRemainder(int $value, int $factor, int $divider): int
{
	return $value * $factor % $divider;
}

function getLowest16Bits(int $remainder): int
{
	return $remainder & 0xFFFF;
}
