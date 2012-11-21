<?php
namespace Servitus\AlterData;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class Transform extends \Servitus\AlterData
{

	public function __construct($objFldsrc)
	{
		parent::__construct($objFldsrc);

		$tmp = deserialize($this->transformMatrix,true);
		$this->transformMatrix = array();
		foreach($tmp AS $replaceRow)
		{
			$this->transformMatrix[$replaceRow['src']] = $replaceRow['val'];
		}

	}

	public function getValue($val)
	{
		if(array_key_exists($val,$this->transformMatrix))
		{
			return $this->transformMatrix[$val];
		}
		else
		{
			return $val;
		}
	}

}