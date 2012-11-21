<?php
namespace Servitus\AlterData;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class PrefixSuffix extends \Servitus\AlterData
{

	public function getValue($val)
	{

		switch($this->position)
		{
			case 'prefix':
				if(!$this->onlyIfNotExists || $this->onlyIfNotExists && substr($val,0,strlen($this->value)) != $this->value)
				{
					$val = $this->value.$val;
				}
			break;
			case 'suffix':
				if(!$this->onlyIfNotExists || $this->onlyIfNotExists && substr($val,-strlen($this->value)) != $this->value)
				{
					$val = $val.$this->value;
				}
			break;
		}

		return $val;
	}
	
}