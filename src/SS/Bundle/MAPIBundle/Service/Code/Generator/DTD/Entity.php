<?php

/**
 * SS MAPI Bundle Code Generator DTD Entity
 *
 * @licence GNU GPL
 * 
 * @author Slavomir <slavomir.sidor@gmail.com>
 */
namespace SS\Bundle\MAPIBundle\Service\Code\Generator\DTD;

use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\FileReflection;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use SS\Bundle\MAPIBundle\Service\DTD\Source;
use SS\Bundle\MAPIBundle\Service\DTD\Document as DTDDocument;

class Entity extends AbstractGenerator
{

	/**
	 *
	 * @param DTDDocument $document        	
	 * @param unknown $outputDirectory        	
	 * @param unknown $namespace        	
	 * @param unknown $parentClass        	
	 */
	public function generate( 
		DTDDocument $document, 
		$outputDirectory, 
		$namespace, 
		$parentClass )
	{

		$items = $document->getEntity();
		$directory = sprintf( $outputDirectory, $document->getFileInfo()
			->getBasename( '.dtd' ) );
		$namespace = sprintf( $namespace, $document->getFileInfo()
			->getBasename( '.dtd' ) );
		$description = str_replace( "\\", " ", $namespace );
		
		if( ! file_exists( $directory ) )
		{
			mkdir( $directory, 0777, true );
		}
		
		foreach( $items as $item )
		{
			$name = sprintf( "%sEntity", Source::camelCase( $item->getName() ) );
			$filename = sprintf( "%s/%s.php", $directory, $name );
			$classDescription = sprintf( "%s %s", $description, $name );
			$datetime = new \DateTime();
			$properties = array( 
				
				(new PropertyGenerator( "name", $item->getName() ))->setDocBlock( 
					new DocBlockGenerator( sprintf( "%s Name", $classDescription ), "", array( 
						new Tag( "var", "string" ) 
					) ) ),
				
				(new PropertyGenerator( "value", $item->getValue() ))->setDocBlock( 
					new DocBlockGenerator( sprintf( "%s Value", $classDescription ), "", array( 
						new Tag( "var", "string" ) 
					) ) ) 
			);
			$docblock = new DocBlockGenerator( 
				$classDescription, 
				"", 
				array( 
					new Tag( "author", "SS MAPIBundle Generator " . $datetime->format( "d.m.Y h:m:s" ) ),
					new Tag( "copyright", "LGPL" ) 
				) );
			
			$fileGenerator = new FileGenerator();
			$fileGenerator->setClass( new ClassGenerator( $name, $namespace, null, $parentClass, array(), $properties, array(), $docblock ) );
			
			file_put_contents( $filename, $fileGenerator->generate() );
		}
	
	}

}