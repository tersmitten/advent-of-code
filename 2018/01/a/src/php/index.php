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
	eval(sprintf('$resultingFrequency = %s %s;', $resultingFrequency, $frequencyChange));
}

echo $resultingFrequency . PHP_EOL;
