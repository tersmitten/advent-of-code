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

func main() {
  depths := []int{}
  firewall := make(map[int]int)

  scanner := bufio.NewScanner(os.Stdin)
  for scanner.Scan() {
    matches := regexp.MustCompile("^([\\d]+):\\s+([\\d]+)$").FindAllStringSubmatch(strings.Trim(scanner.Text(), ""), -1)[0]

    layer, _ := strconv.Atoi(matches[1])
    depth, _ := strconv.Atoi(matches[2])

    depths = append(depths, layer)
    firewall[layer] = depth
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
  }

  sort.Ints(depths)

  delay := 0
  for true {
    caught := false
    for _, layer := range depths {
      if (layer +  delay) % ((firewall[layer] - 1) * 2) == 0 {
        caught = true
        delay += 1

        break
      }
    }

    if !caught {
      break
    }
  }

  fmt.Println(delay)
}
