package main

import (
	"bufio"
	"fmt"
	"os"
	"regexp"
	"strconv"
	"strings"
)

type Claim struct {
	claimID int
	left int
	top int
	width int
	height int
}

func main() {
	claims := []Claim{}
	overlapping := make(map[string]bool, 0)
	claimed := make(map[string]bool, 0)

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		line := strings.Trim(scanner.Text(), "")

		matches := regexp.MustCompile("^#(\\d+) @ (\\d+),(\\d+): (\\d+)x(\\d+)$").FindStringSubmatch(line)

		claimID, _ := strconv.Atoi(matches[1])
		left, _ := strconv.Atoi(matches[2])
		top, _ := strconv.Atoi(matches[3])
		width, _ := strconv.Atoi(matches[4])
		height, _ := strconv.Atoi(matches[5])

		claim := Claim{claimID: claimID, left: left, top: top, width: width, height: height}
		claims = append(claims, claim)
	}

	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
	}

	for _, claim := range claims {
		left, top, width, height := claim.left, claim.top, claim.width, claim.height
		for y := top; y < top+height; y += 1 {
			for x := left; x < left+width; x += 1 {
				key := fmt.Sprintf("%d,%d", x, y)
				if _, ok := claimed[key]; ok {
					overlapping[key] = true
				}
				claimed[key] = true
			}
		}
	}

	fmt.Println(len(overlapping));
}