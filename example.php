<?php
require 'FlexibleDistribute.php';

$nodes = array('192.168.1.150', '192.168.1.151', '192.168.1.152', '192.168.1.153');
$nodesHave = array(/**/); // store how many key linked to each node

$fA = [];
$sA = [];

$FD = new FlexibleDistribute($nodes);

for ($i=1; $i <= 64000; $i++)
{ 
	$a = $FD->getNode(md5($i));
    $nodesHave1[$a]++;
    $fA[$i] = $a;
}

$FD->addNode('192.168.1.154');

for ($i=1; $i <= 64000; $i++)
{ 
	$a = $FD->getNode(md5($i));
    $nodesHave2[$a]++;
    $sA[$i] = $a;
}
$swap = 0;
for ($i=1; $i <= 64000; $i++)
{ 
	if ($fA[$i] !== $sA[$i]) {
		$swap++;
		echo $fA[$i] .' to ' . $sA[$i] .' - ' . $i .PHP_EOL;
	}
}
var_dump($swap);
var_dump($nodesHave1);
var_dump($nodesHave2);
?>