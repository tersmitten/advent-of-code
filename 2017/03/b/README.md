# documentation

* https://stackoverflow.com/questions/2035522/get-adjacent-elements-in-a-two-dimensional-array

# implementations

## php

```sh
while true; do
  src/php/index.php < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```

## go

```sh
while true; do
  go run src/go/index.go < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```

