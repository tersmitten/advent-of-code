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
$sequenceOfLengths = array_filter(preg_split('/,\s?/', stringOfBytes(trim(fgets($f)))));
$sequenceOfLengths = array_merge($sequenceOfLengths, [17, 31, 73, 47, 23]);
fclose($f);

echo knotHash($options['n'], $sequenceOfLengths) . PHP_EOL;

function stringOfBytes(string $sequenceOfLengths): string
{
	return implode(',', array_map('ord', str_split($sequenceOfLengths, 1)));
}

function xorBlock(array $block): int
{
	return array_reduce($block, function ($carry, $value) {
		$carry ^= $value;
		return $carry;
	}, 0);
}

function xorBlocks(array $blocks): array
{
	return array_map('xorBlock', $blocks);
}

function formatXoredBlocks(array $xoredBlocks): string {
	return implode('', array_map(function ($xoredBlock) {
		return sprintf('%02x', $xoredBlock);
	}, $xoredBlocks));
}

function toSparseHash(int $numberOfElements, array $sequenceOfLengths, $numberOfRounds = 64): array
{
	$numberOfLengths = count($sequenceOfLengths);
	$listOfNumbers = range(0, $numberOfElements - 1);
	$currentPosition = 0;
	$skipSize = 0;

	for ($i = 0; $i < $numberOfRounds; $i += 1) {
		for ($j = 0; $j < $numberOfLengths; $j += 1) {
			$currentLength = $sequenceOfLengths[$j];
			$endPosition = $currentPosition + $currentLength;

			$reversedSublist = [];
			for ($k = $currentPosition; $k < $endPosition; $k += 1) {
				array_push($reversedSublist, $listOfNumbers[$k % $numberOfElements]);
			}
			for ($k = $currentPosition; $k < $endPosition; $k += 1) {
				$listOfNumbers[$k % $numberOfElements] = array_pop($reversedSublist);
			}

			$currentPosition += $currentLength + $skipSize;
			$skipSize += 1;
		}
	}

	return $listOfNumbers;
}

function knotHash(int $numberOfElements, array $sequenceOfLengths, $numberOfRounds = 64): string
{
	$sparseHash = toSparseHash($numberOfElements, $sequenceOfLengths, $numberOfRounds);
	$blocks = array_chunk($sparseHash, 16);
	$xoredBlocks = xorBlocks($blocks);

	return formatXoredBlocks($xoredBlocks);
}
