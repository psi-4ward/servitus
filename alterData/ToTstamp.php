<?php
namespace Servitus\AlterData;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class ToTstamp extends \Servitus\AlterData
{

	public function getValue($val)
	{
		if(empty($val) && $val !== 0) return 0;
		$objDate = new \Date($val,$this->dateFormat);
		return $objDate->tstamp;
	}

}