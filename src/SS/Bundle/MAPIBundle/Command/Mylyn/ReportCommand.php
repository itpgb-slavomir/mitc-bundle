<?php
/**
 * SS MAPI Bundle Command Mylyn Report Command
 *
 * @licence GNU GPL
 *
 * @author Slavomir <slavomir.sidor@gmail.com>
 */
namespace SS\Bundle\MAPIBundle\Command\Mylyn;

use SS\Bundle\MAPIBundle\Command\Code\Reflection\ReflectionCommand;
use SS\Bundle\MAPIBundle\Service\Code\Reflection;
use Symfony\Component\Console\Input\InputOption;
use JMS\Serializer\Serializer;
use Psr\Log\LoggerInterface;
use SS\Bundle\MAPIBundle\Service\Table\Table;

class ReportCommand extends ReflectionCommand
{

	/**
	 *
	 * @var Serializer
	 */
	protected $serializer;

	/**
	 * Constructs SS MAPI Bundle Abstract Command
	 *
	 * @param string $name
	 * @param string $description
	 * @param LoggerInterface $logger
	 * @param Reflection $reflection
	 * @param Serializer $serializer
	 */
	public function __construct( $name, $description, LoggerInterface $logger, Table $table, Reflection $reflection, Serializer $serializer )
	{
		parent::__construct( $name, $description, $logger, $table, $reflection );

		$this->setSerializer( $serializer );
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Console\Command\Command::configure()
	 */
	protected function configure()
	{
		parent::configure();

		$outputTypeDefault = "html";
		$outputFileDefault = sprintf( "%s/%s/%s/daily.%s", $_SERVER['HOME'], 'Documents/AP/Pivotal', date( 'Y-m-d' ), $outputTypeDefault );

		$this->addOption( "outputType", "ou", InputOption::VALUE_OPTIONAL, "Report Output type: html|txt.", $outputTypeDefault );
		$this->addOption( "outputFile", "of", InputOption::VALUE_OPTIONAL, "Report Output file.", $outputFileDefault );

		$this->getDefinition()
			->getOption( 'fileSuffix' )
			->setDefault( "context-state.xml" );

		$this->getDefinition()
			->getOption( 'ignoreDotFiles' )
			->setDefault( FALSE );

		/*
		 * $this->getDefinition()
		 * ->getOption( 'date' )
		 * ->setDefault( "since yesterday" );
		 */
		$srcDefault = array(
			sprintf( "%s/domains/.metadata", $_SERVER['HOME'] )
		);

		$this->getDefinition()
			->getArgument( 'src' )
			->setDefault( $srcDefault );
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \SS\Bundle\MAPIBundle\Command\TableCommand::getColumns()
	 */
	protected function getColumns()
	{
		return array(
			'Task ID',
			'Status',
			'Title',
			'Hours',
			'Modified'
		);
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \SS\Bundle\MAPIBundle\Command\TableCommand::getRows()
	 */
	protected function getRows()
	{
		if( null === $this->rows )
		{
			$files = $this->getReflection()
				->getFiles()
				->toArray();

			$outputType = $this->getInput()->getOption( 'outputType' );
			$outputFile = $this->getInput()->getOption( 'outputFile' );

			$xslDir = $this->getContainer()
				->get( 'kernel' )
				->locateResource( '@SSMAPIBundle/Resources/xsl/report' );

			$xslFile = sprintf( "%s/%s.xsl", $xslDir, $outputType );

			$tasks = [];

			foreach( $files as $row )
			{
				$xmldoc = new \DOMDocument();
				$xmldoc->load( $row['File'] );

				$xsldoc = new \DOMDocument();
				$xsldoc->load( $xslFile );

				$xsl = new \XSLTProcessor();
				$xsl->importStyleSheet( $xsldoc );
				$report = $xsl->transformToDoc( $xmldoc );
				$report->save( $outputFile );

				$serializer = $this->getSerializer();
				$task = $serializer->deserialize( $xmldoc->saveXML(), 'SS\Bundle\MAPIBundle\Mylyn\ContextState', 'xml' );

				$tasks[] = $task;
			}

			$this->setRows( $tasks );
		}

		return $this->rows;
	}

	/**
	 *
	 * @return Serializer
	 */
	public function getSerializer()
	{
		return $this->serializer;
	}

	/**
	 *
	 * @param Serializer $serializer
	 */
	public function setSerializer( Serializer $serializer )
	{
		$this->serializer = $serializer;
		return $this;
	}
}