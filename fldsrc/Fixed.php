<?php
namespace Servitus\Fldsrc;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class Fixed extends \Servitus\Fldsrc
{


	public function generate()
	{
		$ret = '<p style="font-weight: bold;">'.$this->targetField.'</p>';
		$ret .= '<p>';
		$ret .= $GLOBALS['TL_LANG']['Servitus_FldSrcTypes'][$this->type];
		$ret .= '</p>';

		return $ret;
	}


	/**
	 * Return the field of the target-table
	 * return value of NULL means theres no target field
	 *
	 * @return string
	 */
	public function getField()
	{
		return $this->targetField;
	}


	/**
	 * Return the field of the target-table
	 *
	 * @param array|null $arrTarget The data of the inserted row, only available if the Fldsrc is not related to a targetTbl.field (self::getField() == null)
	 * @param bool $isUpdated true if ithe target-record and not a new one
	 * @return string
	 */
	public function getValue($arrTarget = null, $isUpdated = false)
	{
		return $this->value;
	}
}