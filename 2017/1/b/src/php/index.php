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
// print_r(compact('digits', 'numDigits', 'stepsForward'));

$sum = 0;
foreach ($digits as $i => $digit) {
	$index = $i + $stepsForward;
	$fallbackIndex = $i - $stepsForward;
	$nextDigit = $digits[$index] ?? $digits[$fallbackIndex];
	$sameDigits = $digit === $nextDigit;

	// print_r(compact('i', 'index', 'fallbackIndex', 'digit', 'nextDigit', 'sameDigits'));
	if ($sameDigits) {
		$sum += $digit;
	}
}

echo $sum . "\n";
