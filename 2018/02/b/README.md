# implementations

## php

```sh
src/php/index.php < tests/input02.txt | awk '{ print length, $0 }' | sort -n -s | cut -d" " -f2- | tail -1;
```

```sh
src/php/index.php < tests/input01.txt | awk '{ print length, $0 }' | sort -n -s | cut -d" " -f2- | tail -1;
```
