<?php
namespace SK\ITCBundle\Service\Code\Generator\Collection;

use TokenReflection\Php\ReflectionClass;
use SK\ITCBundle\Service\Code\Reflection\Collection\ClassCollection as ReflectionClassCollection;

class ClassCollection extends ReflectionClassCollection
{

	/**
	 *
	 * @var ReflectionClass[]
	 */
	protected $elements;

	/**
	 *
	 * @var array
	 */
	protected $columns = array(
		'PHP Object',
		'Final',
		'Abstract',
		'Namespace Name',
		'Parent',
		'Implements Interfaces'
	);

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
		$rows = [];

		/* @var $reflection ReflectionClass */
		foreach( $this->getIterator() as $reflection )
		{
			$row = [];

			$row['object'] = self::getObjectType( $reflection );
			$row['final'] = self::getFinal( $reflection );
			$row['abstract'] = self::getAbstract( $reflection );
			$row['name'] = $reflection->getName();
			$row['parent'] = self::getParents( $reflection );
			$row['interface'] = self::getInterfaces( $reflection );

			$rows[] = $row;
		}
		return $rows;
	}
}