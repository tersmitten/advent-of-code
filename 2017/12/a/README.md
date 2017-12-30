# documentation

* http://php.net/manual/en/class.ds-set.php

# implementations

## php

```sh
while true; do
  diff -qw <(src/php/index.php < tests/input1.txt) <(cat tests/output1.txt);
  diff -qw <(src/php/reference.php < tests/input1.txt) <(cat tests/output1.txt);
  diff -qw <(src/php/set.php < tests/input1.txt) <(cat tests/output1.txt);
  sleep 2;
done
```

```sh
while true; do
  src/php/index.php < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```
