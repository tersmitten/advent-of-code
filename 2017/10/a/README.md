# implementations

* https://github.com/golang/go/wiki/SliceTricks

## php

```sh
while true; do
  diff -qw <(src/php/index.php -n 5 < tests/input1.txt) <(cat tests/output1.txt);
  sleep 2;
done
```

```sh
while true; do
  src/php/index.php -n 256  < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```
