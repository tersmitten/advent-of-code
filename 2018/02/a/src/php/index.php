#!/usr/bin/env php
<?php
$boxIDs = $checksum = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$boxIDs[] = str_split(trim($line), 1);
}
fclose($f);

foreach ($boxIDs as $boxID) {
	$valueCounts = array_unique(array_count_values($boxID));
	$boxID = implode('', $boxID);
	foreach ($valueCounts as $value => $count) {
		if (in_array($count, [2, 3], true)) {
			$checksum[] = $count;
		}
	}
}

echo array_product(array_count_values($checksum)) . PHP_EOL;
