#!/usr/bin/env php
<?php
$discs = $tower = [];
$parent = null;

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/([a-z]+) \(([\d]+)\)( \-\> (.*))?/', $row, $matches);
	// print_r($matches);
	$name = $matches[1];
	$weight = $matches[2];
	$children = array_filter(explode(', ', ($matches[4] ?? '')));

	$discs[$name] = compact('name', 'weight', 'parent', 'children');
}
fclose($f);

$formattedDiscs = formatDiscs($discs);
$tower = buildTower($formattedDiscs);
printFaultyWeight($tower[0]);

function formatDiscs(array $discs): array
{
	foreach ($discs as $k => $v) {
		foreach ($v['children'] as $vChild) {
			$discs[$vChild]['parent'] = $k;
		}
		unset($discs[$k]['children']);
	}

	return $discs;
}

function buildTower(array $discs, string $parent = null): array
{
	$branch = [];
	foreach ($discs as $disc) {
		if ($disc['parent'] === $parent) {
			$disc['children'] = buildTower($discs, $disc['name']);
			$branch[] = $disc;
		}
	}

	return $branch;
}

function printFaultyWeight(array $tower)
{
	$weightChildren = $weightChildrenCumulative = [];

	$numChildren = count($tower['children']);
	for ($i = 0; $i < $numChildren; $i += 1) {
		$tower['children'][$i] = printFaultyWeight($tower['children'][$i]);

		$subTower = $tower['children'][$i];
		$weightChildren[$subTower['name']] = $subTower['weight'];
		$weightChildrenCumulative[$subTower['name']] = $subTower['weightChildrenCumulativeSum'] ?? 0;
	}

	arsort($weightChildrenCumulative, SORT_NUMERIC);
	$weightChildrenCumulativeSum = $tower['weight'] + array_sum($weightChildrenCumulative);
	$weightChildrenCumulativeSumFaulty = count(array_count_values($weightChildrenCumulative)) > 1;

	$tower['weightChildrenCumulativeSum'] = $weightChildrenCumulativeSum;

	if ($weightChildrenCumulativeSumFaulty) {
		$weightChildrenCumulativeDelta = current($weightChildrenCumulative) - end($weightChildrenCumulative);

		reset($weightChildrenCumulative);
		$nameOfFaultyDisc = key($weightChildrenCumulative);
		echo ($weightChildren[$nameOfFaultyDisc] - $weightChildrenCumulativeDelta) . PHP_EOL;
		exit;
	}

	return $tower;
}
