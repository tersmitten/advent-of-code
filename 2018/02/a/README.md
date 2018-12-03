# implementations

## php

```sh
while true; do
  diff -qw <(src/php/index.php < tests/input09.txt) <(cat tests/output09.txt);
  sleep 2;
done
```

```sh
while true; do
  src/php/index.php < tests/input01.txt | tee tests/output01.txt;
  sleep 2;
done
```

## go

```sh
while true; do
  diff -qw <(go run src/go/index.go < tests/input09.txt) <(cat tests/output09.txt);
  sleep 2;
done
```

```sh
while true; do
  go run src/go/index.go < tests/input01.txt | tee tests/output01.txt;
  sleep 2;
done
``