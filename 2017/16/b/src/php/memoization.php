#!/usr/bin/env php
<?php
$memoize = function($func)
{
	return function() use ($func)
	{
		static $cache = [];

		$args = func_get_args();
		$key = hash('fnv1a64', igbinary_serialize($args));
		if (!isset($cache[$key])) {
			$cache[$key] = call_user_func_array($func, $args);
		}

		return $cache[$key];
	};
};

$memoizedDance = $memoize(function(string $programs, array $sequenceOfDanceMoves): string
{
	return dance($programs, $sequenceOfDanceMoves);
});

$shortopts = '';
$shortopts .= 'n:';
$shortopts .= 'd:';
$options = getopt($shortopts);
if (empty($options['n']) || empty($options['d'])) {
	fwrite(STDERR, sprintf('Usage: %s [-n Number of programs] [-d Number of dances]' . PHP_EOL, $argv[0]));
	exit(1);
}

$f = fopen('php://stdin', 'r');
$sequenceOfDanceMoves = explode(',', trim(fgets($f)));
fclose($f);

$numPrograms = $options['n'];
$aDecimal = 97;
$programs = $originalPrograms = implode('', array_map('chr', range($aDecimal, $aDecimal + $numPrograms - 1)));
$numDances = $options['d'];

// print_r(compact('sequenceOfDanceMoves', 'programs'));

for ($i = 1; $i <= $numDances; $i += 1) {
	$programs = $memoizedDance($programs, $sequenceOfDanceMoves);
	if ($programs === $originalPrograms) {
		echo $i . PHP_EOL;
	}
}
echo $programs . PHP_EOL;

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
