#!/usr/bin/env php
<?php
$instructions = $groupedInstructions = $letters = [];
$sortedLetters = '';

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$instructions[] = trim($line);
}
fclose($f);

foreach ($instructions as $instruction) {
	$letterPair = [];
	preg_match('/^Step ([A-Z]) must be finished before step ([A-Z]) can begin.$/', $instruction, $letterPair);
	$left = $letterPair[1];
	$right = $letterPair[2];

	$groupedInstructions[$left][] = $right;

	$letters[$left] = null;
	$letters[$right] = null;
}

ksort($letters);

while (count($letters) > 0) {
	foreach (array_keys($letters) as $letter) {
		$groupedRights = array_values($groupedInstructions);
		$rights = [];
		if (count($groupedRights) > 0) {
			$rights = array_merge(...$groupedRights);
		}

		if (!in_array($letter, $rights, true)) {
			$sortedLetters .= $letter;
			if (array_key_exists($letter, $groupedInstructions)) {
				unset($groupedInstructions[$letter]);
			}

			break;
		}
	}

	$lastSortedLetter = substr($sortedLetters, -1);
	unset($letters[$lastSortedLetter]);
}

echo $sortedLetters . PHP_EOL;
