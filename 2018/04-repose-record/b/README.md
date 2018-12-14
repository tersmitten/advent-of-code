# implementations

## php

```sh
while true; do
  diff -qw <(src/php/index.php < tests/input02.txt) <(cat tests/output02.txt);
  diff -qw <(src/php/index.php < tests/input03.txt) <(cat tests/output03.txt);
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
  diff -qw <(go run src/go/index.go < tests/input02.txt) <(cat tests/output02.txt);
  diff -qw <(go run src/go/index.go < tests/input03.txt) <(cat tests/output03.txt);
  sleep 2;
done
```

```sh
while true; do
  go run src/go/index.go < tests/input01.txt | tee tests/output01.txt;
  sleep 2;
done
```