# documentation

* https://github.com/golang/go/wiki/SliceTricks

# implementations

## php

```sh
while true; do
  diff -qw <(src/php/index.php -n 256 < tests/input1.txt) <(cat tests/output1.txt);
  diff -qw <(src/php/index.php -n 256 < tests/input2.txt) <(cat tests/output2.txt);
  diff -qw <(src/php/index.php -n 256 < tests/input3.txt) <(cat tests/output3.txt);
  diff -qw <(src/php/index.php -n 256 < tests/input4.txt) <(cat tests/output4.txt);
  sleep 2;
done
```

```sh
while true; do
  src/php/index.php -n 256  < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```
