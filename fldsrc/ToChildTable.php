<?php
namespace Servitus\Fldsrc;

/**
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class ToChildTable extends \Servitus\Fldsrc
{

	public function __construct($arrFldsrcData, $arrStepData=null)
	{
		parent::__construct($arrFldsrcData, $arrStepData);

		// resolv sourceFields
		$this->sourceFields = deserialize($this->sourceFields,true);
	}

	public function generate()
	{
		$ret = '';
		$ret .= '<p>';
		$ret .= $GLOBALS['TL_LANG']['Servitus_FldSrcTypes'][$this->type].': <span style="font-weight: bold;">'.$this->childTbl.'.'.$this->childTblFld.'</span>';
		$ret .= '</p>';
		$ret .= '<p>';
		$ret .= $GLOBALS['TL_LANG']['tl_servitus_fldmap']['sourceFields'][0].': '.implode(', ',$this->sourceFields).'<br>';
		if($this->alterData)
		{
			$ret .= $GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterData'][0].': '.$GLOBALS['TL_LANG']['tl_servitus_fldmap']['alterDataRef'][$this->alterData].'<br>';
		}
		if($this->avoidDuplicates)
		{
			$ret .= $GLOBALS['TL_LANG']['tl_servitus_fldmap']['avoidDuplicates'][0].'<br>';
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
		// this Fldsrc is not related to the target-table
		return null;
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
		// respect steps update config
		if($this->getStepValue('useKeyfield') && !$this->getStepValue('updateExisting') && $isUpdated)
		{
			return;
		}

		// collect values
		$arrValues = array();
		foreach($this->sourceFields as $srcFld)
		{
			$val = $this->getSourceValue($srcFld);

			switch($this->splitValues)
			{
				case 'deserialize':
					$arrValues = array_merge($arrValues,deserialize($val,true));
				break;
				case 'comma':
					$arrValues = array_merge($arrValues,trimsplit(',',$val));
				break;
				case 'space':
					$arrValues = array_merge($arrValues,trimsplit(' ',$val));
				break;
				case 'semikolon':
					$arrValues = array_merge($arrValues,trimsplit(';',$val));
				break;

				default:
					$arrValues[] = $val;
				break;
			}
		}


		// strip all values already existing in the child table
		if($this->avoidDuplicates)
		{
			$objExisting = $this->Database->prepare('SELECT '.$this->childTblFld.' FROM '.$this->childTbl.' WHERE pid=?')
							->executeUncached($arrTarget['id']);
			if($objExisting->numRows)
			{
				$arrValues = array_diff($arrValues, $objExisting->fetchEach($this->childTblFld));
			}
		}


		// insert to child table
		foreach($arrValues as $val)
		{
			if(trim($val)=='') continue;

			if($this->alterData)
			{
				$class = 'Servitus\AlterData\\'.$GLOBALS['Servitus_AlterData'][$this->alterData]['class'];
				$objAlterData = new $class($this);
				$val = $objAlterData->getValue($arrSet[$targetFld]);
			}

			$this->Database->prepare('INSERT INTO '.$this->childTbl.' SET pid=?, '.$this->childTblFld.'=?')
							->executeUncached($arrTarget['id'], $val);
		}

		return null;
	}
}