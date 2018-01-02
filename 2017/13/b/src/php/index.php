#!/usr/bin/env php
<?php
$firewall = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/^([\d]+):\s+([\d]+)$/', trim($row), $matches);

	$depth = $matches[1];
	$range = $matches[2];

	$firewall[$depth] = $range;
}
fclose($f);

$delay = 0;
while (true) {
	$caught = false;
	foreach ($firewall as $depth => $range) {
		if (($depth + $delay) % (($range - 1) * 2) === 0) {
			$caught = true;
			$delay += 1;

			break;
		}
	}

	if (!$caught) {
		break;
	}
}

echo $delay . PHP_EOL;
