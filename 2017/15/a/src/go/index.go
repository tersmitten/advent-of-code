package main

import (
  "bufio"
  "fmt"
  "os"
  "strings"
  "regexp"
  "strconv"
  "math"
)

func CalculateRemainder(value, factor, divider int) int {
  return value * factor % divider
}

func GetLowest16Bits(remainder int) int {
  return remainder & 0xFFFF
}

func main() {
  scanner := bufio.NewScanner(os.Stdin)
  startingValues := make([]int, 0)
  for scanner.Scan() {
    matches := regexp.MustCompile("([\\d]+)").FindAllString(strings.Trim(scanner.Text(), ""), -1)
    startingValue, _ := strconv.Atoi(matches[0])
    startingValues = append(startingValues, startingValue)
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
  }

  factors := []int{16807, 48271}
  divider := 2147483647
  values := startingValues
  numMatches := 0
  numPairsToConsider := int(40 * math.Pow10(6))

  for i := 1; i < numPairsToConsider; i += 1 {
    remainder0 := CalculateRemainder(values[0], factors[0], divider)
    remainder1 := CalculateRemainder(values[1], factors[1], divider)
    values = []int{remainder0, remainder1}
    if GetLowest16Bits(values[0]) == GetLowest16Bits(values[1]) {
      numMatches += 1
    }
  }

  fmt.Println(numMatches)
}
