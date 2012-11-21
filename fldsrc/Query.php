<?php
namespace Servitus\Fldsrc;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class Query extends \Servitus\Fldsrc
{


	public function generate()
	{
		$ret = '';
		if($this->queryToField)
		{
			$ret .= '<p><b>'.$this->targetField.'</b></p>';
		}
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
		if($this->queryToField)
		{
			return $this->targetField;
		}
		else
		{
			return null;
		}
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
		// replace placeholders
		$sqlquery = str_replace('{{sourceID}}',$this->getSourceValue('id'),$this->sqlquery);
		if(isset($arrTarget['id']))
		{
			$sqlquery = str_replace('{{insertID}}',$arrTarget['id'],$sqlquery);
		}

		// execute the query
		$objQry = $this->Database->executeUncached($sqlquery);

		// return the querys first field
		if($this->queryToField)
		{
			$fld = $objQry->fetchField(0);
			$fld = $fld['name'];
			return $objQry->$fld;
		}

		return '';
	}
}