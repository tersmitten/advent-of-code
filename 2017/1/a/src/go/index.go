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
  lastIndex := numDigits - 1
  // fmt.Printf("%q\n", digits)

  sum := 0
  for i := 0; i < numDigits; i += 1 {
    digit, _ := strconv.Atoi(digits[i])
    nextDigit, _ := strconv.Atoi(digits[0])
    if (i < lastIndex) {
      nextDigit, _ = strconv.Atoi(digits[i + 1])
    }

    // fmt.Printf("%v - %v - %v - %v\n", i, lastIndex, digit, nextDigit)
    if (digit == nextDigit) {
      sum += digit
    }
  }

  fmt.Println(strconv.Itoa(sum))
}
