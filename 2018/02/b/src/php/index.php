#!/usr/bin/env php
<?php
$boxIDs = $pairs = $commonLetters = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$boxIDs[] = trim($line);
}
fclose($f);

foreach ($boxIDs as $firstBoxID) {
	foreach ($boxIDs as $secondBoxID) {
		if (hash_equals($firstBoxID, $secondBoxID)) {
			continue;
		}

		$key1 = "$firstBoxID-$secondBoxID";
		$key2 = "$secondBoxID-$firstBoxID";
		if (array_key_exists($key1, $pairs) || array_key_exists($key2, $pairs)) {
			continue;
		}

		$pairs["$firstBoxID-$secondBoxID"] = [$firstBoxID, $secondBoxID];
	}
}

foreach ($pairs as $pair) {
	list($firstBoxID, $secondBoxID) = $pair;
	// var_dump($pair);

	$splittedFirstBoxID = str_split($firstBoxID, 1);
	$splittedSecondBoxID = str_split($secondBoxID, 1);
	$commonLetters = [];
	foreach ($splittedFirstBoxID as $key => $value) {
		if ($value === $splittedSecondBoxID[$key]) {
			echo $value;
		}
	}
	echo PHP_EOL;
}
