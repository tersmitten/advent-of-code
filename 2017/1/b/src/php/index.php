#!/usr/bin/env php
<?php
$fileContent = '';

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$fileContent .= trim($line);
}
fclose($f);

$digits = str_split($fileContent, 1);
$numDigits = count($digits);
$stepsForward = $numDigits / 2;

$sum = 0;
foreach ($digits as $i => $digit) {
	$j = ($i + $stepsForward) % $numDigits;
	$nextDigit = $digits[$j];

	if ($digit === $nextDigit) {
		$sum += $digit;
	}
}

echo $sum . "\n";
