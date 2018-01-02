#!/usr/bin/env php
<?php
$firewall = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/^([\d]+):\s+([\d]+)$/', trim($row), $matches);

	$layer = $matches[1];
	$depth = $matches[2];

	$firewall[$layer] = $depth;
}
fclose($f);

$severity = 0;
foreach ($firewall as $layer => $depth) {
	if ($layer % (($depth - 1) * 2) === 0) {
		$severity += $layer * $depth;
	}
}

echo $severity . PHP_EOL;
