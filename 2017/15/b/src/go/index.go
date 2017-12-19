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
  i, numMatches := 0, 0
  numPairsToConsider := int(5 * math.Pow10(6))

  for i < numPairsToConsider {
    for true {
      values[0] = CalculateRemainder(values[0], factors[0], divider)
      if values[0] % 4 == 0 {
        break
      }
    }

    for true {
      values[1] = CalculateRemainder(values[1], factors[1], divider)
      if values[1] % 8 == 0 {
        break
      }
    }

    i += 1
    if GetLowest16Bits(values[0]) == GetLowest16Bits(values[1]) {
      numMatches += 1
    }

  }

  fmt.Println(numMatches)
}
