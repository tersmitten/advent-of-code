package main

import (
	"bufio"
	"fmt"
	"os"
	"sort"
	"strings"
)

type ByLen []string

func (a ByLen) Len() int {
	return len(a)
}

func (a ByLen) Less(i, j int) bool {
	return len(a[i]) < len(a[j])
}

func (a ByLen) Swap(i, j int) {
	a[i], a[j] = a[j], a[i]
}

func main() {
	scanner := bufio.NewScanner(os.Stdin)
	boxIDs := make([]string, 0)
	for scanner.Scan() {
		line := strings.Trim(scanner.Text(), "")
		boxIDs = append(boxIDs, line)
	}

	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
	}

	// fmt.Println(boxIDs)

	pairs := make(map[string][]string, 0)
	for _, firstBoxID := range boxIDs {
		for _, secondBoxID := range boxIDs {
			if firstBoxID == secondBoxID {
				continue
			}

			key1 := firstBoxID + "-" + secondBoxID
			key2 := secondBoxID + "-" + firstBoxID

			if _, ok := pairs[key1]; ok {
				continue
			}

			if _, ok := pairs[key2]; ok {
				continue
			}

			pairs[key1] = []string{firstBoxID, secondBoxID}
		}
	}

	// fmt.Println(pairs)

	commonLettersPerPair := make([]string, len(pairs))
	for _, pair := range pairs {
		splittedFirstBoxID := strings.Split(pair[0], "")
		splittedSecondBoxID := strings.Split(pair[1], "")

		/*
		fmt.Println(pair)
		fmt.Println(splittedFirstBoxID)
		fmt.Println(splittedSecondBoxID)
		*/

		commonLetters := ""
		for key, value := range splittedFirstBoxID {
			if value == splittedSecondBoxID[key] {
				commonLetters += value
			}
		}

		commonLettersPerPair = append(commonLettersPerPair, commonLetters)
	}

	// fmt.Println(commonLettersPerPair)
	sort.Sort(sort.Reverse(ByLen(commonLettersPerPair)))
	// fmt.Println(commonLettersPerPair)

	fmt.Println(commonLettersPerPair[0])
}