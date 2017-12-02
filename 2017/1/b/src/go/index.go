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
  stepsForward := numDigits / 2
  // fmt.Printf("%q\n", digits)

  sum := 0
  for i := 0; i < numDigits; i += 1 {
    index := i + stepsForward
    fallbackIndex := i - stepsForward
    // fmt.Printf("%v - %v - %v\n", i, index, fallbackIndex)

    digit, _ := strconv.Atoi(digits[i])
    var nextDigit int
    if (index <= lastIndex) {
      nextDigit, _ = strconv.Atoi(digits[index])
    } else {
      nextDigit, _ = strconv.Atoi(digits[fallbackIndex])
    }

    if (digit == nextDigit) {
      sum += digit
    }
  }

  fmt.Println(strconv.Itoa(sum))
}
