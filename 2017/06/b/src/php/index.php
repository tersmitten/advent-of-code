#!/usr/bin/env php
<?php
$f = fopen('php://stdin', 'r');
$memoryBanks = array_map('intval', preg_split('/\s+/', trim(fgets($f))));
fclose($f);

$numMemoryBanks = count($memoryBanks);
$numRedistributionCycles = 0;
$reachedStates = [];
$memoryBanksString = json_encode($memoryBanks);

while (true) {
	if (in_array($memoryBanksString, $reachedStates, true)) {
		$firstOccurrenceIndex = array_search($memoryBanksString, $reachedStates);
		break;
	}
	$reachedStates[] = $memoryBanksString;

	$mostBlocks = max($memoryBanks);
	$mostBlocksIndex = array_search($mostBlocks, $memoryBanks);

	$memoryBanks[$mostBlocksIndex] = 0;

	$startI = $mostBlocksIndex + 1;
	$endI = $startI + $mostBlocks;
	for ($i = $startI; $i < $endI; $i += 1) {
		$memoryBanks[$i % $numMemoryBanks] += 1;
	}

	$memoryBanksString = json_encode($memoryBanks);

	$numRedistributionCycles += 1;
}

echo ($numRedistributionCycles - $firstOccurrenceIndex) . PHP_EOL;
