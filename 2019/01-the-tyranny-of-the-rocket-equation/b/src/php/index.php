#!/usr/bin/env php
<?php
$fuels = [];
$mass = 0;

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
    $mass = trim($line);
    $fuels[] = getTotalFuelForModule($mass);
}
fclose($f);

echo array_sum($fuels) . PHP_EOL;

/**
 *
 * @param int $mass
 * @return int
 */
function getFuelForModule(int $mass): int {
    return intval(floor($mass / 3) - 2);
}

/**
 *
 * @param int $mass
 * @return int
 */
function getTotalFuelForModule(int $mass): int {
    $fuel = $totalFuel = 0;
    while (true) {
        $fuel = getFuelForModule($mass);
        if ($fuel <= 0) {
            break;
        }
        $totalFuel += $fuel;
        $mass = $fuel;
    }

    return $totalFuel;
}
