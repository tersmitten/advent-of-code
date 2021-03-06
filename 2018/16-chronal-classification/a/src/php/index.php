#!/usr/bin/env php
<?php
$samples = [];
$opcodes = get_defined_functions()['user'];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$lines[] = trim($line);
}
fclose($f);

foreach ($lines as $line) {
	if (empty($line)) {
		continue;
	}

	if (preg_match('/^Before: \[(\d+), (\d+), (\d+), (\d+)\]$/', $line, $matches) > 0) {
		$before = array_map('intval', array_slice($matches, 1, 4));
	}

	if (preg_match('/^(\d+) (\d+) (\d+) (\d+)$/', $line, $matches) > 0) {
		$instruction = array_map('intval', array_slice($matches, 1, 4));
	}

	if (preg_match('/^After:  \[(\d+), (\d+), (\d+), (\d+)\]$/', $line, $matches) > 0) {
		$after = array_map('intval', array_slice($matches, 1, 4));

		$samples[] = compact('before', 'instruction', 'after');
	}
}
// Addition

assert(addr([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 0]);
assert(addr([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 5]);
assert(addi([0, 0, 0, 0], 0, 7, 3) === [0, 0, 0, 7]);
assert(addi([3, 0, 0, 0], 0, 7, 3) === [3, 0, 0, 10]);

// Multiplication

assert(mulr([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 0]);
assert(mulr([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 6]);
assert(muli([0, 0, 0, 0], 0, 7, 3) === [0, 0, 0, 0]);
assert(muli([3, 0, 0, 0], 0, 7, 3) === [3, 0, 0, 21]);

// Bitwise AND

assert(banr([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 0]);
assert(banr([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 2]);
assert(bani([0, 0, 0, 0], 0, 7, 3) === [0, 0, 0, 0]);
assert(bani([3, 0, 0, 0], 0, 7, 3) === [3, 0, 0, 3]);

// Bitwise OR

assert(borr([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 0]);
assert(borr([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 3]);
assert(bori([0, 0, 0, 0], 0, 7, 3) === [0, 0, 0, 7]);
assert(bori([3, 0, 0, 0], 0, 7, 3) === [3, 0, 0, 7]);

// Assignment

assert(setr([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 0]);
assert(setr([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 2]);
assert(seti([0, 0, 0, 0], 0, 7, 3) === [0, 0, 0, 0]);
assert(seti([3, 0, 0, 0], 0, 7, 3) === [3, 0, 0, 0]);

// Greater-than testing

assert(gtir([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 1]);
assert(gtir([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 0]);
assert(gtri([0, 0, 0, 0], 0, 7, 3) === [0, 0, 0, 0]);
assert(gtri([3, 0, 0, 0], 0, 7, 3) === [3, 0, 0, 0]);
assert(gtrr([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 0]);
assert(gtrr([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 0]);

// Equality testing

assert(eqir([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 0]);
assert(eqir([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 0]);
assert(eqri([0, 0, 0, 0], 0, 7, 3) === [0, 0, 0, 0]);
assert(eqri([3, 0, 0, 0], 0, 7, 3) === [3, 0, 0, 0]);
assert(eqrr([0, 0, 0, 0], 1, 2, 3) === [0, 0, 0, 1]);
assert(eqrr([1, 2, 3, 4], 1, 2, 3) === [1, 2, 3, 0]);

// Example
assert(mulr([3, 2, 1, 1], 2, 1, 2) === [3, 2, 2, 1]);
assert(addi([3, 2, 1, 1], 2, 1, 2) === [3, 2, 2, 1]);
assert(seti([3, 2, 1, 1], 2, 1, 2) === [3, 2, 2, 1]);

$sampleThatBehavesLikeXOpcodes = array_fill(0, count($samples), 0);

// print_r(compact('samples', 'registers', 'opcodes', 'sampleThatBehavesLikeXOpcodes'));

foreach ($samples as $i => $sample) {
	$expected = $sample['after'];
	[$opcode, $a, $b, $c] = $sample['instruction'];
	// print_r(compact('formattedSample'));

	foreach ($opcodes as $opcodeName) {
		$actual = $opcodeName($sample['before'], $a, $b, $c);
		$same = $actual == $expected;
		// print_r(compact('opcodeName', 'a', 'b', 'c', 'expected', 'actual', 'same'));
		if ($same) {
			$sampleThatBehavesLikeXOpcodes[$i] += 1;
		}
	}
}

// print_r(compact('sampleThatBehavesLikeXOpcodes'));

$sampleThatBehavesLikeThreeOrMoreOpcodes = array_filter($sampleThatBehavesLikeXOpcodes, function(int $v) : bool {
    return $v >= 3;
});
echo count($sampleThatBehavesLikeThreeOrMoreOpcodes) . PHP_EOL;

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
	$registers[$c] = $registers[$a] * $registers[$b];

	return $registers;
}

function muli(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] * $b;

	return $registers;
}

// Bitwise AND

function banr(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] & $registers[$b];

	return $registers;
}

function bani(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] & $b;

	return $registers;
}

// Bitwise OR

function borr(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] | $registers[$b];

	return $registers;
}

function bori(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] | $b;

	return $registers;
}

// Assignment

function setr(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a];

	return $registers;
}

function seti(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $a;

	return $registers;
}

// Greater-than testing

function gtir(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $a > $registers[$b] ? 1 : 0;

	return $registers;
}

function gtri(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] > $b ? 1 : 0;

	return $registers;
}

function gtrr(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] > $registers[$b] ? 1 : 0;

	return $registers;
}

// Equality testing

function eqir(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $a === $registers[$b] ? 1 : 0;

	return $registers;
}

function eqri(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] === $b ? 1 : 0;

	return $registers;
}

function eqrr(array $registers, int $a, int $b, int $c) : array {
	$registers[$c] = $registers[$a] === $registers[$b] ? 1 : 0;

	return $registers;
}
