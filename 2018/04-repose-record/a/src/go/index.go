package main

import (
	"bufio"
	"fmt"
	"math"
	"os"
	"regexp"
	"sort"
	"strconv"
	"strings"
	"time"
)

const Minute = 60

func Strtotime(str string) (int64, error) {
	layout := "2006-01-02 15:04"
	t, err := time.Parse(layout, str)
	if err != nil {
		return 0, err
	}

	return t.Unix(), nil
}

func main() {
	lines := []string{}
	asleep := make(map[int]int, 0)
	asleepMinutes := make(map[int]map[int]int, 0)

	var guard, guardWithMostSleep, maxSleep, maxFrequency, minuteMostSpendSleeping int
	var fallsAsleepTimestamp int64

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		lines = append(lines, strings.Trim(scanner.Text(), ""))
	}

	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
	}

	sort.Strings(lines)

	for _, line := range lines {
		shiftStartMatches := regexp.MustCompile("^\\[(.*)\\] Guard #(\\d+) begins shift$").FindStringSubmatch(line)
		if len(shiftStartMatches) > 0 {
			guard, _ = strconv.Atoi(shiftStartMatches[2])

			continue;
		}

		fallsAsleepMatches := regexp.MustCompile("^\\[(.*)\\] falls asleep$").FindStringSubmatch(line)
		if len(fallsAsleepMatches) > 0 {
			fallsAsleep := fallsAsleepMatches[1]
			fallsAsleepTimestamp, _ = Strtotime(fallsAsleep)

			continue;
		}

		wakesUpMatches := regexp.MustCompile("^\\[(.*)\\] wakes up$").FindStringSubmatch(line)
		if len(wakesUpMatches) > 0 {
			wakesUp := wakesUpMatches[1]
			wakesUpTimestamp, _ := Strtotime(wakesUp)

			asleep[guard] += int(math.Abs(float64(fallsAsleepTimestamp - wakesUpTimestamp)) / Minute)

			for timestamp := fallsAsleepTimestamp; timestamp < wakesUpTimestamp; timestamp += Minute {
				minute := time.Unix(timestamp, 0).UTC().Minute()
				if _, ok := asleepMinutes[guard]; !ok {
					asleepMinutes[guard] = make(map[int]int, 0)
				}

				asleepMinutes[guard][minute] += 1
			}

			continue
		}
	}

	for guard, sleep := range asleep {
		if sleep > maxSleep {
			guardWithMostSleep = guard
			maxSleep = sleep
		}
	}

	for minute, frequency := range asleepMinutes[guardWithMostSleep] {
		if frequency > maxFrequency {
			minuteMostSpendSleeping = minute
			maxFrequency = frequency
		}
	}

	fmt.Println(guardWithMostSleep * minuteMostSpendSleeping)
}