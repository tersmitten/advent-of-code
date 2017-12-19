# documentation

http://eddmann.com/posts/implementing-and-using-memoization-in-php/

# implementations

## php

```sh
while true; do
  diff -qw <(src/php/index.php -n 5 -d 2 < tests/input1.txt) <(cat tests/output1.txt);
  sleep 2;
done
```

```sh
# time src/php/bruteforce.php -n 16 -d 10000 < tests/input0.txt
fbidepghmjklcnoa

real	0m52.954s
user	0m52.720s
sys	0m0.076s
```

```sh
# time src/php/memoization.php -n 16 -d 10000 < tests/input0.txt
fbidepghmjklcnoa

real	0m5.916s
user	0m5.896s
sys	0m0.016s
```

```sh
while true; do
  src/php/index.php -n 16 -d 1000000000 < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```

## go

```sh
while true; do
  diff -qw <(go run src/go/index.go -n 5 -d 2 < tests/input1.txt) <(cat tests/output1.txt);
  sleep 2;
done
```

```sh
# time go run src/go/bruteforce.go -n 16 -d 10000 < tests/input0.txt
fbidepghmjklcnoa

real	0m33.494s
user	0m36.856s
sys	0m0.472s
```

```sh
while true; do
  go run src/go/index.go -n 16 -d 1000000000 < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
```
