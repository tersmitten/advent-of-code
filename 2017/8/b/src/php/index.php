#!/usr/bin/env php
<?php
$instructions = [];
$registers = [];
$registerValues = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/^([a-z]+) ((inc|dec) (-?[\d]+)) (if ([a-z]+) (.*) (-?[\d]+))$/', trim($row), $matches);
	// print_r(compact('row', 'matches'));
	$register = $matches[1];
	$command = $matches[3];
	$commandValue = (int)$matches[4];
	$condition = $matches[5];
	$conditionRegister = $matches[6];
	$conditionOperator = $matches[7];
	$conditionValue = (int)$matches[8];

	$registers[$register] = 0;
	$instructions[] = [$register, $command, $commandValue, $conditionRegister, $conditionOperator, $conditionValue];
}
fclose($f);

// print_r(compact('registers', 'instructions'));

foreach ($instructions as $instruction) {
	list($register, $command, $commandValue, $conditionRegister, $conditionOperator, $conditionValue) = $instruction;
	if (evaluateCondition($registers[$conditionRegister], $conditionOperator, $conditionValue)) {
		$registerValue = executeCommand($registers[$register], $command, $commandValue);
		$registers[$register] = $registerValue;
		$registerValues[] = $registerValue;
	}
}

echo max($registerValues) . PHP_EOL;

function evaluateCondition(int $left, string $operator, int $right) {
	switch($operator) {
		case '==': return $left == $right;
		case '===': return $left === $right;
		case '!=': return $left != $right;
		case '<>': return $left <> $right;
		case '!==': return $left !== $right;
		case '>': return $left > $right;
		case '<': return $left < $right;
		case '>=': return $left >= $right;
		case '<=': return $left <= $right;
	}
}

function executeCommand(int $left, string $command, int $right) {
	switch($command) {
		case 'inc': return $left += $right;
		case 'dec': return $left -= $right;
	}
}
