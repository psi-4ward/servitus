<?php
namespace Servitus;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */

abstract class AlterData extends \Controller
{

	protected $arrData = array();

	/**
	 * Construct the Step
	 * @param \Servitus\Fldsrc $objFldsrc
	 */
	public function __construct($objFldsrc)
	{
		$this->Fldsrc = $objFldsrc;
	}


	/**
	 * Return an Fldsrc-object property
	 *
	 * @param string
	 * @return mixed
	 */
	public function __get($strKey)
	{
		if (isset($this->$strKey))
		{
			return $this->$strKey;
		}

		if (isset($this->Fldsrc->$strKey))
		{
			return $this->Fldsrc->$strKey;
		}

		return null;
	}


	/**
	 * Return the altered value
	 *
	 * @param mixed $varValue The value to alter
	 * @return mixed
	 */
	abstract public function getValue($varValue);

}
