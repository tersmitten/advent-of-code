# php
while true; do
  diff -qw <(src/php/index.php < tests/input1.txt) <(cat tests/output1.txt);
  diff -qw <(src/php/index.php < tests/input2.txt) <(cat tests/output2.txt);
  diff -qw <(src/php/index.php < tests/input3.txt) <(cat tests/output3.txt);
  sleep 2;
done

while true; do
  src/php/index.php < tests/input0.txt | tee tests/output0.txt;
  sleep 2;
done
