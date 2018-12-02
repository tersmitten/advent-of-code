#!/usr/bin/env php
<?php
$boxIDs = $pairs = $commonLettersPerPair = [];

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

foreach ($pairs as $key => $pair) {
	list($firstBoxID, $secondBoxID) = $pair;

	$splittedFirstBoxID = str_split($firstBoxID, 1);
	$splittedSecondBoxID = str_split($secondBoxID, 1);

	$commonLetters = '';
	foreach ($splittedFirstBoxID as $key => $value) {
		if ($value === $splittedSecondBoxID[$key]) {
			$commonLetters .= $value;
		}
	}
	$commonLettersPerPair[] = $commonLetters;
}

usort($commonLettersPerPair, function($a, $b) {
	return strlen($b) - strlen($a);
});

echo $commonLettersPerPair[0] . PHP_EOL;
