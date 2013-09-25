--TEST--
INT_TO_INT serialize/unserialize test 
--FILE--
<?php

define("TEST_INDEX_MAX", 100);

function generate_array (&$ar, $init_srand) {
	srand ($init_srand);
	for ($i = 0; $i < TEST_INDEX_MAX; $i++) {
		$index = rand(0, TEST_INDEX_MAX);
		$value = rand(-1000, 1000);
		$ar[$index] = $value;
	}
}

$a = array();
generate_array($a, 1);

$j = new Judy(Judy::INT_TO_INT);
generate_array($j, 1);

if (count($a) != count($j)) {
	printf("the number of items in array(%d) != the number of items in newly created Judy array(%d)", count($a), count($j));
}

$str = serialize($j);
$new_j = unserialize($str);

$ok = 1;
if (count($a) != count($new_j)) {
	printf("the number of items in array(%d) != the number of items in unserialized Judy array(%d)", count($a), count($new_j));
	$ok = 0;
}

foreach($j as $index=>$value) {
	if ($j[$index] !== $new_j[$index]) {
		printf("value with index %d in initial Judy array(%d) != value with index %d in unserialized Judy array(%d)", $index, $j[$index], $index, $new_j[$index]);
		$ok = 0;
	}
}

if ($ok) {
	echo "OK\n";
}

?>
--EXPECT--
OK
