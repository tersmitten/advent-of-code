#!/usr/bin/env php
<?php
$resultingFrequency = 0;
$frequencyChanges = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$frequencyChanges[] = trim($line);
}
fclose($f);

foreach ($frequencyChanges as $frequencyChange) {
	$resultingFrequency += $frequencyChange;
}

echo $resultingFrequency . PHP_EOL;
