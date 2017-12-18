package main

import (
  "fmt"
  "math"
  "strconv"
  "os"
  "strings"
  "bufio"
)

func GetGrid(width, height int) (grid map[int]map[int]int) {
  maxX := int(math.Floor(float64(width / 2)))
  minX := -1 * maxX
  maxY := int(math.Floor(float64(height / 2)))
  minY := -1 * maxY

  grid = make(map[int]map[int]int)
  for x := minX; x <= maxX; x += 1 {
    grid[x] = make(map[int]int)
    for y := minY; y <= maxY; y += 1 {
      grid[x][y] = 0
    }
  }

  return grid
}

func GetAdjacentSquares(x, y int) (adjacentSquares [][]int) {
  xPlusOne := x + 1
  xMinOne := x - 1
  yPlusOne := y + 1
  yMinOne := y - 1

  // topLeft
  adjacentSquares = append(adjacentSquares, []int{xMinOne, yMinOne})
  // top
  adjacentSquares = append(adjacentSquares, []int{x, yMinOne})
  // topRight
  adjacentSquares = append(adjacentSquares, []int{xPlusOne, yMinOne})
  // midLeft
  adjacentSquares = append(adjacentSquares, []int{xMinOne, y})
  // midRight
  adjacentSquares = append(adjacentSquares, []int{xPlusOne, y})
  // botLeft
  adjacentSquares = append(adjacentSquares, []int{xMinOne, yPlusOne})
  // bot
  adjacentSquares = append(adjacentSquares, []int{x, yPlusOne})
  // botRight
  adjacentSquares = append(adjacentSquares, []int{xPlusOne, yPlusOne})

  return adjacentSquares
}

func SumAdjacentSquares(grid map[int]map[int]int, adjacentSquares [][]int) (sum int) {
  for _, adjacentSquare := range adjacentSquares {
    x, y := adjacentSquare[0], adjacentSquare[1]
    sum += grid[x][y]
  }

  return sum;
}

func main() {
  scanner := bufio.NewScanner(os.Stdin)
  wantedSquareDataString := ""
  for scanner.Scan() {
    wantedSquareDataString = strings.Trim(scanner.Text(), "")
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
  }

  var x, y, i, j, width, height, wantedSquareData int
  var delta = []int{0, -1}
  var grid map[int]map[int]int

  wantedSquareData, _ = strconv.Atoi(wantedSquareDataString)
  width, height = 10, 10
  grid = GetGrid(width, height)
  j = int(math.Pow(math.Max(float64(width), float64(height)), 2))

  for ; j > 0; j -= 1 {
    if (-1 * width / 2 < x && x <= width / 2) && (-1 * height / 2 < y && y <= height / 2) {
      i += 1

      adjacentSquares := GetAdjacentSquares(x, y)
      sum := SumAdjacentSquares(grid, adjacentSquares)
      if sum == 0 {
        sum += 1
      }
      grid[x][y] = sum;

      if (sum > wantedSquareData) {
        fmt.Println(sum)
        os.Exit(0)
      }

    }

    if x == y || (x < 0 && x == -1 * y) || (x > 0 && x == 1 - y) {
      delta = []int{-1 * delta[1], delta[0]}
    }

    x += delta[0]
    y += delta[1]
  }
}
