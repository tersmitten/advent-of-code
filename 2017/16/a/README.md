# documentation

* https://gist.github.com/mfojtik/a0018e29d803a6e2ba0c

# implementations

## php

```sh
while true; do
  diff -qw <(src/php/index.php -n 5 < tests/input1.txt) <(cat tests/output1.txt);
  sleep 2;
done
```

```sh
while true; do
  src/php/index.php -n 16 < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```

## go

```sh
while true; do
  diff -qw <(go run src/go/index.go -n 5 < tests/input1.txt) <(cat tests/output1.txt);
  sleep 2;
done
```

```sh
while true; do
  go run src/go/index.go -n 16 < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```
