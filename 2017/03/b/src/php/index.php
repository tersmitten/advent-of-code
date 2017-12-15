#!/usr/bin/env php
<?php
$f = fopen('php://stdin', 'r');
$wantedSquareData = (int)trim(fgets($f));
fclose($f);

$x = $y = $i = 0;
$delta = [0, -1];
$width = $height = 10;
$matrix = [];
$j = pow(max([$width, $height]), 2);
for (; $j > 0; $j -= 1) {
	if ((-1 * $width / 2 < $x && $x <= $width / 2) && (-1 * $height / 2 < $y && $y <= $height / 2)) {
		$i += 1;

		$adjacentSquares = getAdjacentSquares($x, $y);
		$sum = sumAdjacentSquares($matrix, $adjacentSquares) ?: 1;
		$matrix[$x][$y] = $sum;

		if ($sum > $wantedSquareData) {
			echo $sum . PHP_EOL;
			// echo formatMatrix(sortMatrix($matrix)) . PHP_EOL;
			exit;
		}
	}

	if ($x === $y || ($x < 0 && $x === -1 * $y) || ($x > 0 && $x === 1 - $y)) {
		$delta = [-1 * $delta[1], $delta[0]];
	}

	$x += $delta[0];
	$y += $delta[1];
}

function getAdjacentSquares(int $x, int $y): array
{
	$xPlusOne = $x + 1;
	$xMinOne = $x - 1;
	$yPlusOne = $y + 1;
	$yMinOne = $y - 1;

	return [
		// topLeft
		[$xMinOne, $yMinOne],
		// top
		[$x, $yMinOne],
		// topRight
		[$xPlusOne, $yMinOne],
		// midLeft
		[$xMinOne, $y],
		// midRight
		[$xPlusOne, $y],
		// botLeft
		[$xMinOne, $yPlusOne],
		// bot
		[$x, $yPlusOne],
		// botRight
		[$xPlusOne, $yPlusOne],
	];
}

function sumAdjacentSquares(array $matrix, array $adjacentSquares): int
{
	$sum = 0;
	foreach ($adjacentSquares as $adjacentSquare) {
		list($x, $y) = $adjacentSquare;
		$sum += $matrix[$x][$y] ?? 0;
	}

	return $sum;
}

function sortMatrix(array $matrix): array
{
	foreach ($matrix as &$v) {
		ksort($v, SORT_NUMERIC);
	}
	ksort($matrix, SORT_NUMERIC);

	return $matrix;
}

function formatMatrix(array $matrix): string
{
	return json_encode($matrix, JSON_PRETTY_PRINT);
}
