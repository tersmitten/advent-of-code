# implementations

## php

```sh
while true; do
  src/php/index.php < tests/input1.txt;
  src/php/index.php < tests/input2.txt;
  src/php/index.php < tests/input3.txt;
  src/php/index.php < tests/input4.txt;
  echo "";
  sleep 2;
done
```

```sh
while true; do
  src/php/index.php < tests/input0.txt;
  sleep 2;
done
```

## go

```sh
while true; do
  go run src/go/index.go < tests/input1.txt;
  go run src/go/index.go < tests/input2.txt;
  go run src/go/index.go < tests/input3.txt;
  go run src/go/index.go < tests/input4.txt;
  echo "";
  sleep 2;
done
```

```sh
while true; do
  go run src/go/index.go < tests/input0.txt;
  sleep 2;
done
```
