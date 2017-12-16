#!/usr/bin/env php
<?php
$shortopts = '';
$shortopts .= 'n:';
$options = getopt($shortopts);
if (empty($options['n'])) {
	fwrite(STDERR, sprintf('Usage: %s [-n Number of programs]' . PHP_EOL, $argv[0]));
	exit(1);
}

$f = fopen('php://stdin', 'r');
$sequenceOfDanceMoves = explode(',', trim(fgets($f)));
fclose($f);

$numPrograms = $options['n'];
$programs = implode('', array_map('chr', range(97, 97 + $numPrograms - 1)));

// print_r(compact('sequenceOfDanceMoves', 'programs'));

echo dance($programs, $sequenceOfDanceMoves) . PHP_EOL;

function spin(int $param, string $programs): string
{
	return substr($programs, -$param) . substr($programs, 0, -$param);
}

function exchange(array $params, string $programs): string
{
	$left = $programs[$params[0]];
	$right = $programs[$params[1]];

	$programs[$params[0]] = $right;
	$programs[$params[1]] = $left;

	return $programs;
}

function partner(array $params, string $programs): string
{
	$left = strpos($programs, $params[0]);
	$right = strpos($programs, $params[1]);

	$programs[$left] = $params[1];
	$programs[$right] = $params[0];

	return $programs;
}

function dance(string $programs, array $sequenceOfDanceMoves): string
{
	foreach ($sequenceOfDanceMoves as $danceMove) {
		switch ($danceMove[0]) {
			case 's':
				$param = substr($danceMove, 1);
				$programs = spin($param, $programs);
				break;
			case 'x':
				$params = explode('/', substr($danceMove, 1));
				$programs = exchange($params, $programs);
				break;
			case 'p':
				$params = explode('/', substr($danceMove, 1));
				$programs = partner($params, $programs);
				break;
		}
	}

	return $programs;
}
