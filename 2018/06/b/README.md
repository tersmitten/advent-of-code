# implementations

## php

```sh
while true; do
  diff -qw <(src/php/index.php -m 32 < tests/input02.txt) <(cat tests/output02.txt);
  sleep 2;
done
```

```sh
while true; do
  src/php/index.php -m 10000 < tests/input01.txt | tee tests/output01.txt;
  sleep 2;
done
```
