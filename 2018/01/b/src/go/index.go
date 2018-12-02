package main

import (
	"bufio"
	"fmt"
	"os"
	"strconv"
)

func main() {
	scanner := bufio.NewScanner(os.Stdin)

	resultingFrequency := 0;
	unParsedFrequencyChanges := make([]string, 0)
	seenFrequencies := make(map[int]bool)

	for scanner.Scan() {
		line := scanner.Text()
		unParsedFrequencyChanges = append(unParsedFrequencyChanges, line)
	}

	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
	}

	for {
		seenFrequencies[resultingFrequency] = true
		for _, unParsedFrequencyChange := range unParsedFrequencyChanges {
			frequencyChange, _ := strconv.Atoi(unParsedFrequencyChange)
			resultingFrequency += frequencyChange

			if _, ok := seenFrequencies[resultingFrequency]; ok {
				fmt.Println(resultingFrequency)
				os.Exit(0)
			}

			seenFrequencies[resultingFrequency] = true
		}
	}
}