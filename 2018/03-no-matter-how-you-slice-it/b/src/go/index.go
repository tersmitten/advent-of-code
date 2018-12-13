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
	claimID     int
	coordinates []Coordinate
}

type Coordinate struct {
	x int
	y int
}

func getCoordinates(left int, top int, width int, height int) []Coordinate {
	coordinates := []Coordinate{}

	for y := top; y < top+height; y += 1 {
		for x := left; x < left+width; x += 1 {
			coordinates = append(coordinates, Coordinate{x: x, y: y})
		}
	}

	return coordinates
}

func getKey(coordinate Coordinate) string {
	return fmt.Sprintf("%d,%d", coordinate.x, coordinate.y)
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

		claim := Claim{claimID: claimID, coordinates: getCoordinates(left, top, width, height)}
		claims = append(claims, claim)
	}

	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
	}

	for _, claim := range claims {
		for _, coordinate := range claim.coordinates {
			key := getKey(coordinate)
			if _, ok := claimed[key]; ok {
				overlapping[key] = true
			}
			claimed[key] = true
		}
	}

	for _, claim := range claims {
		hasOverlap := false

		for _, coordinate := range claim.coordinates {
			key := getKey(coordinate)
			if _, ok := overlapping[key]; ok {
				hasOverlap = true
				continue
			}
		}

		if !hasOverlap {
			fmt.Println(claim.claimID)
			break
		}
	}
}
