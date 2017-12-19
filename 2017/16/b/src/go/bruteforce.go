package main

import (
  "fmt"
  "strings"
  "strconv"
  "os"
  "bufio"
  "flag"
)

const (
  Alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
)

func Spin(param int, programs string) string {
  lenPrograms := len(programs)

  return programs[lenPrograms - param:lenPrograms] + programs[0:lenPrograms - param]
}

func Exchange(params []int, programs string) string {
  modifiedPrograms := []rune(programs)

  modifiedPrograms[params[0]] = rune(programs[params[1]])
  modifiedPrograms[params[1]] = rune(programs[params[0]])

  return string(modifiedPrograms)
}

func Partner(params []string, programs string) string {
  left := strings.Index(programs, params[0])
  right := strings.Index(programs, params[1])

  return Exchange([]int{left, right}, programs)
}

func Dance(programs string, sequenceOfDanceMoves []string) string {
  for _, danceMove := range sequenceOfDanceMoves {
    switch (danceMove[0]) {
      case 's':
        param, _ := strconv.Atoi(danceMove[1:len(danceMove)])
        programs = Spin(param, programs)
        break
      case 'x':
        params := strings.Split(danceMove[1:len(danceMove)], "/")
        left, _ := strconv.Atoi(params[0])
        right, _ := strconv.Atoi(params[1])
        programs = Exchange([]int{left, right}, programs)
        break
      case 'p':
        params := strings.Split(danceMove[1:len(danceMove)], "/")
        programs = Partner(params, programs)
        break
    }
  }

  return programs
}

func main() {
  var numPrograms, numDances int

  flag.IntVar(&numPrograms, "n", 0, "Number of programs")
  flag.IntVar(&numDances, "d", 0, "Number of dances")
  flag.Parse()

  if numPrograms <= 0 || numDances <= 0 {
    fmt.Fprintf(os.Stderr, "Usage: %s [-n Number of programs] [-d Number of dances]\n", os.Args[0])
    os.Exit(1)
  }

  scanner := bufio.NewScanner(os.Stdin)
  sequenceOfDanceMoves := []string{}
  for scanner.Scan() {
    sequenceOfDanceMoves = strings.Split(strings.Trim(scanner.Text(), ""), ",")
  }

  if err := scanner.Err(); err != nil {
    fmt.Fprintln(os.Stderr, "Error reading from stdin:", err)
    os.Exit(1)
  }

  programs := Alphabet[0:numPrograms]
  originalPrograms := programs

  for i := 1; i <= numDances; i += 1 {
    programs = Dance(programs, sequenceOfDanceMoves)
    if programs == originalPrograms {
      fmt.Println(i)
    }
  }

  fmt.Println(programs)
}
