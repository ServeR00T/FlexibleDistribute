#FlexibleDistribute

FlexibleDistribute is a simple, small and easy to use PHP class which implements [Consistent hashing](http://en.wikipedia.org/wiki/Consistent_hashing) Algorithm.

##Installation

Just download the Class file and require it in your code, then .. Enjoy !
```php
require 'FlexibleDistribute.php';
```

##Usage

```php
// Create an object
$FD = new FlexibleDistribute();
// Add nodes
$FD->addNode('192.168.1.150');
$FD->addNode('192.168.1.151');

// Or just pass the nodes to the constructor
$FD = new FlexibleDistribute(array('192.168.1.150', '192.168.1.151'));

// get the node responsible for the key "a"
$FD->getNode("a");

// Remove node
$FD->removeNode('192.168.1.150');
```

##TODO

 - Binary search in getNode method
 - add weight to host as an array

##Consistent Hashing explained

  * http://www.tomkleinpeter.com/2008/03/17/programmers-toolbox-part-3-consistent-hashing/
  * http://www.tom-e-white.com/2007/11/consistent-hashing.html
