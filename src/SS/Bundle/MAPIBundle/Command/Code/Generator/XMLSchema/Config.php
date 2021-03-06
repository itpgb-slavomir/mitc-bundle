<?php

/**
 * SS MAPI Bundle Generator XML Schema Config
 *
 * @licence GNU GPL
 * 
 * @author Slavomir <slavomir.sidor@gmail.com>
 */
namespace SS\Bundle\MAPIBundle\Command\Code\Generator\XMLSchema;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\ProgressHelper;
use Zend\Code\Generator\ClassGenerator;

class Config extends AbstractGenerator
{

	/**
	 * (non-PHPdoc)
	 *
	 * @see \SS\Bundle\MAPIBundle\Service\Code\Generator\XMLSchema\AbstractGenerator::configure()
	 */
	protected function configure()
	{

		$this->addArgument( 'namespaceName', InputArgument::OPTIONAL, 'Output Folder', 'AppBundle\\Form\\Type' );
		$this->addArgument( 'formClass', InputArgument::OPTIONAL, 'Output Folder', 'SS\\MAPIBundle\\Form\\Type\\AbstractType' );
		$this->addArgument( 'output', InputArgument::OPTIONAL, 'Output Folder', 'src/AppBundle/Form/' );
		parent::configure();
	
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
	public function execute( 
		InputInterface $input, 
		OutputInterface $output )
	{

		$xsd = $this->getDocument( $input->getArgument( 'xsd' ) );
		$xsdSchema = $xsd->getSchema();
	
	}

}