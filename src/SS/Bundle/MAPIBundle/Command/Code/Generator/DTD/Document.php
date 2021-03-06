<?php

/**
 * SS MAPI Bundle Command Code Generator DTD Document
 *
 * @licence GNU GPL
 * 
 * @author Slavomir <slavomir.sidor@gmail.com>
 */
namespace SS\Bundle\MAPIBundle\Command\Code\Generator\DTD;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\ProgressBar;
use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\FileReflection;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use SS\Bundle\MAPIBundle\DTD\Source;

class Document extends AbstractGenerator
{

	/**
	 * (non-PHPdoc)
	 *
	 * @see \SS\Bundle\MAPIBundle\Service\Code\AbstractGenerator\Generator::configure()
	 */
	protected function configure()
	{

		$this->addArgument( 'namespace', InputArgument::OPTIONAL, 'Namespace Name', 'AppBundle\\DTD\\Document' );
		$this->addArgument( 'parentClass', InputArgument::OPTIONAL, 'Entity Generalized Class', '\\SS\\MAPIBundle\\DTD\\Document' );
		$this->addArgument( 'output', InputArgument::OPTIONAL, 'Output Folder', 'src/AppBundle/DTD/Document' );
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

		$document = $this->getDocument( $input->getArgument( 'document' ) );
		$directory = $input->getArgument( 'output' );
		$namespace = $input->getArgument( 'namespace' );
		$parentClass = $input->getArgument( 'parentClass' );
		
		if( ! file_exists( $directory ) )
		{
			mkdir( $directory, 0777, true );
		}
		
		$name = ucfirst( $document->getFileInfo()
			->getBasename( '.dtd' ) );
		$output->writeln( "Generating Document " . $name );
		
		$filename = sprintf( "%s/%s.php", $directory, $name );
		$classGenerator = new ClassGenerator( $name, $namespace, null, $parentClass );
		$fileGenerator = new FileGenerator();
		$fileGenerator->setClass( $classGenerator );
		$fileDocblock = new DocBlockGenerator( sprintf( "%s %s", str_replace( "\\", " ", $namespace ), $name ) );
		$fileDocblock->setTag( new Tag( "author", "Generator" ) );
		$fileDocblock->setTag( new Tag( "licence", "LGPL" ) );
		$fileGenerator->setDocBlock( $fileDocblock );
		file_put_contents( $filename, $fileGenerator->generate() );
	
	}

}