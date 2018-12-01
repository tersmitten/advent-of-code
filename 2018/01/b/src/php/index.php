#!/usr/bin/env php
<?php
$resultingFrequency = 0;
$frequencyChanges = $seenFrequencies = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$frequencyChanges[] = trim($line);
}
fclose($f);

$seenFrequencies[] = $resultingFrequency;
while (true) {
	foreach ($frequencyChanges as $frequencyChange) {
		eval(sprintf('$resultingFrequency = %s %s;', $resultingFrequency, $frequencyChange));

		if (in_array($resultingFrequency, $seenFrequencies, true)) {
			echo $resultingFrequency . PHP_EOL;
			exit;
		}

		$seenFrequencies[] = $resultingFrequency;
	}
}
