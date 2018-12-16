package main

import (
	"bufio"
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

const S  = 5

func PrintGrid(grid map[int]map[int]string) {
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

	grid := make(map[int]map[int]string, 0)
	for y := minimalY; y <= maximalY; y += 1 {
		if _, ok := grid[y]; !ok {
			grid[y] = make(map[int]string, 0)
		}

		for x := minimalX; x <= maximalX; x += 1 {
			grid[y][x] = "."
		}
	}

	for _, point := range points {
		grid[point.y][point.x] = "#"
	}

	PrintGrid(grid)
}

func main() {
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
	minimalGridSize := []int{}
	minimalGridProduct := math.MaxUint32

	for tI := 1; tI < S; tI += 1 {
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
			minimalGridSize = []int{deltaX, deltaY}
			minimalGridProduct = gridProduct

			timeline = TimeLine {
				tI: timeline[tI],
			}
		}
	}

	if (minimalGridProduct < int(math.Pow(float64(10), float64(3)))) {
		fmt.Println(minimalGrid)
		fmt.Println(minimalGridSize)
		fmt.Println(minimalGridProduct)

		PrintPoints(timeline[minimalGrid])
	}
}