#!/usr/bin/env php
<?php
$boxIDs = $relevantCharacterCounts = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$boxIDs[] = str_split(trim($line), 1);
}
fclose($f);

foreach ($boxIDs as $boxID) {
	// Count unique characters
	$characterCounts = array_count_values($boxID);
	// Find unique character counts
	$uniqueCharacterCounts= array_unique($characterCounts);
	// Find relevant character counts
	foreach ($uniqueCharacterCounts as $characterCount) {
		if (in_array($characterCount, [2, 3], true)) {
			$relevantCharacterCounts[] = $characterCount;
		}
	}
}

// Group counts (e.g. the number of times a boxId contained a character two or three times)
$groupedCharacterCounts = array_count_values($relevantCharacterCounts);
// Multiply counts (4 times exactly twice x 4 times exactly three times)
$checksum = array_product($groupedCharacterCounts);

echo $checksum . PHP_EOL;
