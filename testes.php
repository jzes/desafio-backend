<?php

$arrayz = [1,2,3,4,5,6,7,8,9,10];
$pageSize = 3;
$pageNumber = 0;
echo "\npagina numero {$pageNumber}\n";
$arrays = array_slice($arrayz,$pageNumber*$pageSize , $pageSize);
var_dump($arrays);