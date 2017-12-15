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

$tower = buildTower(formatDiscs($discs));
// echo formatTower($tower) . PHP_EOL;
echo $tower[0]['name'] . PHP_EOL;

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

function formatTower(array $tower): string
{
	return json_encode($tower, JSON_PRETTY_PRINT);
}
