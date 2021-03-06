<?php
namespace SS\Bundle\MAPIBundle\Service\Table\Adapter;

use SS\Bundle\MAPIBundle\Service\Table\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService;

class GoogleSpreedSheet implements IAdapter
{

	/**
	 *
	 * @var string
	 */
	const name = 'GoogleSpreedSheet';

	/**
	 *
	 * @param string $format
	 */
	public function write( Table $table, OutputInterface $output )
	{
		$serviceRequest = new DefaultServiceRequest();
		ServiceRequestFactory::setInstance($serviceRequest);
		$spreadsheetService = new SpreadsheetService();
		$spreadsheetFeed = $spreadsheetService->getSpreadsheetFeed();
	}
}