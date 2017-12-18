package main

import (
  "bufio"
  "fmt"
  "os"
  "strings"
  "strconv"
  "math"
  "errors"
)

func ManhattanDistance(vector1, vector2 []float64) (distance float64, e error) {
  if len(vector1) != len(vector2) {
    return 0, errors.New("Argument sizes do not match")
  }

  for i, val1 := range vector1 {
    distance += math.Abs(float64(val1 - vector2[i]))
  }

  return distance, nil
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

  wantedSquareData, _ = strconv.Atoi(wantedSquareDataString)
  width = int(math.Ceil(math.Sqrt(float64(wantedSquareData)) / 10) * 10)
  height = width
  j = int(math.Pow(math.Max(float64(width), float64(height)), 2))
  for ; j > 0; j -= 1 {
    if (-1 * width / 2 < x && x <= width / 2) && (-1 * height / 2 < y && y <= height / 2) {
      i += 1
      if i == wantedSquareData {
        vector1 := []float64{float64(0), float64(0)}
        vector2 := []float64{float64(x), float64(y)}
        manhattanDistance, _ := ManhattanDistance(vector1, vector2)

        fmt.Println(manhattanDistance)
      }
    }

    if x == y || (x < 0 && x == -1 * y) || (x > 0 && x == 1 - y) {
      delta = []int{-1 * delta[1], delta[0]}
    }

    x += delta[0]
    y += delta[1]
  }
}
