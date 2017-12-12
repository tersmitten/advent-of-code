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

$sum = 0;
foreach ($digits as $i => $digit) {
	$j = ($i + 1) % $numDigits;

	$nextDigit = $digits[$j];
	if ($digit === $nextDigit) {
		$sum += $digit;
	}
}

echo $sum . PHP_EOL;
