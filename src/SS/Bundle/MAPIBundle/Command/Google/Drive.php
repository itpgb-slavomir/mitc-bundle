<?php

/**
 * SS MAPI Bundle Google Translator
 *
 * @licence GNU GPL
 *
 * @author Slavomir <slavomir.sidor@gmail.com>
 */
namespace SS\Bundle\MAPIBundle\Command\Google;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;
use SS\Bundle\MAPIBundle\Command\TableCommand;
use SS\Bundle\MAPIBundle\Service\Table\Table;

class Drive extends TableCommand
{
    /**
     *
     * @param string $name
     * @param string $description
     * @param LoggerInterface $logger
     */
	public function __construct($name, $description, LoggerInterface $logger, Table $table)
    {
        parent::__construct ( $name, $description, $logger, $table );
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        parent::configure ();
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
    }
}