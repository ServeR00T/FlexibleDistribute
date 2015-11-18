<?php
/**
 * a Class which implements Consistent Hashing Algorithm used for clustered systems
 * articles explain how this Algorithm:
 * http://www.tom-e-white.com/2007/11/consistent-hashing.html
 * http://www.tomkleinpeter.com/2008/03/17/programmers-toolbox-part-3-consistent-hashing/
 */
class FlexibleDistribute
{
	// Actually this variable isn't nesseccary
	//private $physicalNodes = [];

	// Number of virtual nodes per actual node
	// Should be much larger of the predicted actual nodes
	// NEVER change this over lifetime of production
	private $virtualNodes = 128;

	/**
	 * Ring is key => value [sorted] array
	 * Key range from 0 (0x00000000) to 4294967295 (0xffffffff)
	 * @var array
	 */
	private $ring = [];
	
	/**
	 * @param array $nodes  as HOSTNAME:PORT or IP:PORT for each value
	 */
	function __construct($nodes = null)
	{
		if ($nodes !== null)
		{
			foreach ($nodes as $node)
			{
				$this->addNode($node);
			}
		}
	}

	/**
	 * Hash the key and search in the ring for the nearest bigger node
	 * @param  mixed  $key  The key ...
	 * @return String       The node responsible for the key
	 */
	public function getNode($key)
	{
		$key = $this->hashFunc($key);
		
		foreach ($this->ring as $beginKey => $node)
		{
			if ($key <= $beginKey)
			{
				return $node;
			}
		}

		return $this->firstInRing();
	}

	/**
	 * Add virtual nodes for the node to the ring
	 * and sort the ring
	 * @param String $node  as HOSTNAME:PORT or IP:PORT
	 */
	public function addNode($node)
	{
		for ($i=0; $i < $this->virtualNodes; $i++)
		{
			$key = $this->hashFunc($node.'-'.$i);
			$this->ring[$key] = $node;
		}
		ksort($this->ring);
		//$this->physicalNodes[] = $node;
	}

	/**
	 * Remove the virtual nodes of the node from the ring
	 * @param  String $node  as HOSTNAME:PORT or IP:PORT
	 */
	public function removeNode($node)
	{
		for ($i=0; $i < $this->virtualNodes; $i++)
		{
			$key = $this->hashFunc($node.'-'.$i);
			unset($this->ring[$key]);
		}
		//unset($this->physicalNodes[$node]);
	}

	/**
	 * Get the first virtual node from the ring
	 * @return String  as HOSTNAME:PORT or IP:PORT
	 */
	private function firstInRing()
	{
		foreach ($this->ring as $key => $node)
		{
			return $node;
		}
	}

	/**
	 * hash the key and get the 8 bytes then convert it to decimal
	 * @param  mixed  $key the key ...
	 * @return int    The int value of the first 8 bytes of the hash
	 */
	private function hashFunc($key)
	{
		return hexdec(substr(sha1($key), 0, 8));
	}
}
?>