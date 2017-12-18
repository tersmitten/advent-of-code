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
  fileContent := ""
  for scanner.Scan() {
    line := scanner.Text()
    fileContent = fileContent + string(strings.Trim(line, ""))
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
  }

  digits := strings.Split(fileContent, "")
  numDigits := len(digits)

  sum := 0
  for i, digit := range digits {
    j := (i + 1) % numDigits
    digit, _ := strconv.Atoi(digit)
    nextDigit, _ := strconv.Atoi(digits[j])
    if digit == nextDigit {
      sum += digit
    }
  }

  fmt.Println(sum)
}
