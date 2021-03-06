<?php
namespace SS\Bundle\MAPIBundle\Service\Code\Reflection\Collection;

use TokenReflection\Php\ReflectionMethod;
use SS\Bundle\MAPIBundle\Service\Code\Collection;

class OperationCollection extends Collection
{

	/**
	 *
	 * @var ReflectionMethod[]
	 */
	protected $elements;

	/**
	 *
	 * @var array
	 */
	protected $columns = array('Class','Accessibility','Abstract','Static','Operation','Parameters','Returns',
		'DocBlock'
	);

	/**
	 *
	 * @return array
	 */
	public function toArray()
	{
		$rows = [];

		/* @var $reflection ReflectionMethod */
		foreach( $this->getIterator() as $reflection )
		{
			$row = [];

			$row['Class'] = $reflection->getDeclaringClassName();
			$row['Accessibility'] = self::getAccessibility( $reflection );
			$row['Abstract'] = self::getAbstract( $reflection );
			$row['Static'] = self::getStatic( $reflection );
			$row['Operation'] = $reflection->getName();
			$row['DocBlock'] = $reflection->getPrettyName();
			$row['Parameters'] = self::getOperationParameters( $reflection );
			$row['Returns'] = self::getOperationReturns( $reflection );
			$row['DocBlock'] = $reflection->getDocComment();

			$rows[] = $row;
		}
		return $rows;
	}
}