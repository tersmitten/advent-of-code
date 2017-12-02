#!/usr/bin/env php
<?php
$spreadsheet = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	$spreadsheet[] = preg_split('/\s+/', trim($row));
}
fclose($f);

$sum = 0;
foreach ($spreadsheet as $row) {
	rsort($row, SORT_NUMERIC);
	foreach ($row as $i => $number) {
		$j = 1;
		while (isset($row[$i + $j])) {
			$nextNumber = $row[$i + $j];
			if ($number % $nextNumber === 0) {
				$sum += $number / $nextNumber;
			}
			$j += 1;
		}
	}
}

echo $sum . "\n";
