<?php

/**
 * SS MAPI Bundle Command Code Abstract Reflection
 *
 * @licence GNU GPL
 *
 * @author Slavomir <slavomir.sidor@gmail.com>
 */
namespace SS\Bundle\MAPIBundle\Command\Code\Reflection;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use SS\Bundle\MAPIBundle\Service\Code\Reflection;
use SS\Bundle\MAPIBundle\Command\TableCommand;
use SS\Bundle\MAPIBundle\Service\Code\Reflection\Settings;
use Psr\Log\LoggerInterface;
use SS\Bundle\MAPIBundle\Service\Table\Table;

class ReflectionCommand extends TableCommand
{

	/**
	 *
	 * @var Reflection
	 */
	protected $reflection;

	/**
	 *
	 * @var Settings
	 */
	protected $reflectionSettings;

	/**
	 * Constructs SS MAPI Bundle Abstract Command
	 *
	 * @param string $name
	 * @param string $description
	 * @param LoggerInterface $logger
	 * @param Table $table
	 * @param Reflection $reflection
	 */
	public function __construct( 
		$name,
		$description,
		LoggerInterface $logger,
		Table $table,
		Reflection $reflection )
	{
		parent::__construct( $name, $description, $logger, $table );

		$this->setReflection( $reflection );
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\Console\Command\Command::configure()
	 */
	protected function configure()
	{
		parent::configure();

		$this->addOption( "bootstrap", "bs", InputOption::VALUE_OPTIONAL,
			"PHP Boostrap File. If you need your own project specific bootrap." );

		/* File Filters */
		$this->addOption( "fileSuffix", "fs", InputOption::VALUE_OPTIONAL,
			"Files filter suffixes for given src, default all and not dot files.", "*.php" );
		$this->addOption( "ignoreDotFiles", "df", InputOption::VALUE_OPTIONAL,
			"Files filter ignore DOT files.", true );
		$this->addOption( "followLinks", "fl", InputOption::VALUE_OPTIONAL, "Files filter follows links.",
			false );
		$this->addOption( "exclude", "ed", InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
			"Files filter excludes directory(ies) from given source" );
		$this->addOption( "--date", "dt", InputOption::VALUE_OPTIONAL,
			"The date must be something that strtotime() is able to parse: 'since yesterday', 'until 2 days ago', '> now - 2 hours', '>= 2005-10-15'" );

		/* Class Filters */
		$this->addOption( "className", "cn", InputOption::VALUE_OPTIONAL,
			"Classes filter name, e.g. '^myPrefix|mySuffix$', regular expression allowed.", NULL );

		$this->addOption( "hasParentClass", "hpc", InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
			"Classes that has parent class" );

		$this->addOption( "parentClass", "pc", InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
			"Classes filter parent Class Name, e.g 'My\Class'" );
		$this->addOption( "isInterface", "ii", InputOption::VALUE_REQUIRED,
			"Classes filter reflects interfaces objects only, (1|0)." );
		$this->addOption( "isTrait", "it", InputOption::VALUE_REQUIRED,
			"Classes filter reflects traits objects only, (1|0)." );
		$this->addOption( "isAbstractClass", "ib", InputOption::VALUE_REQUIRED,
			"Classes filter reflect abstract classes only, (1|0)." );
		$this->addOption( "isFinal", "if", InputOption::VALUE_REQUIRED,
			"Classes filter reflect Final Classes Only, (1|0)." );
		$this->addOption( "implementsInterface", "imi",
			InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
			"Classes filter reflect abstract classes only." );

		/* Attribute Filters */
		$this->addOption( "attributeName", "an", InputOption::VALUE_OPTIONAL,
			"Attributes filter name, e.g. '^myPrefix|mySuffix$', regular expression allowed." );
		$this->addOption( "isTraitAttribute", "ita", InputOption::VALUE_REQUIRED,
			"Attributes filter reflect trait attributes only, possible values are (1|0)." );

		/* Operation Filters */
		$this->addOption( "operationName", "on", InputOption::VALUE_OPTIONAL,
			"Operations filter name, e.g. '^myPrefix|mySuffix$', regular expression allowed.", NULL );
		$this->addOption( "isAbstractOperation", "ia", InputOption::VALUE_REQUIRED,
			"Operations filter reflect abstract Operation Only, possible values are (1|0)." );
		$this->addOption( "isTraitOperation", "ito", InputOption::VALUE_REQUIRED,
			"Operations filter reflect trait operation only, possible values are (1|0)." );

		/* Parameter Filters */
		$this->addOption( "parameterName", "pn", InputOption::VALUE_OPTIONAL,
			"Parameters filter parameter name, e.g. '^myPrefix|mySuffix$', regular expression allowed.", NULL );
		$this->addOption( "parameterRequired", "pr", InputOption::VALUE_OPTIONAL,
			"Parameters filter parameter is required or optional, .", NULL );
		$this->addOption( "parameterDepraceted", "pd", InputOption::VALUE_OPTIONAL,
			"Parameters filter parameter is depricated, .", NULL );

		/* Attributes and Operations Filters */
		$this->addOption( "isPrivate", "ip", InputOption::VALUE_REQUIRED,
			"Attributes and Operations filter reflects private only or exclude it, (1|0)." );
		$this->addOption( "isProtected", "ipr", InputOption::VALUE_REQUIRED,
			"Attributes and Operations filter reflects protected only or exclude it, (1|0)." );
		$this->addOption( "isPublic", "ic", InputOption::VALUE_REQUIRED,
			"Attributes and Operations filter reflects public only or exclude it, (1|0)." );
		$this->addOption( "isStatic", "is", InputOption::VALUE_REQUIRED,
			"Attributes and Operations filter reflects static only or exclude it, (1|0)." );
		$this->addOption( "isDepricated", "id", InputOption::VALUE_REQUIRED,
			"Attributes and Operations filter reflects depricated, (1|0)." );

		/* Trait Filters */

		$this->addOption( "hasTrait", "ht", InputOption::VALUE_REQUIRED,
			"Trait filter reflect only traited classes, possible values are (1|0)." );
		$this->addOption( "hasTraitAttribute", "hta", InputOption::VALUE_REQUIRED,
			"Trait filter reflect only classes with trait attribute, possible values are (1|0)." );
		$this->addOption( "hasTraitProperty", "htp", InputOption::VALUE_REQUIRED,
			"Trait filter reflect only classes with trait property, possible values are (1|0)." );

		$this->addArgument( 'src', InputArgument::IS_ARRAY, 'PHP Source directory',
			array("src/","app/","tests/"
			) );
	}

	/**
	 *
	 * {@inheritdoc}
	 * @see \SS\Bundle\MAPIBundle\Command\TableCommand::execute()
	 */
	public function execute( 
		InputInterface $input,
		OutputInterface $output )
	{
		$src = $input->getArgument( "src" );
		$canContinue = false;

		foreach( $src as $source )
		{
			if( file_exists( $source ) || is_dir( $source ) )
			{
				$canContinue = true;
			}
		}

		if( ! $canContinue )
		{
			$this->writeInfo( sprintf( "Sources '%s' doesn't exists.", implode( "', '", $src ) ), null,
				$output );

			return 0;
		}

		if( $input->hasOption( "bootstrap" ) )
		{
			$bootstrap = $input->getOption( "bootstrap" );

			try
			{
				if( file_exists( $bootstrap ) )
				{
					@require_once $bootstrap;
				}
			}
			catch( \Exception $e )
			{
				$this->writeException( $e, $output );
			}
		}

		return parent::execute( $input, $output );
	}

	/**
	 *
	 * @return Reflection
	 * @todo parametrize reflection settings
	 */
	protected function getReflection()
	{
		return $this->reflection->setSettings( $this->getReflectionSettings() );
	}

	/**
	 *
	 * @param Reflection $reflection
	 */
	protected function setReflection( 
		Reflection $reflection )
	{
		$this->reflection = $reflection;
		return $this;
	}

	/**
	 *
	 * @return Settings
	 */
	protected function getReflectionSettings()
	{
		if( NULL === $this->reflectionSettings )
		{
			$reflectionSettings = Settings::getInstance();

			foreach( $this->getInput()->getArguments() as $name => $value )
			{
				if( NULL !== $value )
				{
					$setter = sprintf( "set%s", ucfirst( $name ) );

					if( method_exists( $reflectionSettings, $setter ) )
					{
						call_user_func( array($reflectionSettings,$setter
						), $value );
					}
				}
			}

			foreach( $this->getInput()->getOptions() as $name => $value )
			{
				if( NULL !== $value )
				{
					$setter = sprintf( "set%s", ucfirst( $name ) );

					if( method_exists( $reflectionSettings, $setter ) )
					{
						call_user_func( array($reflectionSettings,$setter
						), $value );
					}
				}
			}

			$this->setReflectionSettings( $reflectionSettings );
		}

		return $this->reflectionSettings;
	}

	/**
	 *
	 * @param Settings $reflectionSettings
	 */
	protected function setReflectionSettings( 
		Settings $reflectionSettings )
	{
		$this->reflectionSettings = $reflectionSettings;
		return $this;
	}
}