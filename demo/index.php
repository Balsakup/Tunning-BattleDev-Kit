<?php
$count = $input[0];
$price = $input[1];
$max   = 0;
$name  = null;

for ($i = 2; $i < intval($count) + 2; $i++) {
    list($p, $n) = explode(' ', $input[$i]);

    if ($p > $max) {
        $max  = $p;
        $name = $n;
    }
}

echo $max > $price ? strtoupper($name) : 'KO';
