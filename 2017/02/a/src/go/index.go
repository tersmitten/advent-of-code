package main

import (
  "bufio"
  "fmt"
  "os"
  "strings"
  "strconv"
  "errors"
)

func sliceAtoi(sa []string) ([]int, error) {
  si := make([]int, 0, len(sa))
  for _, a := range sa {
    i, err := strconv.Atoi(a)
    if err != nil {
      return si, err
    }
    si = append(si, i)
  }
  return si, nil
}

func sliceMin(values []int) (min int, e error) {
  if len(values) == 0 {
    return 0, errors.New("Cannot detect a minimum value in an empty slice")
  }

  min = values[0]
  for _, v := range values {
    if (v < min) {
      min = v
    }
  }

  return min, nil
}

func sliceMax(values []int) (max int, e error) {
  if len(values) == 0 {
    return 0, errors.New("Cannot detect a maximum value in an empty slice")
  }

  max = values[0]
  for _, v := range values {
    if (v > max) {
      max = v
    }
  }

  return max, nil
}

func main() {
  scanner := bufio.NewScanner(os.Stdin)
  spreadsheet := make([][]int, 0)
  for scanner.Scan() {
    row, _ := sliceAtoi(strings.Fields(strings.Trim(scanner.Text(), "")))
    spreadsheet = append(spreadsheet, row)
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
  }

  sum := 0
  for _, row := range spreadsheet {
    max, _ := sliceMax(row)
    min, _ := sliceMin(row)
    sum += max - min
  }

  fmt.Println(sum)
}
