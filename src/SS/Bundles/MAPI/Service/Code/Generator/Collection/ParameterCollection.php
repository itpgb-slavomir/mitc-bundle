<?php
namespace SS\MAPIBundle\Service\Code\Generator\Collection;

use SS\MAPIBundle\Service\Code\Reflection\Collection\ParameterCollection as ReflectionParameterCollection;
use TokenReflection\Php\ReflectionParameter;

class ParameterCollection extends ReflectionParameterCollection
{

	/**
	 *
	 * @var ReflectionParameter[]
	 */
	protected $elements;

	/**
	 *
	 * @var array $columns
	 */
	protected $columns = array(
		'Class Name',
		'Operation',
		'Parameter',
		'Type',
		'Default'
	);

	/**
	 *
	 * @return array
	 */
	public function toArray()
	{
		$rows = [];

		/* @var $reflection  ReflectionParameter */
		foreach( $this->getIterator() as $reflection )
		{
			$row = [];

			$row['Class'] = $reflection->getDeclaringClassName();
			$row['Operation'] = $reflection->getDeclaringFunctionName();
			$row['Parameter'] = $reflection->getName();
			$row[ 'Type' ] =self::getParameterType($reflection);
			//$reflection->getOriginalTypeHint();
			$row[ 'Default' ] = is_array( $reflection->getDefaultValue() ) ? 'array' : $reflection->getDefaultValue();

			$rows[] = $row;
		}

		return $rows;
	}
}