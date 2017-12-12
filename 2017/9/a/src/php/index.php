#!/usr/bin/env php
<?php
$f = fopen('php://stdin', 'r');
$streamBlock = trim(fgets($f));
fclose($f);

$streamBlocks = str_split($streamBlock, 1);
$numStreamBlocks = count($streamBlocks);

$garbageOpen = new SplStack();
for ($i = 0; $i < $numStreamBlocks; $i += 1) {
	if ($streamBlocks[$i] === '<' && $garbageOpen->count() === 0) {
		$garbageOpen->push($i);
	}

	if ($streamBlocks[$i] === '!') {
		$streamBlocks[$i] = null;
		$streamBlocks[$i + 1] = null;
	}

	if ($streamBlocks[$i] === '>' && $garbageOpen->count() > 0) {
		$garbageOpenIndex = $garbageOpen->pop();
		foreach (range($garbageOpenIndex, $i) as $j) {
			$streamBlocks[$j] = null;
		}
	}

	if ($streamBlocks[$i] === ',') {
		$streamBlocks[$i] = null;
	}
}

$groupOpen = [];
$groupNesting = 0;
foreach (array_filter($streamBlocks) as $k => $v) {
	if ($v === '{') {
		$groupNesting += 1;
		$groupOpen[] = $groupNesting;
	}
	if ($v === '}') {
		$groupNesting -= 1;
	}
}

echo array_sum($groupOpen) . PHP_EOL;
