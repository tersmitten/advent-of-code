#!/usr/bin/env php
<?php
$firewall = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/^([\d]+):\s+([\d]+)$/', trim($row), $matches);

	$depth = (int)$matches[1];
	$range = (int)$matches[2];

	$firewall[$depth] = $range;
}
fclose($f);

$severity = 0;
foreach ($firewall as $depth => $range) {
	if ($depth % (($range - 1) * 2) === 0) {
		$severity += ($depth * $range);
	}
}

echo $severity . PHP_EOL;
