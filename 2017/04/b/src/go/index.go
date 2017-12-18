package main

import (
  "bufio"
  "fmt"
  "os"
  "strings"
  "regexp"
  "errors"
  "sort"
)

func SliceSortWords(values []string) (sortedValues []string) {
  for _, v := range values {
    splittedWord := strings.Split(v, "")
    sort.Strings(splittedWord)

    sortedValues = append(sortedValues, strings.Join(splittedWord, ""))
  }

  return sortedValues
}

func SliceCountValues(values []string) (valueCount map[string]int) {
  valueCount = make(map[string]int)
  for _, value := range values {
    valueCount[value] += 1
  }

  return valueCount
}

func MapMax(values map[string]int) (max int, e error) {
  numValues := len(values)
  if numValues == 0 {
    return 0, errors.New("Cannot detect a maximum value in an empty slice")
  }

  mapValues := []int{}
  for _, value := range values {
    mapValues = append(mapValues, value)
  }

  max = mapValues[0]
  for _, value := range mapValues {
    if value > max {
      max = value
    }
  }

  return max, nil
}

func main() {
  scanner := bufio.NewScanner(os.Stdin)
  passphraseList := make([][]string, 0)
  for scanner.Scan() {
    row := regexp.MustCompile("\\s+").Split(strings.Trim(scanner.Text(), ""), -1)
    passphraseList = append(passphraseList, row)
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
  }

  sum := 0
  for _, row := range passphraseList {
    sortedWords := SliceSortWords(row)
    wordCounts := SliceCountValues(sortedWords)
    if max, _ := MapMax(wordCounts); max == 1 {
      sum += 1;
    }
  }

  fmt.Println(sum)
}
