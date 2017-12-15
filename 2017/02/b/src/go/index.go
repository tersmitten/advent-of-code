package main

import (
  "bufio"
  "fmt"
  "os"
  "strings"
  "strconv"
  "sort"
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
    sort.Sort(sort.Reverse(sort.IntSlice(row)))
    for i, number := range row {
      for _, nextNumber := range row[i + 1:] {
        if number % nextNumber == 0 {
          sum += number / nextNumber
        }
      }
    }
  }

  fmt.Println(strconv.Itoa(sum))
}
