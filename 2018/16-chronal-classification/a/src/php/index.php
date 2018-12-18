#!/usr/bin/env php
<?php
$samples = $formattedSamples = [];
$registers = array_fill(0, 4, 0);

$fileContent  = file_get_contents('php://stdin');

$pattern = '/';
$pattern .= 'Before:\s+\[(\d+),\s+(\d+),\s+(\d+),\s+(\d+)\]\n';
$pattern .= '(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\n';
$pattern .= 'After:\s+\[(\d+),\s+(\d+),\s+(\d+),\s+(\d+)\]\n';
$pattern .= '/sU';

$pregMatchAll = preg_match_all($pattern, $fileContent, $matches);
if ($pregMatchAll === false || $pregMatchAll === 0) {
	fwrite(STDERR, 'No samples found' . PHP_EOL);
	exit(1);
}

assert(addr([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 0]);
assert(addr([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 5]);
assert(addi([0, 0, 0, 0], 0, 7, 3) === [0, 0, 0, 7]);
assert(addi([3, 0, 0, 0], 0, 7, 3) === [3, 0, 0, 10]);

foreach (array_slice($matches, 1) as $i => $match) {
	foreach ($match as $j => $value) {
		$samples[$j][$i] = $value;
	}
}

foreach ($samples as $sample) {
	list($before, $instruction, $after) = array_chunk($sample, 4);
	$formattedSamples[] = compact('before', 'instruction', 'after');
}

print_r(compact('samples', 'formattedSamples', 'registers'));

// Addition

function addr(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] + $registers[$b];

	return $registers;
}

function addi(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] + $b;

	return $registers;
}

// Multiplication

function mulr(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

function muli(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

// Bitwise AND

function banr(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

function bani(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

// Bitwise OR

function borr(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

function bori(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

// Assignment

function setr(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

function seti(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

// Greater-than testing

function gtir(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

function gtri(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

function gtrr(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

// Equality testing

function eqir(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

function eqri(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}

function eqrr(array $registers, int $a, int $b, int $c) : array {
	return $registers;
}
