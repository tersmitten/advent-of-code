package main

import (
	"bufio"
	"fmt"
	"os"
	"strconv"
	"strings"
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
	stepsForward := numDigits / 2

	sum := 0
	for i, digit := range digits {
		j := (i + stepsForward) % numDigits
		digit, _ := strconv.Atoi(digit)
		nextDigit, _ := strconv.Atoi(digits[j])
		if digit == nextDigit {
			sum += digit
		}
	}

	fmt.Println(sum)
}