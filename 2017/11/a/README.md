# documentation

* https://www.redblobgames.com/grids/hexagons/#coordinates-axial
* https://www.redblobgames.com/grids/hexagons/

# implementations

## php

```sh
while true; do
  diff -qw <(src/php/index.php < tests/input1.txt) <(cat tests/output1.txt);
  diff -qw <(src/php/index.php < tests/input2.txt) <(cat tests/output2.txt);
  diff -qw <(src/php/index.php < tests/input3.txt) <(cat tests/output3.txt);
  diff -qw <(src/php/index.php < tests/input4.txt) <(cat tests/output4.txt);
  sleep 2;
done
```

```sh
while true; do
  src/php/index.php < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```
