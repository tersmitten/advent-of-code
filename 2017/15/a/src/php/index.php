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
$numMatches = 0;
$numPairsToConsider = 40 * 10 ** 6;
// $numPairsToConsider = 5;

for ($i = 1; $i <= $numPairsToConsider; $i += 1) {
	$values = [
		calculateRemainder($values[0], $factors[0], $divider),
		calculateRemainder($values[1], $factors[1], $divider)
	];
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
