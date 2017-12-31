#!/usr/bin/env php
<?php
$firewall = $securityScannerPositions = $securityScannerMultipliers = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/^([\d]+):\s+([\d]+)$/', trim($row), $matches);

	$depth = (int)$matches[1];
	$range = (int)$matches[2];

	$firewall[$depth] = $range;
	$securityScannerPositions[$depth] = 0;
	$securityScannerMultipliers[$depth] = 0;
}
fclose($f);

$depths = array_keys($firewall);
$depthStart = min($depths);
$depthEnd = max($depths);

$severity = 0;

foreach (range($depthStart, $depthEnd) as $depth) {
	if (($securityScannerPositions[$depth] ?? null) === 0) {
		$severity += ($depth * $firewall[$depth]);
	}
	foreach ($depths as $depth) {
		if ($securityScannerPositions[$depth] === 0) {
			$securityScannerMultipliers[$depth] = 1;
		} else if ($securityScannerPositions[$depth] === ($firewall[$depth] - 1)) {
			$securityScannerMultipliers[$depth] = -1;
		}
		$securityScannerPositions[$depth] += (1 * $securityScannerMultipliers[$depth]);
	}
}

echo $severity . PHP_EOL;
