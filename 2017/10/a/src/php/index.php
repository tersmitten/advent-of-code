#!/usr/bin/env php
<?php
$shortopts = '';
$shortopts .= 'n:';
$options = getopt($shortopts);
if (empty($options['n'])) {
	fwrite(STDERR, sprintf('Usage: %s [-n Number of elements]' . PHP_EOL, $argv[0]));
	exit(1);
}

$f = fopen('php://stdin', 'r');
$sequenceOfLengths = preg_split('/,\s?/', trim(fgets($f)));
fclose($f);

$numberOfElements = $options['n'];
$numberOfLengths = count($sequenceOfLengths);
$listOfNumbers = range(0, $numberOfElements - 1);
$currentPosition = 0;
$skipSize = 0;

for ($i = 0; $i < $numberOfLengths; $i += 1) {
	$currentLength = $sequenceOfLengths[$i];
	$endPosition = $currentPosition + $currentLength;

	$reversedSublist = [];
	for ($j = $currentPosition; $j < $endPosition; $j += 1) {
		array_push($reversedSublist, $listOfNumbers[$j % $numberOfElements]);
	}
	// print_r(array_reverse($reversedSublist));
	for ($j = $currentPosition; $j < $endPosition; $j += 1) {
		$listOfNumbers[$j % $numberOfElements] = array_pop($reversedSublist);
	}

	$currentPosition += $currentLength + $skipSize;
	$skipSize += 1;

	// print_r(compact('i', 'currentLength', 'listOfNumbers', 'currentPosition', 'skipSize'));
}

echo $listOfNumbers[0] * $listOfNumbers[1] . PHP_EOL;
