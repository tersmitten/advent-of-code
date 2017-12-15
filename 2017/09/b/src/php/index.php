#!/usr/bin/env php
<?php
$f = fopen('php://stdin', 'r');
$streamBlock = trim(fgets($f));
fclose($f);

$streamBlocks = str_split($streamBlock, 1);
$numStreamBlocks = count($streamBlocks);

$numCharactersWithinGarbage = 0;
$numCanceledCharacters = 0;

$garbageOpen = new SplStack();
for ($i = 0; $i < $numStreamBlocks; $i += 1) {
	if ($streamBlocks[$i] === '<' && $garbageOpen->count() === 0) {
		$garbageOpen->push($i);
	}

	if ($streamBlocks[$i] === '!') {
		$streamBlocks[$i] = null;
		$streamBlocks[$i + 1] = null;

		$numCanceledCharacters += 2;
	}

	if ($streamBlocks[$i] === '>' && $garbageOpen->count() > 0) {
		$garbageOpenIndex = $garbageOpen->pop();
		foreach (range($garbageOpenIndex, $i) as $j) {
			$streamBlocks[$j] = null;
		}
		$numCharactersWithinGarbage += ($i - $garbageOpenIndex - 1);
	}

	if ($streamBlocks[$i] === ',') {
		$streamBlocks[$i] = null;
	}
}

$numCharactersWithinGarbage -= $numCanceledCharacters;

echo $numCharactersWithinGarbage . PHP_EOL;
