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
	$remainders = [$values[0] * $factors[0] % $divider, $values[1] * $factors[1] % $divider];
	$values = $remainders;
	$binaries = array_map(function ($v) {
		return substr((string)base_convert($v, 10, 2), -16);
	}, $remainders);

	if ($binaries[0] === $binaries[1]) {
		$numMatches += 1;
	}
}

echo $numMatches . PHP_EOL;
