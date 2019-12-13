<?php
namespace SS\Bundle\MAPIBundle\Service\Code;

use PhpCollection\Map;
use SS\Bundle\MAPIBundle\Service\Code\Reflection\Helper;

abstract class Collection extends Map
{
	use Helper;

	/**
	 *
	 * @var array
	 */
	protected $columns = array();

	/**
	 *
	 * @return array
	 */
	public function getColumns()
	{
		return $this->columns;
	}

	/**
	 *
	 * @return array
	 */
	public function toArray()
	{
		return $this->getIterator()->serialize();
	}
}