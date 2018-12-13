package main

import (
	"bufio"
	"fmt"
	"math"
	"os"
	"regexp"
	"sort"
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
	asleep := make(map[string]float64, 0)
	asleepMinutes := make(map[string]map[int]int, 0)

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		lines = append(lines, strings.Trim(scanner.Text(), ""))
	}

	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
	}

	sort.Strings(lines)

	var guard string
	var fallsAsleepTimestamp int64

	for _, line := range lines {
		shiftStartMatches := regexp.MustCompile("^\\[(.*)\\] Guard #(\\d+) begins shift$").FindStringSubmatch(line)
		if len(shiftStartMatches) > 0 {
			//shiftStart := shiftStartMatches[1]
			//shiftStartTimestamp, _ := Strtotime(shiftStart)
			guard = shiftStartMatches[2]

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

			asleep[guard] += math.Abs(float64(fallsAsleepTimestamp - wakesUpTimestamp)) / Minute

			for timestamp := fallsAsleepTimestamp; timestamp < wakesUpTimestamp; timestamp += Minute {
				minute := time.Unix(timestamp, 0).Minute()

				if _, ok := asleepMinutes[guard]; !ok {
					asleepMinutes[guard] = make(map[int]int)
				}

				asleepMinutes[guard][minute] += 1
			}

			continue
		}
	}

	fmt.Println(asleep)
	fmt.Println(asleepMinutes)
}