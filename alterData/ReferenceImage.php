<?php
namespace Servitus\AlterData;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class ReferenceImage extends \Servitus\AlterData
{

	public function __construct($objFldsrc)
	{
		parent::__construct($objFldsrc);
		$this->Database = \Database::getInstance();

		$this->objPath = $this->Database->prepare('SELECT * FROM tl_files WHERE id=?')->execute($this->path);
	}


	public function getValue($val)
	{
		if(!$this->objPath->numRows) return '';

		$objFile = $this->Database->prepare('SELECT id FROM tl_files WHERE path = ?')->execute($this->objPath->path.'/'.$val);
		if($objFile->numRows) return $objFile->id;
		return '';
	}

}