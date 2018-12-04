#!/usr/bin/env php
<?php
$lines = $asleepMinutes = $timesMostSpendSleeping = $minutesMostSpendSleeping = [];

$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
	$lines[] = trim($line);
}
fclose($f);

sort($lines);

// print_r($lines);

foreach ($lines as $line) {
	if (preg_match('/^\[(.*)\] Guard #(\d+) begins shift$/', $line, $matches) > 0) {
		$shifStart = $matches[1];
		$shifStartTimestamp = strtotime($shifStart);
		$guard = $matches[2];

		continue;
	}

	if (preg_match('/^\[(.*)\] falls asleep$/', $line, $matches) > 0) {
		$fallsAsleep = $matches[1];
		$fallsAsleepTimestamp = strtotime($fallsAsleep);

		continue;
	}

	if (preg_match('/^\[(.*)\] wakes up$/', $line, $matches) > 0) {
		$wakesUp = $matches[1];
		$wakesUpTimestamp = strtotime($wakesUp);

		// print_r([$fallsAsleep, $wakesUp, date('i', $fallsAsleepTimestamp)]);

		for ($timestamp = $fallsAsleepTimestamp; $timestamp < $wakesUpTimestamp; $timestamp += 60) {
			$minute = date('i', $timestamp);
			if (!isset($asleepMinutes[$guard][$minute])) {
				$asleepMinutes[$guard][$minute] = 0;
			}
			$asleepMinutes[$guard][$minute] += 1;
		}

		continue;
	}
}

// print_r(compact('asleepMinutes'));

foreach ($asleepMinutes as $guard => $asleepMinute) {
	$times = max($asleepMinute);
	$minute = array_search($times, $asleepMinute);
	// print_r(compact('guard', 'times', 'minute'));

	$timesMostSpendSleeping[$guard] = $times;
	$minutesMostSpendSleeping[$guard] = $minute;
}

$guardThatIsMostFrequentlyAsleep = array_search(max($timesMostSpendSleeping), $timesMostSpendSleeping);
$minuteMostSpendSleeping = $minutesMostSpendSleeping[$guardThatIsMostFrequentlyAsleep];

// print_r(compact('timesMostSpendSleeping', 'minutesMostSpendSleeping', 'guardThatIsMostFrequentlyAsleep', 'minuteMostSpendSleeping'));

echo $guardThatIsMostFrequentlyAsleep * $minuteMostSpendSleeping . PHP_EOL;
