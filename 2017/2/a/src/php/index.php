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
	$sum += max($row) - min($row);
}

echo $sum . PHP_EOL;
