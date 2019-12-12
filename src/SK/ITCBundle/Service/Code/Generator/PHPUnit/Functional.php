<?php

/**
 * SK ITCBundle Code Generator PHPUnit Functional
 *
 * @licence GNU GPL
 * 
 * @author Slavomir <slavomir.sidor@gmail.com>
 */
namespace SK\ITCBundle\Service\Code\Generator\PHPUnit;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Functional extends PHPUnit
{

	/**
	 * (non-PHPdoc)
	 *
	 * @see \SK\ITCBundle\Service\Code\Generator\PHPUnit\AbstractGenerator::execute($input, $output)
	 */
	public function generate()
	{

		parent::execute( $input, $output );
		$this->generateClassFunctionalCase( $input, $output );
	
	}

}