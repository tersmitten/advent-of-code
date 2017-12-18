package main

import (
  "bufio"
  "fmt"
  "os"
  "strings"
  "strconv"
)

func main() {
  scanner := bufio.NewScanner(os.Stdin)
  listOfJumpOffsets := []int{}
  for scanner.Scan() {
    row, _ := strconv.Atoi(strings.Trim(scanner.Text(), ""))
    listOfJumpOffsets = append(listOfJumpOffsets, row)
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
  }

  var previousIndex, currentIndex, numberOfSteps int
  for len(listOfJumpOffsets) > currentIndex {
    previousIndex = currentIndex
    currentIndex += listOfJumpOffsets[currentIndex]
    listOfJumpOffsets[previousIndex] += 1
    numberOfSteps += 1
  }

  fmt.Println(numberOfSteps)
}
