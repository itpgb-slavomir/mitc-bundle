<?php
/**
 * SK ITCBundle Command Code Reflection Classes
 *
 * @licence GNU GPL
 *
 * @author Slavomir <slavomir.sidor@gmail.com>
 */
namespace SK\ITCBundle\Command\Code\Generator\DocBlock;

class ClassCommand extends DocBlockCommand
{

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \SK\ITCBundle\Command\TableCommand::getColumns()
	 */
	protected function getColumns()
	{
		return $this->getReflection()
			->getClasses()
			->getColumns();
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \SK\ITCBundle\Command\TableCommand::getRows()
	 */
	protected function getRows()
	{
		if( NULL === $this->rows )
		{
			$this->setRows( $this->getReflection()
				->getClasses()
				->toArray() );
		}

		return $this->rows;
	}
}