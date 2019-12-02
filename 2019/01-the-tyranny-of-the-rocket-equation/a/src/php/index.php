#!/usr/bin/env php
<?php
$fuel = $mass = 0;

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
    $mass = trim($line);
    $fuel += getFuelForModule($mass);
}
fclose($f);

echo $fuel . PHP_EOL;

/**
 *
 * @param int $mass
 * @return int
 */
function getFuelForModule(int $mass): int {
    return intval(floor($mass / 3) - 2);
}
