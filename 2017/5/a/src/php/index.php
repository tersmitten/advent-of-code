#!/usr/bin/env php
<?php
$listOfJumpOffsets = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	$listOfJumpOffsets[] = trim($row);
}
fclose($f);

$previousIndex = $currentIndex = $numberOfSteps = 0;
while (isset($listOfJumpOffsets[$currentIndex])) {
	$previousIndex = $currentIndex;
	$currentIndex += $listOfJumpOffsets[$currentIndex];
	$listOfJumpOffsets[$previousIndex] += 1;
	$numberOfSteps += 1;
}

echo $numberOfSteps . PHP_EOL;
