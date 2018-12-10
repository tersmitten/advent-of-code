#!/usr/bin/env php
<?php
$f = fopen('php://stdin', 'r');
$unparsedTree = array_map('intval', preg_split('/\s+/', trim(fgets($f))));
fclose($f);

function parseTree(array $unparsedTree, int $sumOfMetadataEntries) : array {
	$quantityOfChildNodes = $unparsedTree[0];
	$quantityOfMetadataEntries = $unparsedTree[1];
	$unparsedTree = array_slice($unparsedTree, 2);

	$childNodes = [];
	for ($i = 0; $i < $quantityOfChildNodes; $i += 1) {
		list($childNode, $unparsedTree, $sumOfMetadataEntries) = parseTree($unparsedTree, $sumOfMetadataEntries);
		$childNodes[] = $childNode;
	}

	$metadataEntries = array_slice($unparsedTree, 0, $quantityOfMetadataEntries);
	$sumOfMetadataEntries += array_sum($metadataEntries);
	$unparsedTree = array_slice($unparsedTree, $quantityOfMetadataEntries);

	$node = [[$quantityOfChildNodes, $quantityOfMetadataEntries], $childNodes, $metadataEntries];

	return [$node, $unparsedTree, $sumOfMetadataEntries];
}

list($parsedTree, $unparsedTree, $sumOfMetadataEntries) = parseTree($unparsedTree, 0);
echo $sumOfMetadataEntries . PHP_EOL;
