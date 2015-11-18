<?php
require 'FlexibleDistribute.php';

$nodes = array('192.168.1.150', '192.168.1.151', '192.168.1.152', '192.168.1.153');
$nodesHave = array(/**/); // store how many key linked to each node

$FD = new FlexibleDistribute($nodes);

for ($i=1; $i <= 1000000; $i++)
{ 
    $nodesHave[$FD->getNode($i)]++;
}

var_dump($nodesHave);
?>