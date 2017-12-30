#!/usr/bin/env php
<?php
$programs = $group0Walk = [];

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/^([\d]+) <-> (.*)$/', trim($row), $matches);

	$id = (int)$matches[1];
	$ids = array_map('intval', preg_split('/,\s?/', $matches[2]));

	$programs[$id] = $ids;
}
fclose($f);

walkThroughVillage(0, $group0Walk, $programs);

echo count($group0Walk) . PHP_EOL;

function walkThroughVillage(int $groupId, array &$group, array $programs): void
{
	$group[] = $groupId;
	foreach ($programs[$groupId] as $id) {
		if (!in_array($id, $group, true)) {
			walkThroughVillage($id, $group, $programs);
		}
	}
}
