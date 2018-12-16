package main

import (
	"bufio"
	"flag"
	"fmt"
	"math"
	"os"
	"regexp"
	"strconv"
	"strings"
)

type Point struct {
	x  int
	y  int
	vX int
	vY int
}
type Points map[int]Point
type TimeLine map[int]Points

func PrintGrid(grid [][]string) {
	for _, y := range grid {
		for _, x := range y {
			fmt.Print(x)
		}
		fmt.Println("")
	}
}

func PrintPoints(points Points) {
	minimalX := math.MaxUint32
	maximalX := math.MinInt32
	minimalY := math.MaxUint32
	maximalY := math.MinInt32

	for _, point := range points {
		minimalX = int(math.Min(float64(minimalX), float64(point.x)))
		minimalY = int(math.Min(float64(minimalY), float64(point.y)))
		maximalX = int(math.Max(float64(maximalX), float64(point.x)))
		maximalY = int(math.Max(float64(maximalY), float64(point.y)))
	}

	correctionX := 0 - minimalX
	correctionY := 0 - minimalY

	deltaX := int(math.Abs(float64(minimalX - maximalX)))
	deltaY := int(math.Abs(float64(minimalY - maximalY)))

	grid := make([][]string, deltaY + 1)
	for y := 0; y <= deltaY; y += 1 {
		grid[y] = make([]string, deltaX + 1)
		for x := 0; x <= deltaX; x += 1 {
			grid[y][x] = "."
		}
	}

	for _, point := range points {
		grid[point.y + correctionY][point.x + correctionX] = "#"
	}

	PrintGrid(grid)
}

func main() {
	var maximumNumberOfSeconds int

	flag.IntVar(&maximumNumberOfSeconds, "s", 0, "Maximum number of seconds")
	flag.Parse()

	if maximumNumberOfSeconds <= 0 {
		fmt.Fprintf(os.Stderr, "Usage: %v [-s Maximum number of seconds]\n", os.Args[0])
		os.Exit(1)
	}

	points := []Point{}
	timeline := make(TimeLine, 0)

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		line := strings.Trim(scanner.Text(), "")

		pattern := "^position=<\\s?(-?\\d+),\\s+(-?\\d+)>\\s+velocity=<\\s?(-?\\d+),\\s+(-?\\d+)>$"
		matches := regexp.MustCompile(pattern).FindStringSubmatch(line)

		x, _ := strconv.Atoi(matches[1])
		y, _ := strconv.Atoi(matches[2])
		vX, _ := strconv.Atoi(matches[3])
		vY, _ := strconv.Atoi(matches[4])

		point := Point{x, y, vX, vY}
		points = append(points, point)
	}

	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
	}

	minimalGrid := 0
	minimalGridProduct := math.MaxUint32

	for tI := 1; tI < maximumNumberOfSeconds - 1; tI += 1 {
		if _, ok := timeline[tI]; !ok {
			timeline[tI] = make(Points, 0)
		}

		minimalX := math.MaxUint32
		maximalX := math.MinInt32
		minimalY := math.MaxUint32
		maximalY := math.MinInt32

		for pI, point := range points {
			newPoint := Point{x: point.x + (tI * point.vX), y: point.y + (tI * point.vY)}
			timeline[tI][pI] = newPoint

			minimalX = int(math.Min(float64(minimalX), float64(newPoint.x)))
			minimalY = int(math.Min(float64(minimalY), float64(newPoint.y)))
			maximalX = int(math.Max(float64(maximalX), float64(newPoint.x)))
			maximalY = int(math.Max(float64(maximalY), float64(newPoint.y)))
		}

		deltaX := int(math.Abs(float64(minimalX - maximalX)))
		deltaY := int(math.Abs(float64(minimalY - maximalY)))

		gridProduct := deltaX * deltaY
		if gridProduct < minimalGridProduct {
			minimalGrid = tI
			minimalGridProduct = gridProduct

			timeline = TimeLine {
				tI: timeline[tI],
			}
		}
	}

	if minimalGridProduct < int(math.Pow(float64(10), float64(3))) {
		fmt.Println(strings.Repeat("-", 76))
		fmt.Println(fmt.Sprintf("| %d", minimalGrid))
		fmt.Println(strings.Repeat("-", 76))
		PrintPoints(timeline[minimalGrid])
	}
}