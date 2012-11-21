<?php
namespace Servitus\AlterData;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class GenerateHash extends \Servitus\AlterData
{

	public function getValue($val)
	{
		switch($this->hashAlgo)
		{
			case 'md5':
				return md5($val);
			break;

			case 'sha1':
				return sha1($val);
			break;

			case 'contao-password':
				return \Encryption::hash($val);
			break;
		}
	}

}