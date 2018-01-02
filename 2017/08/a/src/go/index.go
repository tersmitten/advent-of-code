package main

import (
  "bufio"
  "fmt"
  "os"
  "strings"
  "regexp"
  "strconv"
  "sort"
)

func unpackInstructions(s []string, vars... *string) {
  for i, str := range s {
    *vars[i] = str
  }
}

func evaluateCondition(left int, operator string, right int) bool {
  var result bool

  switch operator {
    case "==": result = left == right
    case "!=": result = left != right
    case "<>": result = left != right
    case ">": result = left > right
    case "<": result = left < right
    case ">=": result = left >= right
    case "<=": result = left <= right
  }

  return result
}

func executeCommand(left int, command string, right int) int {
  switch command {
    case "inc": left += right
    case "dec": left -= right
  }

  return left
}

func main() {
  registers := make(map[string]int)
  instructions := [][]string{}

  scanner := bufio.NewScanner(os.Stdin)
  for scanner.Scan() {
    matches := regexp.MustCompile(
      "^([a-z]+) ((inc|dec) (-?[\\d]+)) (if ([a-z]+) (.*) (-?[\\d]+))").FindAllStringSubmatch(
      strings.Trim(scanner.Text(), ""), -1)[0]

    register := matches[1]
    command := matches[3]
    commandValue := matches[4]
    conditionRegister := matches[6]
    conditionOperator := matches[7]
    conditionValue := matches[8]

    registers[register] = 0
    instructions = append(
      instructions, []string{register, command, commandValue, conditionRegister, conditionOperator, conditionValue})
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
  }

  for _, instruction := range instructions {
    var register, command, commandValue, conditionRegister, conditionOperator, conditionValue string
    unpackInstructions(
      instruction, &register, &command, &commandValue, &conditionRegister, &conditionOperator, &conditionValue)

    conditionValueInt, _ := strconv.Atoi(conditionValue)
    commandValueInt, _ := strconv.Atoi(commandValue)

    if evaluateCondition(registers[conditionRegister], conditionOperator, conditionValueInt) {
      registers[register] = executeCommand(registers[register], command, commandValueInt)
    }
  }

  sortedRegisters := []int{}
  for _, register := range registers {
    sortedRegisters = append(sortedRegisters, register)
  }
  sort.Sort(sort.Reverse(sort.IntSlice(sortedRegisters)))

  fmt.Println(sortedRegisters[0])
}
