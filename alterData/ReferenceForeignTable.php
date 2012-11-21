<?php
namespace Servitus\AlterData;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class ReferenceForeignTable extends \Servitus\AlterData
{

	public function getValue($val)
	{
		$objErg = \Database::getInstance()->prepare('SELECT id FROM '.$this->foreignTbl.' WHERE '.$this->foreignField.'=?')
										  ->limit(1)->execute($val);
		if($objErg->numRows)
		{
			return $objErg->id;
		}
		else
		{
			return 0;
		}
	}

}