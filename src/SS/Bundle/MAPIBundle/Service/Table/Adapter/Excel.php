<?php
namespace SS\Bundle\MAPIBundle\Service\Table\Adapter;

use SS\Bundle\MAPIBundle\Service\Table\Table;
use Symfony\Component\Console\Output\OutputInterface;
use PHPExcel\Writer\OpenDocument;
use PHPExcel\Writer\OpenDocument\Content;
use PHPExcel\Spreadsheet;
use PHPExcel\IOFactory;
use Symfony\Component\Console\Helper\TableCell;

class Excel extends AbstractPHPExcel implements IAdapter
{

	/**
	 *
	 * @var string
	 */
	const name = 'Excel';

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \SS\Bundle\MAPIBundle\Service\Table\Adapter\IAdapter::write()
	 */
	public function write( Table $table, OutputInterface $output )
	{
		$this->getSpreadsheet()
			->getProperties()
			->setTitle( $table->getTitle() )
			->setDescription( $table->getDescription() );

		$this->writeHeaders( $table->getHeaders() );
		$this->writeRows( $table->getRows() );

		$writer = IOFactory::createWriter( $this->getSpreadsheet(), 'Excel' );
		$writer->save( 'php://output' );
	}

	protected function writeHeaders( $headers )
	{
		$this->getSpreadsheet()->setActiveSheetIndex( 0 );

		foreach( $headers as $iRow => $columns )
		{
			/* @var $column TableCell */
			foreach( $columns as $iCol => $column )
			{
				$this->getSpreadsheet()
					->getActiveSheet()
					->setCellValueByColumnAndRow( $iCol, $iRow, $column->__toString() );
			}
		}
	}

	protected function writeRows( $rows )
	{
		$iRow = 0;

		foreach( $rows as $columns )
		{
			$iCol = 0;

			foreach( $columns as $column )
			{
				$this->getSpreadsheet()
					->getActiveSheet()
					->setCellValueByColumnAndRow( $iCol, $iRow, $column );

				++ $iCol;
			}

			++ $iRow;
		}
	}
}