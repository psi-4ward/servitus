<?php
namespace Servitus\Fldsrc;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class TableField extends \Servitus\Fldsrc
{

	public function generate()
	{
		$ret = '<p style="font-weight: bold;">'.$this->targetField.'</p>';
		$ret .= '<p>';
		$ret .= $GLOBALS['TL_LANG']['Servitus_FldSrcTypes'][$this->type].": ".$this->sourceField;
		if($this->alterData)
		{
			$ret .= '<br>'.$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterData'][0].': '.$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterDataRef'][$this->alterData];
		}
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
		$val = $this->getSourceValue($this->sourceField);

		if($this->alterData)
		{
			$class = 'Servitus\AlterData\\'.$GLOBALS['Servitus_AlterData'][$this->alterData]['class'];
			$objAlterData = new $class($this);
			$val = $objAlterData->getValue($val);
		}

		return $val;
	}
}