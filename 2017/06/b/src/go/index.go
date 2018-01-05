package main

import (
  "bufio"
  "fmt"
  "os"
  "strings"
  "regexp"
  "strconv"
  "errors"
)

func SliceAtoi(sa []string) ([]int, error) {
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

func SliceMax(values []int) (max int, e error) {
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

func SliceIndex(limit int, predicate func(i int) bool) int {
  for i := 0; i < limit; i += 1 {
    if predicate(i) {
      return i
    }
  }

  return -1
}

func main() {
  scanner := bufio.NewScanner(os.Stdin)
  memoryBanks := []int{}
  for scanner.Scan() {
    memoryBanks, _ = SliceAtoi(regexp.MustCompile("\\s+").Split(strings.Trim(scanner.Text(), ""), -1))
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
  }

  numMemoryBanks := len(memoryBanks)
  numRedistributionCycles := 0
  reachedStates := map[string]int{}
  memoryBanksString := fmt.Sprintf("%v", memoryBanks)

  firstOccurrenceIndex := 0
  for true {
    if _, ok := reachedStates[memoryBanksString]; ok {
      break
    }

    reachedStates[memoryBanksString] = firstOccurrenceIndex
    firstOccurrenceIndex += 1

    mostBlocks, _ := SliceMax(memoryBanks)
    mostBlocksIndex := SliceIndex(numMemoryBanks, func(i int) bool { return memoryBanks[i] == mostBlocks })

    memoryBanks[mostBlocksIndex] = 0

    startI := mostBlocksIndex + 1
    endI := startI + mostBlocks
    for i := startI; i < endI; i += 1 {
      memoryBanks[i % numMemoryBanks] += 1
    }

    memoryBanksString = fmt.Sprintf("%v", memoryBanks)

    numRedistributionCycles += 1
  }

  fmt.Println(numRedistributionCycles - reachedStates[memoryBanksString])
}
