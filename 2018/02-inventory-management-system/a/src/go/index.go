package main

import (
	"bufio"
	"fmt"
	"os"
	"strings"
)

func main() {
	scanner := bufio.NewScanner(os.Stdin)
	boxIDs := make([][]string, 0)
	for scanner.Scan() {
		line := strings.Split(strings.Trim(scanner.Text(), ""), "")
		boxIDs = append(boxIDs, line)
	}

	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
	}

	wantedCharacterCounts := map[int]bool{
		2: true,
		3: true,
	}
	relevantCharacterCounts := make([]int, 0)
	checksum := 1

	for _, boxID := range boxIDs {
		characterCounts := make(map[string]int, len(boxID))
		for _, letter := range boxID {
			characterCounts[letter] += 1
		}

		// fmt.Println(characterCounts)

		uniqueCharacterCounts := make(map[int]bool, len(characterCounts))
		for _, characterCount := range characterCounts {
			uniqueCharacterCounts[characterCount] = true
		}

		// fmt.Println(uniqueCharacterCounts)

		for uniqueCharacterCount, _ := range uniqueCharacterCounts {
			if _, ok := wantedCharacterCounts[uniqueCharacterCount]; ok {
				relevantCharacterCounts = append(relevantCharacterCounts, uniqueCharacterCount)
			}
		}

		// fmt.Println(relevantCharacterCounts)
	}

	groupedCharacterCounts := make(map[int]int, len(relevantCharacterCounts))
	for _, relevantCharacterCount := range relevantCharacterCounts {
		groupedCharacterCounts[relevantCharacterCount] += 1
	}

	// fmt.Println(groupedCharacterCounts)

	for _, groupedCharacterCount := range groupedCharacterCounts {
		checksum *= groupedCharacterCount
	}

	fmt.Println(checksum)
}