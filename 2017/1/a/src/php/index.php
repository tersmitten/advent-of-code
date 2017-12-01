#!/usr/bin/env php
<?php
$fileContent = '';

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$fileContent .= trim($line);
}
fclose($f);

$digits = str_split($fileContent, 1);
// print_r($digits);

$sum = 0;
foreach ($digits as $i => $digit) {
	$nextDigit = $digits[$i + 1] ?? $digits[0];

	// print_r(compact('digit', 'nextDigit'));
	if ($digit === $nextDigit) {
		$sum += $digit;
	}
}

echo $sum . "\n";
