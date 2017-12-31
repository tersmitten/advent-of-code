#!/usr/bin/env php
<?php
$programs = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/^([\d]+) <-> (.*)$/', trim($row), $matches);

	$id = $matches[1];
	$ids = preg_split('/,\s?/', $matches[2]);

	$programs[$id] = $ids;
}
fclose($f);

$groupWalk = walkThroughVillage(0, [], $programs);
echo count($groupWalk) . PHP_EOL;

function walkThroughVillage(int $groupId, array $group, array $programs): array
{
	$group[] = $groupId;
	foreach ($programs[$groupId] as $id) {
		if (!in_array($id, $group)) {
			$group = array_unique(array_merge($group, walkThroughVillage($id, $group, $programs)));
		}
	}

	return $group;
}
