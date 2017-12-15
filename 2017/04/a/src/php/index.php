#!/usr/bin/env php
<?php
$passphraseList = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	$passphraseList[] = preg_split('/\s+/', trim($row));
}
fclose($f);

$sum = 0;
foreach ($passphraseList as $row) {
	$wordCounts = array_count_values($row);
	if (max($wordCounts) === 1) {
		$sum += 1;
	}
}

echo $sum . PHP_EOL;
