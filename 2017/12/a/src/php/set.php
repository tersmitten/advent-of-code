#!/usr/bin/env php
<?php
$programs = [];
$group0Walk = new \Ds\Set();

$f = fopen('php://stdin', 'r');
while ($row = fgets($f)) {
	preg_match('/^([\d]+) <-> (.*)$/', trim($row), $matches);

	$id = (int)$matches[1];
	$ids = array_map('intval', preg_split('/,\s?/', $matches[2]));

	$programs[$id] = $ids;
}
fclose($f);

walkThroughVillage(0, $group0Walk, $programs);

echo $group0Walk->count(). PHP_EOL;

function walkThroughVillage(int $groupId, \Ds\Set $group, array $programs): \Ds\Set
{
	$group->add($groupId);
	foreach ($programs[$groupId] as $id) {
		if (!$group->contains($id)) {
			$group = walkThroughVillage($id, $group, $programs);
		}
	}

	return $group;
}
