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

	for scanner.Scan() {
		line := scanner.Text()
		unParsedFrequencyChanges = append(unParsedFrequencyChanges, line)
	}

	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
	}

	for _, unParsedFrequencyChange := range unParsedFrequencyChanges {
		frequencyChange, _ := strconv.Atoi(unParsedFrequencyChange)
		resultingFrequency += frequencyChange
	}

	fmt.Println(resultingFrequency)
}