# documentation

* https://stackoverflow.com/questions/3706219/algorithm-for-iterating-over-an-outward-spiral-on-a-discrete-2d-grid-from-the-or
* http://calculator.vhex.net/post/calculator-result/manhattan-distance

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

## go

```sh
while true; do
  diff -qw <(go run src/go/index.go < tests/input1.txt) <(cat tests/output1.txt);
  diff -qw <(go run src/go/index.go < tests/input2.txt) <(cat tests/output2.txt);
  diff -qw <(go run src/go/index.go < tests/input3.txt) <(cat tests/output3.txt);
  diff -qw <(go run src/go/index.go < tests/input4.txt) <(cat tests/output4.txt);
  sleep 2;
done
```

```sh
while true; do
  go run src/go/index.go < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```
